<?php
namespace app\admin\controller;
use think\ValidateCode;
use think\Session;
class Users extends Index
{

	public function login(){

		if(!empty($_POST)){
			$data['username'] = input('name');
			$data['password'] = md5(input('password'));   #加密
			$code = input('code');
			if(strtolower($code) != strtolower(Session('vc'))){
				$this->error('验证码错误');
			}
			$res = db('admin')->where($data)->find();
			if(!empty($res)){
				db('admin')->where('admin_id',$res['admin_id'])->update(['login_time'=> time()]);
				Session('admin',$res);
				$this->success('登录成功','/admin/admin/index');
			}else{
				$this->error('账号或者密码错误');
			}
		}
		return $this->fetch();
	}
	//退出登录
	public function sign_out(){
		Session('admin',null);
		if(empty(Session('admin'))){
			$this->success('退出成功','users/login');
		}
	}
	//验证码
	public function doimg (){
		$Validatecode = new ValidateCode();
		$Validatecode->doimg();
		Session('vc',$Validatecode->getCode());
	}
	/*会员列表*/

	public function user_list (){
		$user_list = db('users')->paginate(10);
		$page = $user_list->render();
		$this->assign('page',$page);
		$this->assign('list',$user_list);
		return $this->fetch();
	}

	/*会员资料修改*/
	public function addedit_user(){
		if($_GET){
			if(!empty($_GET['id'])){
				$id = $_GET['id'];
				$user = db('users')->where('id',$id)->find();
				$this->assign('info',$user);
			}
		}else{
			$id = '';
		}
		if($_POST){
			$file = request()->file('image1');
			if($file){
	        	$info = $file->move(ROOT_PATH . 'public/static' . DS . 'uploads');
	        	if($info){
					if($id){
						$url = db('users')->field('top_img')->where('id',$id)->find();
						@unlink(ROOT_PATH.'public'.$url['top_img']);
					}
		            $img_path = $info->getSaveName();
					$data['top_img'] = '/static/uploads/'.$img_path;
		        }else{
		            // 上传失败获取错误信息
		            $this->error($file->getError());
		        }
		    }
		    $data['mobile'] = $_POST['mobile'];
		    $data['username'] = $_POST['username'];
		    $data['username'] = $_POST['username'];
		    $data['vip_card'] = $_POST['vip_card'];
		    $data['balance'] = $_POST['balance'];
			if(!empty($_POST['password'])){
				$data['password'] = $_POST['password'];
			}
		    $data['add_time'] = time();
		    if(empty($id)){
		    	$resault = db('users')->insert($data);
		    }else{
		    	$resault = db('users')->where('id',$id)->update($data);
		    }
		    if($resault){
		    	$this->success('成功',url('users/user_list'));
		    }else{
		    	$this->error('失败');
		    }
		}
		$ret = vip_card();
		$this->assign('card',$ret);
		return $this->fetch();
	}

	/*删除用户*/
	public function del_user(){
		$idarr = input()['id'];
		$res = array('code' => -1,'msg' => '');
		if(!empty($idarr)){
			if(is_array($idarr)){
				foreach ($idarr as $key => $value) {
					$resault = db('users')->where('id',$value)->delete();
				}
			}else{
				$resault = db('users')->where('id',$idarr)->delete();
			}
			if($resault){
				$res = array('code' => 1,'msg' => '删除成功');
			}else{
				$res = array('code' => 2,'msg' => '失败');
			}
		}else{
			$res = array('code' => 3,'msg' => '请选择要删除的内容');
		}
		return $res;
	}
}

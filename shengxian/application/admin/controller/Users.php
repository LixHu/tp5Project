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
				$ldata['admin_id'] = $res['admin_id'];
				$ldata['log_info'] = '登录';
				$ldata['log_ip'] = $_SERVER['REMOTE_ADDR'];
				$ldata['log_url'] = request()->url(true);
				$ldata['log_time'] = time();
				db('admin_log')->insert($ldata);
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
		if(!empty($_GET['id'])){
			$id = $_GET['id'];
			$user = db('users')->where('user_id',$id)->find();
			$this->assign('info',$user);
		}else{
			$id = '';
		}
		if($_POST){
			$file = request()->file('image1');
			if($file){
	        	$info = $file->move(ROOT_PATH . 'public/static' . DS . 'uploads');
	        	if($info){
					if($id){
						$list = db('users')->where('user_id ='.$id)->find();
						@unlink(ROOT_PATH .'public'.$list['heard_img']);
					}
		            $img_path = $info->getSaveName();
					$data['heard_img'] = '/static/uploads/'.$img_path;
		        }else{
		            // 上传失败获取错误信息
		            echo $file->getError();
		        }
		    }
			$password = $_POST['password'];										#密码
			$password2 = $_POST['password2'];									#确认密码
			if ($password && $password == $password2 && md5($password) == $user['password']) {
				$data['password'] = md5($password);
			}else{
				if ($password != '') {
					$this->error('确认密码正确');
				}
			}
		    $data['mobile'] = $_POST['mobile'];									#手机号
		    // $data['username'] = $_POST['username'];							#用户名
		    $data['nickname'] = $_POST['nickname'];								#昵称
		    $data['birth_day'] = strtotime($_POST['birth_day']);				#生日
		    $data['vip_lv'] = $_POST['vip_lv'];									#会员级别
		    $data['balance'] = $_POST['balance'];								#余额
		    if(empty($id)){
			 	$data['add_time'] = time();										#添加时间
		    	$resault = db('users')->insert($data);
		    }else{
		    	$resault = db('users')->where('user_id',$id)->update($data);
		    }
		    if($resault){
		    	$this->success('成功',url('users/user_list'));
		    }else{
		    	$this->error('失败');
		    }
		}
		$ret = vip_lv(false);
		$this->assign('vip',$ret);
		return $this->fetch();
	}

	/*
	* 积分余额管理
	*/
	public function addedit_integral()
	{
		if ($_GET) {
			$id = $_GET['id'];
			$integral = db('users')->where('user_id = '.$id)->find();
			$this->assign('info',$integral);
		}else{
			$this->error('用户编号有误');
		}
		if ($_POST) {
			$balance = $_POST['balance'];
			$inte = $_POST['integral'];
			if($balance != ''){
				$data['balance'] = $balance;
			}
			if($inte != ''){
				$data['integral'] = $inte;
			}
			$res = db('users')->where('user_id = '.$id)->update($data);
			if($res){
				$this->success('修改成功','users/user_list');
			}else{
				$this->error('失败');
			}
		}

		return $this->fetch();
	}

	/*删除用户*/
	public function del_user(){
		$idarr = input()['id'];
		$res = array('code' => -1,'msg' => '');
		if(!empty($idarr)){
			if(is_array($idarr)){
				foreach ($idarr as $key => $value) {
					$resault = db('users')->where('user_id',$value)->delete();
				}
			}else{
				$resault = db('users')->where('user_id',$idarr)->delete();
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

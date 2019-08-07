<?php
namespace app\admin\controller;

class Admin extends Index
{
	/*主页*/
	public function index(){
		if(!empty(Session('admin'))){
			$list = db('admin_left')
					->alias('a')
					->join('role_left b','b.left_id = a.id')
					->join("admin_role c",'b.role_id = c.role_id')
					->where('pid = 0 and is_show = 1 and c.role_id = '.Session('admin')['role_id'])
					->order(' sort asc')
					->select();
			foreach($list as $key => $val){
				$c_list = db('admin_left')->where('pid = '.$val['id'] .' and is_show = 1')->select();
				$list[$key]['children'] = $c_list;
			}
			$this->assign('list',$list);
		}else{
			$this->redirect('Users/login');
		}
		return $this->fetch();
	}
	/*管理员列表*/
	public function admin_list(){
		$admin = db('admin')
				->alias('a')
				->field('a.admin_id,a.username,a.nickname,b.role_name,a.login_time')
				->join('admin_role b',' a.role_id = b.role_id')
				->paginate(10);
		$page = $admin->render();
		$this->assign('page',$page);
		$this->assign('admin',$admin);
		return $this->fetch();
	}
	//更新添加管理员
	public function addedit_admin(){
		$role = db('admin_role')->select();
		$id = '';
		if (!empty($_GET['admin_id'])) {
			$id = $_GET['admin_id'];
			if($id){
				$info = db('admin')->where('admin_id',$id)->find();
			}else{
				$info = [];
			}
			$this->assign('info',$info);
		}
		if(!empty($_POST)){
			$file = request()->file('image1');
			if($file){
	        	$info = $file->move(ROOT_PATH . 'public/static' . DS . 'uploads');
	        	if($info){
		            // 成功上传后 获取上传信息
		            $img_path = $info->getSaveName();
					$data['heard_img'] = '/static/uploads/'.$img_path;
		        }else{
		            // 上传失败获取错误信息
		            echo $file->getError();
		        }
		    }
			$data['nickname'] = $_POST['nickname'];
		    $data['username'] = $_POST['username'];
		    $data['password'] = md5($_POST['password']);
		    $data['mobile'] = $_POST['mobile'];
			$data['role_id'] = $_POST['role_id'];
		    if($id){
		    	$resault = db('admin')->where('admin_id',$id)->update($data);
		    }else{
		    	$resault = db('admin')->insert($data);
		    }
		    if($resault){
		    	$this->success('成功');
		    }else{
		    	$this->error('失败');
		    }
		}
		$this->assign('role',$role);
		return $this->fetch();
	}
	/*删除管理员*/
	public function del_admin(){
		$idarr = input()['id'];

		$res = array('code' => -1,'msg' => '');
		if(!empty($idarr)){
			if(is_array($idarr)){
				foreach ($idarr as $key => $value) {
					$resault = db('admin')->where('admin_id',$value)->delete();
				}
			}else{
				$resault = db('admin')->where('admin_id',$idarr)->delete();
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
	/*删除角色*/
	public function del_role(){
		$idarr = input()['id'];
		$res = array('code' => -1,'msg' => '');
		if(!empty($idarr)){
			if(is_array($idarr)){
				foreach ($idarr as $key => $value) {
					db('role_left')->where('role_id ='.$value)->delete();
					$resault = db('admin_role')->where('role_id',$value)->delete();
				}
			}else{
				db('role_left')->where('role_id ='.$idarr)->delete();
				$resault = db('admin_role')->where('role_id',$idarr)->delete();
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
	/*角色权限列表*/
	public function role_list(){
		$role = db('admin_role')->select();
		$this->assign('role',$role);
		return $this->fetch();
	}

	/*角色添加*/
	public function add_role(){
		$role = db('admin_role')->select();
		$left_list = db('admin_left')->where('pid = 0 and is_show = 1')->select();
		foreach($left_list as $key => $val){
			$children = db('admin_left')->where('is_show = 1 and pid = '.$val['id'])->select();
			if(!empty($children)){
				$left_list[$key]['children'] =	$children;
			}
		}
		//添加角色，添加角色权限
		if($_POST){

			$id = db('admin_role')->insert(array("role_name" => input('role_name')));

			$lastid = db('admin_role')->getLastInsID();
			$data['role_id'] = $lastid;
			if(!empty(input()['leftid'])){
				$leftid = input()['leftid'];
				foreach($leftid as $k => $v){
					$data['left_id'] = $v;
					$have = db('role_left')->where($data)->find();
					if(empty($have) && $data['role_id'] != 0){
						$resault = db('role_left')->insert($data);
					}
				}
				$resault = $id;
			}
			if($id){
				$this->success('角色添加成功',url('admin/role_list'));
			}
		}
		$this->assign('left',$left_list);
		$this->assign('role',$role);
		return $this->fetch();
	}
	/*权限管理*/
	public function role(){
		$role = db('admin_role')->select();
		$left_list = db('admin_left')->where('pid = 0 and is_show = 1')->select();
		foreach($left_list as $key => $val){
			$children = db('admin_left')->where('is_show = 1 and pid = '.$val['id'])->select();
			if(!empty($children)){
				$left_list[$key]['children'] =	$children;
			}
		}
		if(!empty($_GET)){
			//根据id找到权限显示出来
			$role_name = db('admin_left')
				->alias('a')
				->field('a.id')
				->join('role_left b','b.left_id = a.id')
				->join("admin_role c",'b.role_id = c.role_id')
				->where('is_show = 1 and c.role_id = '.$_GET['id'])
				->select();
			$role_id = db('admin_role')->find($_GET['id']);
			$this->assign('role_id',$role_id);
			$this->assign('role_name',$role_name);
		}
		// 提交表单
		if($_POST){
			$data['role_id'] = input('role_id');
			if(!empty(input()['leftid'])){
				$leftid = input()['leftid'];
				db('role_left')->where($data)->delete();
				foreach($leftid as $k => $v){
					$data['left_id'] = $v;
					$have = '';
					if(empty($have) && $data['role_id'] != 0){
						$resault = db('role_left')->insert($data);
					}
				}
			}else{
				$resault = '';
			}
			if($resault){
				$this->success('权限添加成功');
			}
		}
		$this->assign('left',$left_list);
		$this->assign('role',$role);
		return $this->fetch();
	}

	/*右侧页面*/
	public function right(){
		$stime = strtotime(date('Y-m-d'));
		$etime = time();
		$info = [];
		$info['php_ver'] = PHP_VERSION;
		$info['mysql_ver'] = db()->query('select VERSION() as version')[0]['version'];
		$info['max_upload'] = ini_get('file_uploads') ? ini_get('upload_max_filesize') : "Disabled";
		$info['ser'] = $_SERVER["SERVER_SOFTWARE"];
		$info['role'] = db('admin')->alias('a')->join('admin_role b','a.role_id = b.role_id')->where('admin_id ='.Session('admin')['admin_id'])->find()['role_name'];
		$info['goods_count'] = db('goods')->count();
		$info['order_count'] = db('order')->count();
		$info['user_count'] = db('users')->count();
		$info['today_user'] = db('users')->where('add_time between \''.$stime.'\' and \''.$etime.'\'')->count();
		$info['_order'] = db('order')->where('order_status = 2')->select();
		$tj_count = db('goods')->where('is_recommend = 1')->count();
		$od_count = db('order')->where('order_status = 2')->count();
		$cat_count = db('goods_category')->where('is_show = 1')->count();
		$num = 0;
		if($od_count){
			$num++;
		}
		if($tj_count < 4){
			$num++;
		}
		if($cat_count < 8){
			$num++;
		}
		$info['tixing'] = $num;
		$this->assign('info',$info);
		return $this->fetch();
	}
	/*
	*  提醒事项
	*/
	public function tixing (){
		if($_POST){
			$admin_id = $_POST['admin_id'];
			$str = '<table class="layui-table" lay-even lay-skin="nob" style="text-align:center;">';
			$cat_count = db('goods_category')->where('is_show = 1')->count();
			$tj_count = db('goods')->where('is_recommend = 1')->count();
			$od_count = db('order')->where('order_status = 2')->count();
			if($cat_count < 8){
				$str .= '<tr>';
				$str .= '<td>商品分类显示数量不足八个</td>';
				$str .= '<td><a href="'.url('goods/goods_cat').'" target="right">前往设置 </a>';
				$str .= '</tr>';
			}else if($tj_count < 4){
				$str .= '<tr>';
				$str .= '<td>推荐商品不足4个</td>';
				$str .= '<td><a href="'.url('goods/goods_list').'" target="right">前往设置 </a>';
				$str .= '</tr>';
			}else if($od_count){
				$str .= '<tr>';
				$str .= '<td>有'.$od_count.'个订单待发货</td>';
				$str .= '<td><a href="'.url('order/order_list').'" target="right">前往处理 </a>';
				$str .= '</tr>';
			}else{
					$str .= '<tr>';
					$str .= '<td rowspan="2">暂无提醒事项</td>';
					$str .= '</tr>';
			}
			// if($flag && $flag1){

			// }

			$str .= '</table>';
			return $str;
		}
	}
}

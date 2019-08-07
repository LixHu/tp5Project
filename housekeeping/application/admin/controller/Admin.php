<?php
namespace app\admin\controller;

class Admin extends Index
{
	/**/
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
		if ($_GET) {
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
					if($id){
						$url = db('admin')->field('heard_img')->where('admin_id',$id)->find();
						@unlink(ROOT_PATH .'public'. $url['heard_img']);
					}
		            $img_path = $info->getSaveName();
					$data['heard_img'] = '/static/uploads/'.$img_path;
		        }else{
		            // 上传失败获取错误信息
		           $this->error($file->getError());
		        }
		    }
		    $data['username'] = $_POST['username'];
		    $data['mobile'] = $_POST['mobile'];
			$data['role_id'] = $_POST['role_id'];
			if(!empty($_POST['password'])){
				$data['password'] = md5($_POST['password']);
			}
		    if($id){
				$session = $data;
				$session['admin_id'] = $id;
				Session('admin',$session);
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

	/*右侧页面*/
	public function right(){
		$stime = strtotime(date("Y-m-d"));
		$etime = time();
		$info['ocount'] = db('order')->where('add_time between \''.$stime.'\' and \''.$etime.'\'')->count();
		$info['gcount'] = db('position_info')->count();
		$info['ucount'] = db('users')->count();
        $info['php_ver'] = PHP_VERSION;
        $info['mysql_ver'] = db()->query('select VERSION() as version')[0]['version'];
        $info['max_upload'] = ini_get('file_uploads') ? ini_get('upload_max_filesize') : "Disabled";
        $info['ser'] = $_SERVER["SERVER_SOFTWARE"];
		$info['role'] = db('admin')->alias('a')->join('admin_role b','a.role_id = b.role_id')->where('admin_id ='.Session('admin')['admin_id'])->cache(true,600)->find()['role_name'];
		$info['today_user'] = db('users')->where('add_time between \''.$stime.'\' and \''.$etime.'\'')->count();
		$num = 0;
		$yuyuec = db('order')->where('is_reserve =1 and order_status = 1 and add_time between '.$stime.' and '.$etime)->count();
		if($yuyuec) {
			$num++;
		}
		$info['remind'] = $num;
		$this->assign('info',$info);
		return $this->fetch();
	}
	/*角色权限列表*/
	public function role_list(){
		$role = db('admin_role')->select();
		$this->assign('role',$role);
		return $this->fetch();
	}
	/*
	*  提醒事项
	*/
	public function tixing (){
		if($_POST){
			$admin_id = $_POST['admin_id'];
			$str = '<table class="layui-table" lay-even lay-skin="nob" style="text-align:center;">';
			$stime = strtotime(date('Y-m-d'));
			$etime = time();
			$yuyuec = db('order')->where('is_reserve =1 and order_status = 1 and add_time between '.$stime.' and '.$etime)->count();
			// echo $yuyuec;
			$flag = true;
			if($yuyuec){
				$str .= '<tr>';
				$str .= '<td>今日有'.$yuyuec.'个订单未处理</td>';
				$str .= '<td><a href="'.url('order/order_list').'" target="right"> 前去处理</a></td>';
				$str .= '</tr>';
				$flag = false;
			}
			if($flag){
				$str .= '<tr>';
				$str .= '<td rowspan="2">暂无提醒事项</td>';
				$str .= '</tr>';
			}
			$str .= '</table>';
			return $str;
		}
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
}

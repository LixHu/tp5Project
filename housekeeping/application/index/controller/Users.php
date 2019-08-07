<?php

namespace app\index\controller;

class Users extends Index
{
	/*
	 *用户登录
	 	*/
	public function login(){
		$pt = file_get_contents("php://input");
		$arr=json_decode($pt,true);
		$mobile = $arr['mobile'];
		$password = md5($arr['password']);
		#preg_match('/^1[34578]\d{9}$/',$mobile)
		#$code 短信验证码
		if(!empty($arr)){
			$info = db('users')->where('mobile = '.$mobile.' and password = \''.$password.'\'')->find();
			if(!empty($info)){
				$res['code'] = 1;
				$res['msg'] = '登录成功';
				$info['top_img'] = trim($info['top_img']);
				$res['data'] = $info;
				db('users')->where('id',$info['id'])->update(['login_time' => time()]);
			}else{
				$res['code'] = 2;
				$res['msg'] = '手机号或密码错误';
			}
		}
		return json_encode($res);
	}
	/*
	 * 注册
	 */
	public function reg (){
		$pt = file_get_contents("php://input");
		$arr=json_decode($pt,true);
		if (!empty($arr)) {
			$data['mobile'] = $arr['mobile'];
			$data['top_image'] = '/static/img/head.png';
			$data['password'] = md5($arr['password']);
			$data['username'] = $arr['mobile'];
			$data['add_time'] = time();
			$code = $arr['code'];
			if($code == Session($arr['mobile'])){
				Session($arr['mobile'],null);
				$count = db('users')->where('mobile',$data['mobile'])->count();
				if($count){
					$num = 0;
				}else{
					$num = db('users')->insert($data);
				}
				if($num){
					$user = db('users')->where('id',$num)->find();
					Session('user',$user);
					$res = array('code' => 1,'msg' => '注册成功');
				}else{
					$res = array('code' => 1,'msg' => '手机号已经存在');
				}
			}else{
				$res = array('code' => 2,'msg' => '验证码有误');
			}
		}else{
			$res = array('code' => -1,'msg' => '请填写表单');
		}
		return json_encode($res);
	}
	/*
	 * 忘记密码
	 */
	public function forget_pos(){
		$pt = file_get_contents("php://input");
		$arr=json_decode($pt,true);
		if (!empty($arr)) {
			$code = $arr['code'];
			$mobile = $arr['mobile'];
			$data['password'] = md5($arr['password']);
			$info = db('users')->where('mobile = '.$mobile)->find();
			if(!empty($info) && $code == Session($arr['mobile'])){
				Session($arr['mobile'],null);
				$up = db('users')->where('mobile = '.$mobile)->update($data);
				if($up){
					$res = array('code' => 1,'msg' => '修改成功');
				}else{
					$res = array('code' => 2,'msg' => '失败');
				}
			}else{
				$res = array('code' => 2,'msg' => '手机号不存在');
				if ($code != '1234') {
					$res = array('code' => 2,'msg' => '验证码有误');
				}
			}
		}else{
			$res = array('code' => -1,'msg' => '请填写表单');
		}
		return json_encode($res);
	}
	/*
	 * 用户信息
	 */
	public function info(){
		$pt = file_get_contents("php://input");
		$arr=json_decode($pt,true);
		if(!empty($arr)){
			if(!empty($arr['user_id'])){
				$user_id = $arr['user_id'];
				$info = db('users')->field('id,top_img,mobile,sex,address,vip_card,balance')->where('id = '.$user_id)->find();

				$res = array('code' => 1,'data' => $info);
			}else{
				$res = array('code' => '2','msg' => '缺少用户编号');
			}
		}else{
			$res = array('code' => '-1','msg' => '参数有误');
		}
		return json_encode($res);
	}
	/*
	*   更改用户信息
	*/
	public function edit_user()
	{
		$pt = file_get_contents('php://input');
		$arr = json_decode($pt,true);
		if(!empty($arr)){
			$flag = true;
			if(empty($arr['user_id'])){
				$flag = false;
			}
			if($flag){
				$user_id = $arr['user_id'];
				if(!empty($arr['sex'])){
					$data['sex'] = $arr['sex'];
				}
				if(!empty($arr['name'])){
					$data['name'] = $arr['name'];
				}
				if(!empty($data)){
					$ret = db('users')->where('id ='.$user_id)->update($data);
				}
				if($ret){
					$res = array('code' => '1','msg' => '成功');
				}else{
					$res =array('code' => 2,'msg' => '失败');
				}
			}else{
				$res = array('code' => 2,'msg' => '失败');
			}
			return json_encode($res);
		}
	}
	/*
	*   获取地址列表
	*/
	public function add_list()
	{
		$pt = file_get_contents('php://input');
		$arr = json_decode($pt,true);
		if(!empty($arr)){
			$flag = true;
			if(empty($arr['user_id'])){
				$flag = false;
			}
			if($flag){
				$user_id = $arr['user_id'];
				//,province,city,area
				$add_list = db('user_address')->field('ad_id,name,mobile,add,is_default')->where('user_id = '.$user_id)->select();
				if(!empty($add_list)){
					$res = array('code' => 1,'data'	=>	$add_list );
				}else{
					$res = array('code' => 2,'msg' => '暂无');
				}
			}else{
				$res = array('code' => 2,'msg' => '失败');
			}
			return json_encode($res);
		}
	}
	/*
	*   添加地址
	*/
	public function edit_add(){
		$pt = file_get_contents('php://input');
		$arr = json_decode($pt,true);
		if(!empty($arr)){
			$flag = true;
			if(empty($arr['user_id']) && empty($arr['name']) && empty($arr['mobile']) && empty($arr['add'])){
				$flag = false;
			}
			if($flag){
				$data['user_id'] = $arr['user_id'];
				$data['name'] = $arr['name'];
				$data['mobile'] = $arr['mobile'];
				$data['add'] = $arr['add'];
				if(!empty($arr['ad_id'])){
					$where['ad_id'] = $arr['ad_id'];
				}
				// $area = $arr['area'];
				// $area_list = explode(' ',$area);
				// $data['province'] = $area_list[0];
				// $data['city'] = $area_list[1];
				// $data['area'] = $area_list[2];
				$hav = db('user_address')->where('user_id = '.$data['user_id'])->count();
				if($hav == 0){
					$data['is_default'] = 1;
				}else{
					if(empty($arr['ad_id'])){
						$data['is_default'] = 2;
					}
				}
				if($hav+1 > 5 && empty($arr['ad_id'])){
					$msg = '地址不能超过五个';
					$ret = '';
				}else{
					if(!empty($where)){
						$ret = db('user_address')->where($where)->update($data);
						if($ret){
							$msg = '修改成功';
						}else{
							$msg = '失败';
						}
					}else{
						$ret = db('user_address')->insert($data);
						if($ret){
							$msg = '添加成功';
						}else{
							$msg = '失败';
						}
					}
				}
				if($ret){
					$res = array('code' => 1,'msg' => $msg);
				}else{
					$res = array('code' => 2,'msg' => $msg);
				}
			}else{
				$res = array('code' => 1,'msg' => '缺少参数');
			}
			return json_encode($res);
		}
	}
	/*
	*   删除地址
	*/
	public function del_add()
	{
		$pt = file_get_contents('php://input');
		$arr = json_decode($pt,true);
		if(!empty($arr)){
			$flag = true;
			if(empty($arr['user_id']) && empty($arr['ad_id'])){
				$flag = false;
			}
			if($flag){
				$where['user_id'] = $arr['user_id'];
				$where['ad_id'] = $arr['ad_id'];
				$ret = db('user_address')->where($where)->delete();
				if($ret){
					$res = array('code' => 1,'msg' => '删除成功');
				}else{
					$res = array('code' => 2,'msg' => '删除失败');
				}
			}
			return json_encode($res);
		}
	}
	/*
	*   修改默认地址
	*/
	public function edit_default()
	{
		$pt = file_get_contents('php://input');
		$arr = json_decode($pt,true);
		if(!empty($arr)){
			$flag = true;
			$res = [];
			if(empty($arr['user_id']) && empty($arr['ad_id'])){
				$flag = false;
			}
			if($flag){
				$user_id = $arr['user_id'];
				$ad_id = $arr['ad_id'];
				db('user_address')->where('user_id =' .$user_id)->update(['is_default' => '2']);
				$ret = db('user_address')->where('user_id =' .$user_id.' and ad_id ='.$ad_id)->update(['is_default' => '1']);
				if($ret){
					$res = array('code' => 1,'msg' => '修改成功' );
				}else{
					$res = array('code' => 2 ,'msg' => '失败' );
				}
			}else{
				$res = array('code' => 2,'msg' => '缺少参数' );
			}
			return json_encode($res);
		}
	}
	/*
	 * 修改个人头像base64
	 */
	 public function upload_base()
	 {
 		$pt = file_get_contents("php://input");
 		$arr=json_decode($pt,true);
		if(!empty($arr)){
			$ret = [];
			if(!empty($arr['image'])){
				$base = $arr['image'];
			}else{
				$base = '';
			}
			$data['id'] = $arr['user_id'];
			$upload_url = ROOT_PATH . 'public/static' . DS . 'uploads/header/';
			$ret = base_upload($upload_url,$base);
			if($ret['code'] == 1){
				$url = db('users')->field('top_img')->where('id',$data['id'])->find();
				@unlink(str_replace(' ','',ROOT_PATH.'public'.$url['top_img']));
				$data['top_img'] = $ret['url'];
		    	$status = db('users')->where('id',$data['id'])->update($data);
				if($status){
		    		$res = array('code' =>  1,'msg' => '修改成功','url' => $data['top_img']);
		    	}else{
		    		$res = array('code' =>  2,'msg' => '失败');
		    	}
			}else{
				$res = $ret;
			}
		}
		return json_encode($res);
	 }
	/*
	*  修改手机号
	*/
	public function edit_mobile(){
		$pt = file_get_contents("php://input");
		$arr=json_decode($pt,true);
		if(!empty($arr))
		{
			$flag = true;
			if(!empty('old_mobile')){
				$old_mobile = $arr['old_mobile'];
			}else{
				$flag = false;
				$msg = '旧手机号码必须';
			}
			if(!empty('new_mobile')){
				$new_mobile = $arr['new_mobile'];
			}else{
				$flag = false;
				$msg = '新手机号码必须';
			}
			if(!empty('code')){
				$code = $arr['code'];
			}else{
				$flag = false;
				$msg = '验证码必须';
			}
			if($flag){
				if ($code == Session($arr['new_mobile'])) {
					$hav = db('users')->where('mobile = '.$old_mobile)->find();
					if(!empty($hav)){
						$ret = db('users')->where('mobile = '.$old_mobile)->update(['mobile' => $new_mobile]);
						if($ret){
							$res = array('code' => 1,'msg' => '修改成功');
						}else{
							$res = array('code' => 2,'msg' => '失败');
						}
					}else {
						$res = array('code' => 2, 'msg' => '手机号不正确');
					}
				}else {
					$res = array('code' => 2,'msg' => '验证码错误');
				}
			}else{
				$res = array('code' => 2,'msg' => $msg);
			}
		}
		return json_encode($res);
	}
	//常见问题
	public function problem()
	{
		$pt = file_get_contents("php://input");
		$arr=json_decode($pt,true);


		$problem = db('problem')->field('id,content')->where('pid = 0 and is_show = 1')->select();
		foreach($problem as $key => $val){
			$answer = db('problem')->field('id,content')->where('pid ='.$val['id'].' and is_show = 1')->find();
			$problem[$key]['answer'] =$answer;
		}
		if(!empty($problem)){
			$res = array('code' => 1,'data' => $problem);
		}else{
			$res = array('code' => 2, 'msg' => '暂无信息');
		}
		return json_encode($res);
	}
}

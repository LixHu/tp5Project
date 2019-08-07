<?php

namespace app\index\controller;


class Users extends Index
{
	/*
	 * 注册
	 */
	public function reg(){
		$pt = file_get_contents("php://input");
		$arr=json_decode($pt,true);
		if (!empty($arr)) {
			$data['mobile'] = $arr['mobile'];
			$code  = $arr['code'];							#短信验证码
			$data['nickname'] = $arr['mobile'];
			$data['password'] = md5($arr['password']);
			$data['heard_img'] = '/public/static/uploads/header/default.jpg';
			$data['add_time'] = time();
			$coun = db('users')->where('mobile',$arr['mobile'])->count();
			if($code == Session($arr['mobile'])){
				Session($arr['mobile'],null);
				if($coun){
					$res = array('code' => 2 ,'msg' => '手机号码已存在');
				}else{
					$ins = db('users')->insert($data);
					if($ins){
						$res = array('code' => 1 ,'msg' => '注册成功');
					}else{
						$res = array('code' => 2 ,'msg' => '失败');
					}
				}
			}else{
				$res = array('code' => 2 ,'msg' => '短信验证码有误');
			}
		}else{
			$res = array('code' => -1 ,'msg' => '填写表单');
		}
		return json_encode($res);
	}
	/*
	 * 登录
	 */
	public function login(){
		$pt = file_get_contents("php://input");
		$arr=json_decode($pt,true);
		if(!empty($arr)){
			$data['mobile'] = $arr['mobile'];
			$data['password'] = md5($arr['password']);
			$ret = db('users')->field('user_id')->where($data)->find();
			if(empty($ret)){
				$res = array('code' => 2 ,'msg' => '用户名或者密码错误');
			}else{
				$res = array('code' => 1 ,'msg' => '登录成功','data' => $ret);
			}
		}else{
			$res = array('code' => -1 ,'msg' => '填写表单');
		}
		return json_encode($res);
	}
	/*
	 * 获取个人信息
	 */
	public function get_info(){
		$pt = file_get_contents("php://input");
		$arr=json_decode($pt,true);
		if (!empty($arr)) {
			$id = $arr['user_id'];
			$status = db('users')->field('user_id,nickname,sex,heard_img,birth_day,balance,vip_lv,mobile')->where('user_id',$id)->find();
			if ($status) {
				if(!empty($status['birth_day'])){
					$status['birth_day'] = date("Y-m-d",$status['birth_day']);
				}else{
					$status['birth_day'] = '';
				}
				$res = array('code' => 1 ,'data' => $status);
			}else{
				$res = array('code' => 1 ,'msg' => '无结果');
			}
		}else{
			$res = array('code' => -1 ,'msg' => 'id错误');
		}
		return json_encode($res);
	}
	/*
	 * 修改个人头像
	 */
	public function edit_header_img(){

    	$file = request()->file('image');
	    if($file){
	        $info =  $file->validate(['size'=>2097152,'ext'=>'jpg,png,gif'])->move(ROOT_PATH . 'public/static' . DS . 'uploads/header');
	        if($info){
		      	$img_path = $info->getSaveName();
	            $data['heard_img'] = '/static/uploads/header/'.$img_path;
	        }else{
	            // 上传失败获取错误信息
	           $res = $file->getError();
	        }
	    }else{
	    	$data = [];
	    	$res = array('code' =>  -1,'msg' => '请上传图片');
	    }
	    $id = $_POST['user_id'];
	    if(!empty($data)){
			$url = db('users')->field('heard_img')->where('user_id',$id)->find();
			@unlink(ROOT_PATH.'public'.$url['heard_img']);
	    	$status = db('users')->where('user_id',$id)->update($data);
	    	if($status){
	    		$res = array('code' =>  1,'msg' => '修改成功','url' => $data['heard_img']);
	    	}else{
	    		$res = array('code' =>  2,'msg' => '失败');
	    	}
	    }
	    return json_encode($res);
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
			$data['user_id'] = $arr['user_id'];
			$upload_url = ROOT_PATH . 'public/static' . DS . 'uploads/header/';
			$ret = base_upload($upload_url,$base);
			if($ret['code'] == 1){
				$url = db('users')->field('heard_img')->where('user_id',$data['user_id'])->find();
				@unlink(ROOT_PATH.'public'.$url['heard_img']);
				$data['heard_img'] = $ret['url'];
		    	$status = db('users')->where('user_id',$data['user_id'])->update($data);
				if($status){
		    		$res = array('code' =>  1,'msg' => '修改成功','url' => $data['heard_img']);
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
	 * 修改个人信息
	 */
	public function edit_info(){
		$pt = file_get_contents("php://input");
		$arr=json_decode($pt,true);
		if (!empty($arr)) {
			if(!empty($arr['user_id'])){
				$id = $arr['user_id'];
			}else{
				$res = array('code' => 2 ,'msg' => '缺少用户编号');
				return json_encode($res);
			}
			$data = [];
			if(!empty($arr['nickname'])){
				$data['nickname'] = $arr['nickname'];
			}
			if(!empty($arr['birth_day'])){
				$data['birth_day'] = strtotime($arr['birth_day']);
			}
			if(!empty($arr['sex'])){
				$data['sex'] = $arr['sex'];
			}
			if(!empty($data)){
				$status = db('users')->where('user_id',$id)->update($data);
				if($status){
	    			$res = array('code' =>  1,'msg' => '修改成功');
				}else{
					$ret = db('users')->where('user_id',$id)->find();
					if($ret){
	    				$res = array('code' =>  2,'msg' => '没做任何变动');
					}else{
	    				$res = array('code' =>  2,'msg' => '用户编号错误');
					}
	    			$res = array('code' =>  2,'msg' => '失败');
				}
			}else{
				$res = array('code' =>  2,'msg' => '失败');
			}
		}else{
			$res = array('code' =>  -1,'msg' => '请填写表单');
		}
		return json_encode($res);
	}

	/*
	 * 获取用户地址
	 */
	public function get_address(){
		$pt = file_get_contents("php://input");
		$arr=json_decode($pt,true);
		if(!empty($arr)){
			$id = $arr['user_id'];
			$add_list = db('user_address')->field('ad_id,ad_name,ad_mobile,is_default,ad_address')->where('user_id',$id)->select();
			if(!empty($add_list)){
				$res = array('code' => 1, 'data' => $add_list);
			}else{
				$res = array('code' => 2, 'msg' => '暂无');
			}
		}else{
			$res = array('code' => -1, 'msg' => '用户编号错误');
		}
		return json_encode($res);
	}

	/*
	 * 修改默认地址
	 */
	public function edit_default(){
		$pt = file_get_contents("php://input");
		$arr=json_decode($pt,true);
		if(!empty($arr)){
			$ad_id = $arr['ad_id'];
			$update = array('is_default' => 1);
			$where['ad_id'] = $ad_id;
			$where['user_id'] = $arr['user_id'];
			db('user_address')->where('user_id = '.$where['user_id'])->update(['is_default' => 0]);
			$status = db('user_address')->where($where)->update($update);
			if($status){
				$res = array('code' => 1, 'msg' => '修改成功');
			}else{
				$res = array('code' => 2, 'msg' => '失败');
			}
		}else{
			$res = array('code' => -1, 'msg' => '地址id错误');
		}
		return json_encode($res);
	}

	/*
	 * 新增用户地址
	 */
	public function add_address(){
		$pt = file_get_contents("php://input");
		$arr=json_decode($pt,true);
		if(!empty($arr)){
			$data['ad_name'] = $arr['name'];
			$data['ad_mobile'] = $arr['mobile'];
			$data['ad_address'] = $arr['address'];
			$data['user_id'] = $arr['user_id'];
			$data['add_time'] = time();
			$area = $arr['area'];
			$narea = explode(' ',$area);
			if(count($narea) == 3){
				$data['province'] = $narea[0];
				$data['city'] = $narea[1];
				$data['town'] = $narea[2];
			}else{
				return json_encode(array('code' => '-1','msg' =>'地址格式不正确'));
			}
			foreach($narea as $key => $val){
				$area1 = $val;
			}
			$hav = db('china')->where('name = \''.$area1.'\'')->find();
			$area_id = $hav['id'];
			$count = db('user_address')->where('user_id = '.$data['user_id'])->count();
			if ($count+1 > 5) {
				$num = '';
				$msg = '地址不能超过5个';
			}else{
				if(db('shipping_area')->where('area REGEXP \''.$area_id.'\'')->select()){
					$addcount = db('user_address')->where('user_id = '.$arr['user_id'])->count();
					if($addcount == 0){
						$data['is_default'] = 1;
					}
					$num = db('user_address')->insert($data);
				}else{
					$num = '';
					$msg = '不支持此配送区域';
				}
			}
			if($num){
				$res = array('code' => 1, 'msg' => '添加成功');
			}else{
				$res = array('code' => 2, 'msg' => $msg);
			}
		}else{
			$res = array('code' => -1, 'msg' => '请填写表单');
		}
		return json_encode($res);
	}
	/*
	 * 新增用户地址
	 */
	public function del_address(){
		$pt = file_get_contents("php://input");
		$arr=json_decode($pt,true);
		if(!empty($arr)){
			$id = $arr['ad_id'];
			if($id){
				$where['ad_id'] = $id;
				$where['user_id'] = $arr['user_id'];
				$status = db('user_address')->where($where)->delete();
				if($status){
					$res = array('code' => 1, 'msg' => '删除成功');
				}else{
					$res = array('code' => 1, 'msg' => '失败');
				}
			}
		}else{
			$res = array('code' => -1, 'msg' => '请选择要删除的地址');
		}
		return json_encode($res);
	}
	/*
	 * 获取用户收藏商品
	 */
	 public function get_collect()
	 {
 		$pt = file_get_contents("php://input");
 		$arr=json_decode($pt,true);
		if(!empty($arr)){
			$user_id = $arr['user_id'];
			$collect_list = db('collect')
							->alias('a')
							->field('b.goods_name,b.goods_id,b.goods_img,b.sale_count,b.goods_desc,d.spec_price,d.yuan_price')
							->join('goods b','a.goods_id = b.goods_id')
							->join('goods_spec d','b.goods_id = d.goods_id')
							->join('users c','a.user_id = c.user_id')
							->where('a.user_id = '.$user_id)
							->select();
			if (!empty($collect_list)) {
				$res = array('code' => 1,'data' => $collect_list);
			}else{
				$res = array('code' => 2,'msg' => '无收藏数据');
			}
		}else{
			$res = array('code' => -1 ,'msg' => '参数有误');
		}
		return json_encode($res);
	 }

 	/*
 	 * 忘记密码
 	 */
	 public function forget()
	 {
	    $pt = file_get_contents("php://input");
	    $arr=json_decode($pt,true);
		if(!empty($arr)){
			$code = $arr['code'];
			$data['mobile'] = $arr['mobile'];
			$data['password'] = md5($arr['password']);
			if($code == Session($arr['mobile'])){
				Session($arr['mobile'],null);
				$hav = db('users')->where('mobile ='.$data['mobile'])->find();
				if(!empty($hav)){
					$ret = db('users')->where('user_id = '.$hav['user_id'])->update($data);
					if($ret){
						$res = array('code' => '1','msg' => '修改成功');
					}else{
						$res = array('code' => '2', 'msg' => '失败');
					}
				}else{
					$res = array('code' => '2','msg' => '手机号不存在');
				}
			}else{
				$res = array('code' => '2' ,'msg' => '验证码有误');
			}
		}else{
			$res = array('code' => '-1','msg' => '参数有误');
		}
		return json_encode($res);
	 }

	 /*
	 *  我的积分
	 */
	 public function my_integral()
	 {
		 $pt = file_get_contents('php://input');
		 $arr = json_decode($pt,true);
		 if(!empty($arr)){
			 if(!empty($arr['user_id'])){
				 $user_id = $arr['user_id'];
			 }else{
				 exit;
			 }
			 $integral = db('users')->field('integral')->where('user_id = '.$user_id)->find();
			 $res = array('code' => 1 , 'integral' => $integral['integral']);
		 }else{
			 $res = array('code' => -1 , 'msg' => '缺少参数');
		 }
		 return json_encode($res);
	 }
}

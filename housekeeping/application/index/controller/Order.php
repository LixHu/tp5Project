<?php

namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Session;
class Order extends Index
{
	//预约
	public function reserve(){
		$pt = file_get_contents("php://input");
		$arr=json_decode($pt,true);
		if(!empty($arr)){
			$flag = true;
			if(empty($arr['user_id']) && empty($arr['id']) && empty($arr['time']) && empty($arr['add_id']) && empty($arr['demand'])){
				$flag = false;
			}
			if($flag){
				$data['user_id'] = $arr['user_id'];
				$data['position_id'] = $arr['id'];
				$data['start_time'] = $arr['time'];
				$data['ad_id'] = $arr['add_id'];
				$data['demand'] = $arr['demand'];
				$data['order_sn'] = date('YmdHis').rand(100,999).rand(1000,9999).rand(100,999);
				$data['order_status'] = 1;
				$data['is_reserve'] = 0;
				$data['order_price'] = 0;
				$data['pay_status'] = 1;
				$data['add_time'] = time();
				$hav = db('position_info')->where('id = '.$data['position_id'])->find();
				if ($hav['make_status'] == 1) {
					$msg = '已经被预约';
					$res = '';
				}else{
					$res = db('order')->insert($data);
				}
				if ($res) {
					$reault = array('code' =>1 ,'msg' => '预约成功' );
					db('position_info')->where('id = '.$data['position_id'])->update(['make_status' => 1]);
				}else{
					$reault = array('code' => 2,'msg' => $msg );
				}
			}else{
				$reault = array('code' => 1,'msg' => '缺少参数' );
			}
			return json_encode($reault);
		}
	}
	//用户订单列表
	public function user_order(){
		$pt = file_get_contents('php://input');
		$arr = json_decode($pt,true);
		if(!empty($arr['user_id'])){
			$id = $arr['user_id'];
			$order_list = db('order')
						->alias('a')
						->field('a.order_id,a.order_sn,a.is_reserve,a.order_status,a.demand,a.user_id,a.start_time,a.add_time,b.id,b.name as _name,b.top_image,b.experience,b.workprice,b.price_type,b.origin_address,d.ad_id,d.name,d.mobile,d.add,f.add_id as ad_id1,f.add_id as ad_id1,f.name as name,f.mobile as mobile1,f.add as add1')
						->join('position_info b','a.position_id = b.id','left')
						->join('position_name c','b.position = c.id','left')
						->join('user_address d','a.ad_id = d.ad_id','left')
						->join('position_name e','a.hk_type = e.id','left')
						->join('order_address f','a.order_id = f.order_id','left')
						->where('a.user_id = '.$id)
						->select();
			foreach($order_list as $key => $val){
			// 	if($val['is_reserve'] != 1){
			// 	}
				if($order_list[$key]['add'] == ''){

					$order_list[$key]['mobile'] = $order_list[$key]['mobile1'];
					$order_list[$key]['name'] = $order_list[$key]['name1'];
					$order_list[$key]['add'] = $order_list[$key]['add1'];
				}
				$order_list[$key] = array_filter($order_list[$key]);
				if(!empty($order_list[$key]['start_time'])){
					// $order_list[$key]['start_time'] = date("Y-m-d H:i:s",$order_list[$key]['start_time']);
				}
				// $order_list[$key]['add_time'] = date("Y-m-d H:i:s",$order_list[$key]['add_time']);
				if(!empty($order_list[$key]['workprice'])){
					$ptype = getprice_type($val['price_type']);
					$order_list[$key]['workprice'] = $order_list[$key]['workprice'].$ptype['price_type'];
					unset($order_list[$key]['price_type']);
				}
			}
		}else{
			$res['msg'] = '参数错误';
		}
		if(!empty($order_list)){
			$res['data'] = $order_list;
		}else{
			$res['msg'] = '暂无订单';
		}
		return json_encode($res);
	}
	/*提交订单*/
	public function sub_order(){
		$pt = file_get_contents("php://input");
		$arr=json_decode($pt,true);
		$data['position_id'] = $arr['position_id'];
		$data['user_id'] = Session('user')['id'];
		$data['order_sn'] = date('YmdHis').rand(100,999).rand(1000,9999).rand(100,999);
		$data['order_status'] = 1;
		$data['is_reserve'] = $arr['is_reserve'];
		$data['reserve_id'] = $arr['reserve_id'];
		$data['order_price'] = $arr['order_price'];
		if(!empty($arr['start_time']) && !empty($arr['week'])){
			$data['start_time'] = strtotime($arr['start_time']);
			$stime = $arr['start_time'];
			$week = $arr['week'];
			$data['end_time'] = strtotime("$stime +$week week");
		}
		$data['add_time'] = time();
		$coun = db('order')->where('order_sn',$data['order_sn'])->count();
		$res = db('order')->insert($data);
		if($res){
			$ret = array('code' =>  '1','msg' => '成功');
		}else{
			$ret = array('code' =>  '2','msg' => '失败');
		}
		return json_encode($ret);
	}
	/*快速预约*/
	public function fast_reserve(){
		$pt = file_get_contents("php://input");
		$arr=json_decode($pt,true);
		if(!empty($arr)){
			$flag = true;
			if(empty($arr['user_id']) && empty($arr['hk_type']) && empty($arr['time']) && empty($arr['add_id'])){
				$flag = false;
			}
			if($flag){
				if(!empty($arr['demand'])){
					$data['demand'] = $arr['demand'];
				}
				$data['user_id'] = $arr['user_id'];
				$data['hk_type'] = $arr['hk_type'];
				$data['ad_id'] = $arr['add_id'];
				$data['start_time'] = strtotime($arr['time']);
				$data['order_status'] = 1;
				$data['is_reserve'] = 1;
				$data['add_time'] = time();
				$data['order_sn'] = date("Ymd").Session('user')['id'].rand(1000,9999);
				$res = db('order')->insert($data);
			}else{
				$ret = array('code' => '2','msg' => '缺少参数');
			}
			if($res){
				$ret['code'] = '1';
				$ret['msg'] = '成功';
			}else{
				$ret['code'] = '2';
				$ret['msg'] = '失败';
			}
			return json_encode($ret);
		}
	}

	/*获取订单详情*/
	public function order_info(){
		$pt = file_get_contents("php://input");
		$arr=json_decode($pt,true);
		if(!empty($arr['order_id'])){
			if(!empty($arr['user_id'])){
				$user_id = $arr['user_id'];
			}
			$order_id = $arr['order_id'];
			$count = db('order')->where('order_id = '.$order_id)->find();
			$res =	db('order')
					->alias('a')
					->field('a.order_id,a.order_sn,a.is_reserve,a.order_status,a.demand,a.user_id,a.start_time,a.add_time,b.id,b.name as _name,b.top_image,b.experience,b.price_type,b.workprice,b.origin_address,c.position_name,b.id,d.ad_id,d.name,d.mobile,d.add,e.id as position_id,e.position_name')
					->join('position_info b','a.position_id = b.id','left')
					->join('position_name c','b.position = c.id','left')
					->join('user_address d','a.ad_id = d.ad_id','left')
					->join('position_name e','a.hk_type = e.id','left')
					->where('a.user_id = '.$user_id .' and order_id = '.$order_id)
					->find();
			if(!empty($res['add_time'])){
				$res['add_time'] = date("Y-m-d H:i:s",$res['add_time']);
			}
			if(!empty($res['start_time'])){
				$res['start_time'] = date("Y-m-d H:i:s",$res['start_time']);
			}
			$ptype = getprice_type($res['price_type']);
			if($res['workprice']){
				$res['price'] = $res['workprice'].$ptype['price_type'];
				unset($res['workprice']);
				unset($res['price_type']);
			}
			// array_filter($res);
			if(!empty($res)){
				$ret = $res;
			}else{
				$ret = array('code' => '0', 'msg' => '无结果');
			}
		}else {
			$ret['msg'] = '缺少参数';
		}
		return json_encode($ret);
	}

	/*支付*/
	public function pay() {
		$params['order_id'] = 1;
		$res = \alipay\Wappay::pay($params);
		dump($res);
	}
}

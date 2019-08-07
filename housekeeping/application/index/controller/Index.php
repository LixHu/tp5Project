<?php

namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Loader;
use think\Cache;
use think\Session;
class Index extends Controller
{
	function __construct (){
		parent::__construct();
	}
	// public function pub_ret(){
	// 	$addr = GetIpLookup($_SERVER['REMOTE_ADDR']);
	// 	return json_encode($addr);
	// }
	

	public function my_hk(){
		if(!empty(Session('user'))){
			$id = Session('user')['id'];
			$order = db('order')
					->alias('a')
					->field('b.name,b.top_image,b.experience,b.workprice,b.origin_address,b.price_type,c.position_name')
					->join('position_info b','a.position_id = b.id')
					->join('position_name c','b.position = c.id')
					->where('user_id',$id)
					->select();
			foreach ($order as $key => $val) {
				$price_type = getprice_type($val['price_type']);
				$order[$key]['workprice'] = $order[$key]['workprice'].$price_type['price_type'];
				unset($order[$key]['price_type']);
			}
			$res = array('code' => 1,'data' => $order);
			if (empty($order)) {
				$res = array('code' => 2 ,'msg' =>  '您还没有家政服务');
			}			
		}else{
			$res = array('code' => -1 , 'msg' => '请登录');
		}
		return json_encode($res);
	}
}

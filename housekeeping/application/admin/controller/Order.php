<?php

namespace app\admin\controller;

class Order extends Index
{
	/*订单列表*/
	public function order_list (){
		$order_list = db('order')
					->alias('a')
					->field('a.order_id,a.order_sn,a.is_reserve,a.start_time,c.position_name,d.mobile,f.mobile,f.name,d.name,d.add,f.add,a.order_price,a.order_status,a.pay_status,a.add_time')
					->join('position_info b','a.position_id = b.id','left')
					->join('position_name c','b.position = c.id','left')
					->join('order_address d','a.order_id = d.order_id','left')
					->join('users e','a.user_id = e.id')
					->join('user_address f','a.user_id = f.user_id')
					->group('a.order_id')
					->paginate(10);
		$page = $order_list->render();
		$this->assign('order_list',$order_list);
		$this->assign('page',$page);
		return $this->fetch();
	}
	/*添加修改订单*/
	public function addedit_order(){
		$position_list = db('position_name')->where('is_show = 1')->select();
		if(!empty($_GET['id'])){
			$id = $_GET['id'];
			$info = db('order')
					->alias('a')
					->join('order_address b','a.order_id = b.order_id','left')
					->where('a.order_id',$id)
					->find();
			$info['start_time'] = date('Y-m-d H:i:s',$info['start_time']);
			if(!empty($info['user_id'])){
				$add_list = db('user_address')->where('user_id',$info['user_id'])->select();
			}else{
				$add_list = [];
			}
			$this->assign('info',$info);
		}else{
			$id = '';
			$add_list = '';
		}
		if(!empty($_POST)){
			$data['order_sn'] = date('YmdHis').rand(100,999).rand(1000,9999).rand(100,999);
			$data['is_reserve'] = $_POST['is_reserve'];
			$data['order_price'] = $_POST['order_price'];
			$data['order_status'] = $_POST['order_status'];
			$data['pay_status'] = $_POST['pay_status'];
			$data['start_time'] = strtotime($_POST['start_time']);
			$data['demand'] = $_POST['demand'];
			if(!empty($_POST['ad_id'])){
				$data['ad_id'] = $_POST['ad_id'];
			}else{
				$data['ad_id'] = '';
				$odata['name'] = $_POST['name'];
				$odata['mobile'] = $_POST['mobile'];
				$odata['add'] = $_POST['add'];
			}
			if($id){
				$res = db('order')->where('order_id',$id)->update($data);
				if(empty($_POST['ad_id'])){
					db('order_address')->where('order_id',$id)->update($odata);
				}
			}else{
				$data['position_id'] = 8;
				$data['user_id'] = 1;
				$data['add_time'] = time();
				$res = db('order')->insert($data);
				$odata['order_id'] = db('order')->getLastInsId();
				if(empty($_POST['ad_id'])){
					db('order_address')->insert($odata);
				}
			}
			if($res){
				$this->success('添加、修改成功','order/order_list');
			}else{
				$this->error('失败');
			}
		}
		$this->assign('add_list',$add_list);
		$this->assign('position_list',$position_list);
		return $this->fetch();
	}
	/*删除订单*/
	public function del_order(){
		$idarr = input()['id'];
		$res = array('code' => -1,'msg' => '');
		if(!empty($idarr)){
			if(is_array($idarr)){
				foreach ($idarr as $key => $value) {
					$resault = db('order')->where('order_id',$value)->delete();
				}
			}else{
				$resault = db('order')->where('order_id',$idarr)->delete();
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


	/**
	* 订单地址
	*/
	public function order_address(){
		if($_POST){
			$order_id = $_POST['id'];
			$add_info = db('order')->where('order_id ='.$order_id)->find();
			if(!empty($add_info['ad_id'])){
				$add =db('user_address')->where('ad_id',$add_info['ad_id'])->find();
			}else{
				$add = db('order_address')->where('order_id',$order_id)->find();
			}
			return $add;
		}
	}
}

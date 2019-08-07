<?php

namespace app\admin\controller;

class Order extends Index
{
	/*订单列表*/
	public function order_list (){
		$where = '1 = 1';
		if($_POST){
			$status = $_POST['status'];
			$keywords = $_POST['keywords'];
			if($status){
				$this->assign('status',$status);
				$where .= ' and order_status = '.$status;
			}
			if($keywords){
				$this->assign('keywords',$keywords);
				$where .= ' and mobile REGEXP \''.$keywords.'\'';
			}
		}
		$order_list = db('order')->where($where)->paginate(10);
		$page = $order_list->render();
		$order_status = order_status();
		$this->assign('order_status',$order_status);
		$this->assign('order_list',$order_list);
		$this->assign('page',$page);
		return $this->fetch();
	}
	/*添加修改订单*/
	public function addedit_order(){
		$order_status = order_status();                                         #订单状态
		$pay_status = pay_status();												#支付状态
		$shipping_status = shipping_status();                                   #配送状态
		$pay_type = get_pay_type();												#支付名称
		$order_info = [];
		if(!empty($_GET['id'])){
			$order_id = $_GET['id'];
			$order_info = db('order')
						->where('order_id = '.$order_id)
						->find();
			$goods = db('order_goods')
					->alias('a')
					->join('goods b','a.goods_id = b.goods_id')
					->join('goods_spec c','a.goods_id = b.goods_id')
					->where('order_id ='.$order_id)
					->group('b.goods_id')
					->select();
			$order_info['goods'] = $goods;
		}else{
			$order_id = '';
		}
		if($_POST){
			$data['user_id'] = $_POST['user_id'];
			$data['mobile'] = $_POST['mobile'];
			$data['user_name'] = $_POST['user_name'];
			$data['address'] = $_POST['address'];
			$data['order_status'] = $_POST['order_status'];
			$data['shipping_status'] = $_POST['shipping_status'];
			$data['pay_status'] = $_POST['pay_status'];
			$data['leavmsg'] = $_POST['leavmsg'];
			$data['total_price'] = $_POST['total_price'];
			$data['add_time'] = time();
			if(!empty($_POST['id'])){
				$goods_id = $_POST['id'];
			}else{
				$this->error('请添加商品');
			}
			if($order_id){
				db('order_goods')->where('order_id ='.$order_id)->delete();
				foreach($goods_id as $key => $val){
					$gdata['goods_id'] = $val;
					$gdata['order_id'] = $order_id;
					$gdata['num'] = $_POST['num'][$key];
					$gdata['price'] = $_POST['price'][$key];
					$where['goods_id'] = $val;
					$where['order_id'] = $order_id;
					$have = db('order_goods')->where($where)->find();
					$ret = db('order_goods')->insert($gdata);
				}
				$oret = db('order')->where('order_id',$order_id)->update($data);
				if ($oret) {
					$this->success('添加/修改成功',url('order/order_list'));
				}else {
					$this->error('失败');
				}
			}else{
				$data['order_sn'] = date("Ymdhis").rand(10,99).'1'.rand(100,999);
				foreach($goods_id as $key => $val){
					$gdata['goods_id'] = $val;
					$gdata['order_id'] = $order_id;
					$gdata['num'] = $_POST['num'][$key];
					$gdata['price'] = $_POST['price'][$key];
					$ret = db('order_goods')->insert($gdata);
				}
				$oret = db('order')->insert($data);
				if ($oret) {
					$this->success('添加/修改成功',url('order/order_list'));
				}else {
					$this->error('失败');
				}
			}
		}

		$this->assign('order_status',$order_status);
		$this->assign('pay_status',$pay_status);
		$this->assign('shipping_status',$shipping_status);
		$this->assign('pay_type',$pay_type);
		$this->assign('info',$order_info);
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
	/*商品列表*/
	public function goods_list(){
		$goods_list = db('goods')
						->alias('a')
						->join('goods_spec b','a.goods_id = b.goods_id')
						->select();
		$this->assign('goods_list',$goods_list);
		return $this->fetch();
	}
	/*会员地址列表*/
	public function address_list()
	{
		if($_GET){
			$mobile = $_GET['mobile'];
			if($mobile){
				$div = '';
				$address_list = db('users')
								->alias('a')
								->join('user_address b','a.user_id = b.user_id')
								->where('a.mobile = '.$mobile)
								->select();
				$div .= '<table class="layui-table">';
				$div .= '<tr>';
				$div .= '<th></th>';
				$div .= '<th>姓名</th>';
				$div .= '<th>电话</th>';
				$div .= '<th>地址</th>';
				$div .= '</tr>';
				foreach($address_list as $key => $val){
					$div .= '<tr>';
					$div .= '<td><input type="radio" name="add_id"  value="'.$val['ad_id'].'" ></td>';
					$div .= '<td>'.$val['ad_name'].'</td>';
					$div .= '<td>'.$val['ad_mobile'].'</td>';
					$div .= '<td>'.$val['ad_address'].'</td>';
					$div .= '<input type="hidden" name="user_id" value="'.$val['user_id'].'"';
					$div .= '</tr>';
				}
				$div .= '</table>';
				return $div;
			}
		}
	}
	/*获取会员地址*/
	public function get_address()
	{
		if($_GET){
			$id = $_GET['id'];
			$res = db('user_address')->where('ad_id ='.$id)->find();
			return $res;
		}
	}
}

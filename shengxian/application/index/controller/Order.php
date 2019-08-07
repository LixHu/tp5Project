<?php

namespace app\index\controller;

class Order extends Index
{
    function __construct(){
        parent::__construct();
        // $this->qx_order();
    }
    // private function qx_order(){
    //     $order_list = db('order')->select();
    //     foreach ($order_list as $key => $val) {
    //         db('order')->where('add_time > '.strtotime('+1 day',$val['add_time']))->update(['order_status' => 7]);
    //     }
    // }
    /**
    *   提交订单
    */
    public function sub_order()
    {
        $pt = file_get_contents("php://input");
        $arr = json_decode($pt,true);
        if(!empty($arr)){
            $res = [];
            $flag = false;
            if(!empty($arr['user_id'])){
                $flag = true;
            }
            if(!empty($arr['goods'])){
                $falg = true;
            }
            if($flag){
                $goods = $arr['goods'];
                Session('goods'.$arr['user_id'],$arr['goods']);

                $goods = substr($arr['goods'],0,-1);
                $goods_info = explode(',',$goods);
                // dump($goods_info);
                foreach ($goods_info as $key => $val) {
                    $goods_list[] = explode(':',$val);
                }
                // dump($goods_list);
                $total_price = 0;
                foreach($goods_list as $key => $val){
                    $have = db('goods')->alias('a')->join('goods_spec b','a.goods_id = b.goods_id')->where('a.goods_id ='.$val[0])->find();
                    // 判断商品是否存在 或者库存是否存在。
                    if(empty($have) && $have['stock'] < $val[1]){
                        $resault['msg'] = '商品'.$val[0].'库存不足';
                        return json_encode($resault);
                    }else{
                        $total_price += ($have['spec_price'] * $val[1]);
                    }
                }
                $data['total_price'] = $total_price;
                $ad_count = db('user_address')->where('user_id = '.$arr['user_id'])->count();
                if($ad_count == 0){
                    $res = array('code' => 2,'msg' => '请去添加收货地址' );
                }else{
                    // $ret[] = db('order')->insert($data);
                    // $gdata['order_id'] = db('order')->getLastInsID();
                    $num = [];
                    $ids = '';
                    // dump($goods_list);
                    foreach($goods_list as $key => $val){
                    //     $gdata['goods_id']  = $val[0];
                        $ids  .= $val[0] .',';
                        $num[$val[0]]['num'] = $val[1];
                    //     $gdata['num'] = $val[1];
                    //     $ret[] = db('order_goods')->insert($gdata);
                    }
                    $ids = substr($ids,0,-1);
                    $goods_list = db('goods')
                                ->alias('a')
                                ->field('a.goods_id,a.goods_name,a.goods_img,a.sale_count,a.goods_desc,b.yuan_price,b.spec_price')
                                ->join('goods_spec b','a.goods_id = b.goods_id')
                                ->where('a.goods_id in('.$ids.')')
                                ->select();
                    foreach ($goods_list as $key => $value) {
                        $goods_list[$key]['num'] = $num[$goods_list[$key]['goods_id']]['num'];
                    }
                    // $goods_list = db('order')
                                // ->alias('a')
                                // ->field('a.order_id,a.order_sn,a.total_price,c.goods_id,c.goods_img,c.sale_count,c.goods_desc,b.num,d.yuan_price,d.spec_price,c.goods_name')
                                // ->join('order_goods b','a.order_id = b.order_id')
                                // ->join('goods c','b.goods_id = c.goods_id')
                                // ->join('goods_spec d','c.goods_id = d.goods_id')
                                // ->where('a.order_id = '.$gdata['order_id'])
                                // ->select();
                    $field = 'ad_id,ad_name,ad_mobile,ad_address';
                    $address  = db('user_address')->field($field)->where('user_id ='.$arr['user_id'] .' and is_default = 1')->find();
                    $shipping = db('shipping')->field('shipping_id,name')->select();
                    if(!empty($address)){
                        $address  = db('user_address')->field($field)->where('user_id ='.$arr['user_id'])->find();
                    }
                    $res = array('code' => '1','msg' => '提交成功' ,'data' => $goods_list,'total_price' => $total_price ,'address' => $address ,'shipping_type' => $shipping);
                    // $res = array('code' => 2,'msg' => '失败');
                }
            }else{
                $res = array('code' => '2', 'msg' => '失败');
            }
            return json_encode($res);
        }
    }

    // 确认订单
    public function add_order()
    {
        $pt = file_get_contents("php://input");
        $arr = json_decode($pt,true);
        if(!empty($arr)){
            $flag = true;
            if(empty($arr['user_id']) && empty($arr['shipping_id']) && empty($arr['address_id'])){
                $flag = false;
            }
            if($flag){
                if(empty(Session('goods'.$arr['user_id']))){
                    $res = array('code' => 2,'msg' => '请提交订单' );
                    return json_encode($res);
                }
                $goods = Session('goods'.$arr['user_id']);
                $goods = substr($goods,0,-1);
                $goods_info = explode(',',$goods);
                foreach ($goods_info as $key => $val) {
                    $goods_list[] = explode(':',$val);
                }
                $user_id = $arr['user_id'];
                $shipping_id = $arr['shipping_id'];
                $address_id = $arr['address_id'];
                if(!empty($arr['leave_msg'])){
                    $leavmsg = $arr['leave_msg'];
                }else{
                    $leavmsg = '';
                }
                $total_price = 0;
                foreach($goods_list as $key => $val){
                    $have = db('goods')->alias('a')->join('goods_spec b','a.goods_id = b.goods_id')->where('a.goods_id ='.$val[0])->find();
                    // 判断商品是否存在 或者库存是少于购买量。
                    if(empty($have) && $have['stock'] < $val[1]){
                        $resault['msg'] = '商品'.$val[0].'库存不足';
                        return json_encode($resault);
                    }else{
                        db('goods_spec')->where('spec_id ='.$have['spec_id'])->setDec('stock',$val[1]);
                        $total_price += ($have['spec_price'] * $val[1]);
                    }
                }
                $data['total_price'] = $total_price;
                $data['user_id'] = $arr['user_id'];
                $data['add_time'] = time();
                $data['yj_delivery'] = strtotime('+1 day',time());
                $data['order_sn'] = date('YmdHis').rand(100,999).$data['user_id'].rand(1000,9999);
                $userinfo = db('users')->where('user_id',$data['user_id'])->find();
                $useradd = db('user_address')->where('user_id = '.$data['user_id'].' and is_default = 1')->find();
                $data['mobile'] = $userinfo['mobile'];
                if(!empty($useradd)){
                    $data['address_id'] =   $useradd['ad_id'];
                }
                $data['shipping_id'] = $shipping_id;
                $data['address_id'] = $address_id;
                $data['leavmsg'] = $leavmsg;
                db('order')->insert($data);
                $num = db('order')->getLastInsID();
                $gdata['order_id'] = $num;
                foreach($goods_list as $key => $val){
                    $gdata['goods_id']  = $val[0];
                    $gdata['num'] = $val[1];
                    $ret[] = db('order_goods')->insert($gdata);
                    // 下单完成后把购物车的商品删除
                    // db('cart')->where('goods_id ='.$val[0] .' and user_id ='.$arr['user_id'])->delete();
                }
                $resault = ['order_id' => $num,'order_sn' => $data['order_sn'] ,'total_price' => sprintf("%.2f",$total_price),'qx_time' => date('Y-m-d',strtotime('+1 day',time()))];
                Session('goods'.$arr['user_id'],null);
                if($ret){
                    $res = array('code' => 1,'msg' => '成功' ,'data' => $resault );
                }else{
                    $res = array('code' => 2,'msg' => '失败' );
                }
            }else{
                $res = array('code' => 2,'msg' => '参数有误');
            }
            return json_encode($res);
        }
    }

    // 订单信息
    public function order_msg()
    {
        $pt = file_get_contents("php://input");
        $arr = json_decode($pt,true);
        if (!empty($arr)) {
            $user_id = $arr['user_id'];
            $cart_ids = $arr['cart_id'];
            $list = db('cart')
                    ->alias('a')
                    ->field('a.cart_id,a.num,a.unprice,b.goods_name,b.goods_img,b.sale_count,b.goods_desc')
                    ->join('goods b','a.goods_id = b.goods_id')
                    ->where('user_id ='.$user_id.' and cart_id in ('.$cart_ids.')')
                    ->select();
            if (!empty($list)) {
                $res = array('code' => 1,'data' => $list);
            }else{
                $res = array('code' => 2,'msg' => '无数据');
            }
        }else{
            $res = array('code' =>  -1 ,'msg' => '参数有误');
        }
        return json_encode($res);
    }
    // 用户订单列表
    public function order_list()
    {
        $pt = file_get_contents("php://input");
        $arr = json_decode($pt,true);
        if(!empty($arr)){
            $where = '1 = 1';
            if(!empty($arr['user_id'])){
                $user_id = $arr['user_id'];
                $where .= ' and user_id ='.$user_id;
            }else{
                $user_id = '';
            }
            if(!empty($arr['order_status'])){
                $order_status = $arr['order_status'];
                    $where .= ' and order_status in('.$order_status.')';
            }else{
                $order_status = '';
            }
            $order_list = db('order')->field('order_id,order_sn,order_status,shipping_status,total_price,add_time')->where($where)->select();
            foreach($order_list as $key => $val){
                $order_list[$key]['child'] = db('order_goods')
                                            ->alias('a')
                                            ->field('a.num,b.goods_name,b.goods_id,b.goods_desc,b.sale_count,b.goods_img,b.sale_count,c.yuan_price,c.spec_price')
                                            ->join('goods b','a.goods_id = b.goods_id')
                                            ->join('goods_spec c','b.goods_id = c.goods_id')
                                            ->where('order_id ='.$val['order_id'])
                                            ->select();
                if($order_status == 1){
                    $order_list[$key]['qx_time'] = date('Y-m-d',strtotime('+1 day',$order_list[$key]['add_time']));
                }
            }
            $res = array('code' => 1 , 'data' => $order_list);
        }else{
            $res = array('code' => -1 , 'msg' => '参数有误');
        }
        return json_encode($res);
    }
    // 订单详情
    public function order_info()
    {
        $pt = file_get_contents("php://input");
        $arr = json_decode($pt,true);
        if (!empty($arr)) {
            $data = db('order')
                    ->alias('a')
                    ->field('a.order_id,order_sn,order_status,total_price,a.yj_delivery,pay_type,a.add_time,leavmsg,b.shipping_id,b.name,c.ad_id,c.ad_name,c.ad_mobile,c.ad_address as address,c.province,c.city,c.town')
                    ->join('shipping b','a.shipping_id = b.shipping_id')
                    ->join('user_address c','a.address_id = c.ad_id')
                    ->where('a.user_id = '.$arr['user_id'] .' and order_id ='.$arr['order_id'])
                    ->find();
            if($data){
                $data['total_price'] = sprintf('%.2f',$data['total_price']);
                $res = array('code' => 1 ,'data' => $data);
            }else{
                $res = array('code' => 2 ,'msg' => '暂无');
            }
        }else{
            $res = array('code' => -1 ,'msg' => '参数有误');
        }
        return json_encode($res);
    }
    public function del_order(){
        $pt = file_get_contents("php://input");
        $arr = json_decode($pt,true);
        if (!empty($arr)) {
            $flag = true;
            if(empty($arr['order_id']) && empty($arr['user_id'])){
                $flag = false;
            }
            if($flag){
                $order_id = $arr['order_id'];
                $user_id = $arr['user_id'];
                db('order')->where('order_id ='.$order_id.' and user_id ='.$user_id )->delete();
                $ret = db('order_goods')->where('order_id ='.$order_id)->delete();
                if($ret){
                    $res = array('code' => 1, 'msg' => '删除成功');
                }else{
                    $res = array('code' => 2, 'msg' => '失败');
                }
            }else{
                $res = array('code' =>2 , 'msg' => '缺少参数');
            }
            return json_encode($res);
        }
    }
    /*
    *  获取订单状态
    */
    public function get_status()
    {
        $pt = file_get_contents("php://input");
        $arr = json_decode($pt,true);
        if(!empty($arr['status'])){
            $data = order_status($arr['status']);
        }else{
            $data = order_status();
        }
        $res = array('code' =>1 ,'data' => $data );
        return json_encode($res);
    }

}

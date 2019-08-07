<?php

namespace app\index\controller;

class Cart extends Index
{
    // 购物车列表
    public function cart_list(){
        $pt = file_get_contents("php://input");
        $arr=json_decode($pt,true);
        $res = [];
        if(!empty($arr)){
            $user_id = $arr['user_id'];
            if($user_id){
                $cart_list = db('cart')
                            ->alias('a')
                            ->field('a.cart_id,b.goods_name,b.goods_img,b.goods_desc,a.goods_id,b.sale_count,a.num,c.yuan_price,c.spec_price')
                            ->join('goods b','a.goods_id = b.goods_id')
                            ->join('goods_spec c','b.goods_id = c.goods_id')
                            ->where('user_id',$user_id)
                            ->select();
            }
            if(!empty($cart_list)){
                $res = array('code' => 1,'data' => $cart_list);
            }else{
                $res = array('code' => 2);
            }
        }else{
            $res = array('code' => 2,'msg' => '用户编号错误');
        }

        return json_encode($res);
    }
    //加入购物车
    public function add_cart(){
        $pt = file_get_contents("php://input");
        $arr=json_decode($pt,true);
        $res = [];
        if(!empty($arr)){
            $count = [];
            $msg = '';
            $ret = '';
            $data['user_id'] = $arr['user_id'];             #用户id
            $goods_id = $arr['goods_id'];                   #商品id
            // $data['num'] = 1;                            #商品数量
            $unprice = db('goods')->alias('a')
                        ->join('goods_spec b','a.goods_id = b.goods_id')
                        ->field('spec_price as price,vip_price')
                        ->where('a.goods_id ='.$goods_id)
                        ->find();
            $data['unprice'] = $unprice['price'];
            //根据id查到有没有商品，根据商品判断库存
            if($goods_id){
                $count = db('goods')->alias('a')->join('goods_spec b','a.goods_id = b.goods_id')->where('a.goods_id ='.$goods_id)->find();
            }
            //判断商品是否存在用户的购物车内，不存在则添加
            $have = db('cart')->where('user_id = '.$data['user_id'] .' and goods_id = '.$goods_id)->find();
            if(empty($have)){
                //判断商品是否存在，存在则添加
                if(!empty($count)){
                    $data['goods_id'] = $goods_id;
                    $data['add_time'] = time();
                    $ret = db('cart')->insert($data);
                }else{
                    $msg = '商品不存在或者库存不足';
                }
            }else{
                $msg = '此商品已经存在购物车';
            }
            //如果商品不存在或者超出库存，则不添加
            // if(!empty($count) && $data['num'] + 1 < $count['stock']){
            //     $data['goods_id'] = $goods_id;
            //     $data['add_time'] = time();
            //     if(db('cart')->where('goods_id = '.$goods_id.' and user_id = '.$data['user_id'])->find()){
            //         $ret = db('cart')->where('goods_id = '.$goods_id.' and user_id = '.$data['user_id'])->setInc('num',$data['num']);
            //     }else{
            //         $ret = db('cart')->insert($data);
            //     }
            // }else{
            //     if(empty($count)){
            //         $msg = '商品不存在';
            //     }
            //     if($data['num'] + 1 > $count['stock']){
            //         $msg = '库存不足';
            //     }
            // }
            if($ret){
                db('goods_spec')->where('goods_id = '.$goods_id)->setDec('stock',1); #$data['num'];
                $res = array('code' => 1,'msg' => '添加成功');
            }else{

                $res = array('code' => 2,'msg' => $msg);
            }
        }else{
            $res = array('code' => 2,'msg' => '请填写表单');
        }
        return json_encode($res);
    }
    // 修改购物车信息
    public function edit_cart(){
        $pt = file_get_contents("php://input");
        $arr=json_decode($pt,true);
        if(!empty($arr)){
            $where['user_id'] = $arr['user_id'];
            $where['goods_id'] = $arr['goods_id'];
            $data['num'] = $arr['num'];
            if($where['user_id']){
                $ret = db('cart')->where($where)->update($data);
                if ($ret) {
                    $res = array('code' => 1 ,'msg' => '修改成功');
                }else{
                    $res = array('code' => 2 , 'msg' => '失败');
                }
            }else{
                $res = array('code' => 2,'msg' => '用户编号有误');
            }
        }else{
            $res = array('code' => -1 ,'msg' => '参数有误');
        }
        return json_encode($res);
    }
    // 删除购物车
    public function del_cart(){
        $pt = file_get_contents("php://input");
        $arr = json_decode($pt,true);
        $res = [];
        if(!empty($arr)){
            $cart_id = $arr['cart_id'];
            if ($cart_id) {
                $ret = db('cart')->where('cart_id = '.$cart_id)->delete();
                if($ret){
                    $res = array('code' => 1,'msg' => '删除成功');
                }else{
                    $res = array('code' => 2,'msg' => '购物车编号不存在');
                }
            }
        }else{
            $res = array('code' => -1,'msg' => '参数有误');
        }
        return json_encode($res);
    }

}

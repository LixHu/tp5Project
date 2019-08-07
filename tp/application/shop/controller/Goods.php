<?php
namespace app\shop\controller;

use app\shop\model\Parts;
use app\shop\model\PartsCate;
use app\shop\model\Addpurchase;
use think\Db;
use app\shop\model\Purchase;

/**
 * ========================================================
 * ==商城管理==
 * ========================================================
 */
class Goods extends Index
{

    /**
     * 商品列表
     */
    public function goods_all()
    {   
            
             // 获取产品信息
            $ps = model('GoodsModel');
            $parts = $ps->getgoods_list();
            $data = [];
            //把对象转化为数组
            foreach ($parts as $key => $val){
                $data[] = $val->toArray();
            }

            $page = $parts->render();
            $res = $parts->isEmpty();
            $this->assign('page', $page);//分页
            $this->assign('data', $data);
            $this->assign('res', $res);
        
        return view();
    }

  


     /**
     * 产品详情
     */
    public function goods_list()
    {   
        $id = input('param.id');
        $ep = model('GoodsModel');
        $se = $ep->getOneAd($id);
        $se['num'] = 1;
        session('goods', $se);//商品信息存入session
        $this->assign('se',$se);
        return view();
    }

     /**
     * 优惠券详情
     */
    public function parts_list()
    {   
        $cateid = input('param.id');
        $pa = model('Parts');
        $data = $pa->getcatepartsall($cateid);
        $this->assign('data',$data);
        return view();
    }
   /**
    * 购物车
    */
   public function shop_cart(){
        if (request()->isAjax()) {
            
            if (cookie('shop_user')['uid']) {
                $uid = cookie('shop_user')['uid'];
            }else{
                $uid = cookie('shop_user')['did'];
            }
            
            $id = input('param.id');
            $pid = input('param.pid');
            $cart = model('ShopCart');
            if ($id) {
                $param = Db::name('goods')->where('id',$id)->find();
                $param['uid'] = $uid;
                $param['num'] = 1;
                $param['goods_id'] = $param['id'];
                $res = Db::name('shop_cart')->where('uid',$uid)->find();
                if ($res) { 
                    $sh = db('shop_cart')->where('uid',$param['uid'])->update(['name'=>$param['name'],'img'=>$param['img'],'price'=>$param['price'],'num'=>$param['num'],'goods_id'=>$param['id'],'cateid'=>0]);
                    return 1;
                }else{
                    $sh = $cart->addcart($param);
                    if ($sh) {
                        return 1;
                    }else{
                        return 0;
                    }
                }
                
            }else if($pid){
                $param = Db::name('parts')->where('id',$pid)->find();
                $param['uid'] = $uid;
                $param['num'] = 1;
                $param['goods_id'] = $param['id'];
                $res = Db::name('shop_cart')->where('uid',$uid)->find();
                if ($res) { 
                    $sh = db('shop_cart')->where('uid',$param['uid'])->update(['name'=>$param['name'],'img'=>$param['img'],'price'=>$param['price'],'num'=>$param['num'],'cateid'=>$param['cateid'],'goods_id'=>$param['id']]);
                    
                        return 1;
                    
                }else{
                    $sh = $cart->addcart($param);
                    if ($sh) {
                        return 1;
                    }else{
                        return 0;
                    }
                }
            }
        }else{
            return 3;
        }
   }
   /**
     * 购买商品
     */
    public function goods_pay()
    {   
        $did = input('param.did');
        if (cookie('shop_user')['uid']) {
                $uid = cookie('shop_user')['uid'];
            }elseif (cookie('shop_user')['did']) {
                $uid = cookie('shop_user')['did'];
            }
        $cart = model('shop_cart');
        if ($did) {//如果用户有选择地址
            $data = db('users_address')->where(['uid'=>$uid,'id'=>$did])->find();//选择的收货地址
        }else{
            $data = db('users_address')->where(['uid'=>$uid,'status'=>1])->find();//默认收货地址
        }
        
        $res = $cart->getcart($uid);
        $res['to_price'] = $res['num']*$res['price'];
        $this->assign('se',$res);
        $this->assign('data',$data);
        $this->assign('uid',$uid);
        return view();
    }


    /**
     * 兑换优惠券
     */
    public function shop_parts(){
        if (cookie('shop_user')['uid']) {
            $uid = cookie('shop_user')['uid'];
        }elseif (cookie('shop_user')['did']) {
            $uid = cookie('shop_user')['did'];
        }
        $pid = input('param.pid');
        $param = db('parts')->where('id',$pid)->find();
        if (request()->isAjax()) {
            $count = db('parts')->field('p_count')->where('id',$pid)->find();//查询优惠券库存
        
            if (cookie('shop_user')['uid']) {
                $user_gold = db('users')->where('uid',$uid)->value('gold');//查询当前用户余额，余额不足不允许购买
            }elseif (cookie('shop_user')['did']) {
                $user_gold = db('driver')->where('did',$uid)->value('glod');//查询当前用户余额，余额不足不允许购买
            }
            if ($user_gold < $param['price']) {
                $data = ['code'=>5,'mages'=>'余额不足'];
                return $data;
            }else if($count < 1){
                $data = ['code'=>6,'mages'=>'库存不足'];
                return $data;
            }else{
                $data['pid'] = $pid;
                $data['uid'] = $uid;
                $res = db('parts_user')->insert($data);
                if ($res) {
                    if (cookie('shop_user')['uid']) {
                        db('users')->where('uid',$uid)->setDec('gold',$param['price']);//订单提交成功扣除当前用户的金币(客户)
                    }elseif (cookie('shop_user')['did']) {
                        db('driver')->where('did',$uid)->setDec('glod',$param['price']);//订单提交成功扣除当前用户的金币(司机)
                    }
                    db('parts')->where('id',$pid)->setDec('p_count',1);//订单提交成功减对应优惠券库存
                    $gold['desc'] = '商城消费';
                    $gold['uid'] = $uid;
                    $gold['gold'] = $param['price'];
                    $gold['type'] = 2;
                    $gold['ad_time'] = time();
                    db('gold_log')->insert($gold);//金币明细
                    $data = ['code'=>1,'mages'=>'兑换成功','uid'=>cookie('shop_user')['uid'],'did'=>cookie('shop_user')['did']];
                    return $data;
                }else{
                    $data = ['code'=>0,'mages'=>'兑换失败'];
                    return $data;
                }
            }
        }else{
            $data = ['code'=>3,'mages'=>'操作异常'];
            return $data;
        }
        
        
    }


    /**
     * 收货地址
     */
    public function users_address()
    {   

        $id = input('param.id');
        if (cookie('shop_user')['uid']) {
                $uid = cookie('shop_user')['uid'];
            }elseif (cookie('shop_user')['did']) {
                $uid = cookie('shop_user')['did'];
            }
        $data = db('users_address')->where('uid',$uid)->select();//收货地址
        
        $this->assign('data',$data);
        $this->assign('uid',$uid);
        return view();
    }
    /**
     * 修改收货地址
     */
    public function save_address()
    {   
        if (cookie('shop_user')['uid']) {
                $uid = cookie('shop_user')['uid'];
            }elseif (cookie('shop_user')['did']) {
                $uid = cookie('shop_user')['did'];
            }
        if ($_POST) {
            $param = input('post.');
            if ($_POST['status'] == 1) {
                db('users_address')->where(['uid'=>$uid,'status'=>1])->update(['status'=>0]);
            }
            $us = model('Users');
            $res = $us->save_address($param);
            if ($res) {
                $this->redirect('Goods/goods_pay');
            }else{
                $this->redirect('Goods/goods_pay');
            }
        }else{
            $id = input('param.address_id');
            $uid = input('param.uid');
            $se = db('users_address')->where('id',$id)->find();//收货地址
            
            $this->assign('se',$se);
            $this->assign('uid',$uid);
        }
        
        
        return view();
    }
    /**
     * 添加收货地址
     */
    public function ad_address()
    {   
        if (cookie('shop_user')['uid']) {
            $uid = cookie('shop_user')['uid'];
        }elseif (cookie('shop_user')['did']) {
            $uid = cookie('shop_user')['did'];
        }
        if ($_POST) {
            $param = input('post.');
            if ($_POST['status'] == 1) {
                db('users_address')->where(['uid'=>$uid,'status'=>1])->update(['status'=>0]);
            }
            $us = model('Users');
            $res = $us->ad_address($param);
            if ($res) {
                $this->redirect('Goods/users_address');
            }else{
                $this->redirect('Goods/users_address');
            }
        }
        $this->assign('uid',$uid);
        return view();
    }

    /**
     * 删除收货地址
     */
    public function del_address()
    {
        if (request()->isAjax()) {
            $id = input('param.id');
            if (db('users_address')->where('id',$id)->delete()) {
                return 1;
            }else{
                return 0;
            }
        }else{
            return 3;
        }
    }

    /**
     * 修改数量
     */
    public function save_num()
    {
        if (request()->isAjax()) {
            $id = input('param.id');
            $num = input('param.num');
            if ($num == 0) {
                return 4;
            }else{
                if(db('shop_cart')->where('id='.$id)->update(['num'=>$num])) {
                    return 1;
                }else {
                    return 0;
                }
            }
        }else{
            return 3;
        }
    }

    /**
     * 生成订单
     */
    public function ad_order()
    {   
        if (cookie('shop_user')['uid']) {
            $uid = cookie('shop_user')['uid'];
        }elseif (cookie('shop_user')['did']) {
            $uid = cookie('shop_user')['did'];
        }
        $res = db('shop_cart')->where('uid',$uid)->find();
       // 自动生成订单号
        $year_code = array('A','B','C','D','E','F','G','H','I','J','K','L');
        $order_sn = $year_code[intval(date('Y')) - 2018] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), - 5) . substr(microtime(), 2, 5) . sprintf(rand(0, 99));
        
        if (request()->isAjax()) {
            $param = input('post.');
            $param['order_price'] = $res['num']*$res['price'];
            $param['goods_price'] = $res['price'];
            $param['goods_num'] = $res['num'];
            $param['uid'] = $uid;
            $param['order_number'] = $order_sn;
            $param['status'] = 1;
            $address = db('users_address')->where(['uid'=>$uid,'status'=>1])->select();
            if (empty($res['cateid'])) {//有值代表兑换的是优惠券
                $count = db('goods')->where('id',$res['goods_id'])->value('count');//查询商品库存
            }else{
                $count = db('parts')->field('p_count')->where('id',$res['goods_id'])->find();//查询优惠券库存
            }
            if (cookie('shop_user')['uid']) {
                $user_gold = db('users')->where('uid',$uid)->value('gold');//查询当前用户余额，余额不足不允许购买
            }else{
                $user_gold = db('driver')->where('did',$uid)->value('glod');//查询当前用户余额，余额不足不允许购买
            }
            
            if(empty($param['address'])){
                $data = ['code'=>7,'mages'=>'请先添加收货地址'];
                return $data;
            }
            if ($user_gold < $param['order_price']){
                $data = ['code'=>5,'mages'=>'余额不足'];
                return $data;
            }
            if($count < $res['num']){
                $data = ['code'=>6,'mages'=>'库存不足'];
               return $data;
            }
            if($count <= 0){
                $data = ['code'=>6,'mages'=>'库存不足'];
               return $data;
            }

            $go = model('GoodsOrder');
            $order = $go->add_order($param);
            if ($order) {
                db('shop_cart')->where('uid',$uid)->delete();//清空购物车
                if (cookie('shop_user')['uid']) {
                    db('users')->where('uid',$uid)->setDec('gold',$param['order_price']);//订单提交成功扣除当前用户的金币(客户)
                }elseif (cookie('shop_user')['did']) {
                    db('driver')->where('did',$uid)->setDec('glod',$param['order_price']);//订单提交成功扣除当前用户的金币(司机)
                }
                
                if ($res['cateid']) {//有值代表兑换的是优惠券
                    db('parts')->where('id',$param['goods_id'])->setDec('p_count',$param['goods_num']);//订单提交成功减对应优惠券库存
                }else{
                    db('goods')->where('id',$param['goods_id'])->setDec('count',$param['goods_num']);//订单提交成功减对应商品库存
                }
                $gold['desc'] = '商城消费';
                $gold['uid'] = $uid;
                $gold['gold'] = $param['order_price'];
                $gold['type'] = 2;
                $gold['ad_time'] = time();
                db('gold_log')->insert($gold);//金币明细
                $data = ['code'=>1,'mages'=>'提交成功','uid'=>cookie('shop_user')['uid'],'did'=>cookie('shop_user')['did']];
                return $data;
            }else{
                $data = ['code'=>0,'mages'=>'提交失败'];
               return $data;
            }
            
        }else{
            $data = ['code'=>3,'mages'=>'操作异常'];
            return $data;
        }
        
    }

    /**
     * 金币兑换列表
     */
    public function gold_exchange()
    {   
        $data = db('gold_exchange')->order('id desc')->select();
        $this->assign('data',$data);
        return view();
    }

    /**
     * 兑换金币
     */
    public function ad_gold()
    {   
        
        if (request()->isAjax()) {
            $id = input('param.id');
            $gold = db('gold_exchange')->where('id',$id)->find();

            if (cookie('shop_user')['uid']) {
                $uid = cookie('shop_user')['uid'];
            }elseif (cookie('shop_user')['did']) {
                $uid = cookie('shop_user')['did'];
            }
            
        
            if (cookie('shop_user')['uid']) {
                $user_balance = db('users')->where('uid',$uid)->value('balance');//查询当前用户余额，余额不足不允许购买
            }elseif (cookie('shop_user')['did']) {
                $user_balance = db('driver')->where('did',$uid)->value('blance');//查询当前司机余额，余额不足不允许购买
            }
            if ($user_balance < $gold['price']) {
                $flag = ['code'=>5,'msg'=>'余额不足'];
                return $flag;
            }
            
            
            if (cookie('shop_user')['uid']) {
                $data['desc'] = '金币兑换';
                $data['uid'] = $uid;
                $data['price'] = $gold['price'];
                $data['type'] = 2;
                $data['pay_type'] = 1;
                $data['blance'] = $user_balance-$gold['price'];
                $data['tran_time'] = time();
                $res = db('price_log')->insert($data);//消费记录

                $param['desc'] = '金币兑换';
                $param['uid'] = $uid;
                $param['gold'] = $gold['gold'];
                $param['type'] = 1;
                $param['ad_time'] = time();
                db('gold_log')->insert($param);//金币明细
                db('users')->where('uid',$uid)->setDec('balance',$gold['price']);//兑换成功扣除用户的余额
                db('users')->where('uid',$uid)->setInc('gold',$gold['gold']);//兑换成功增加用户的金币
                if ($res) {
                    $flag = ['code'=>1,'msg'=>'兑换成功'];
                    return $flag;
                }else{
                    $flag = ['code'=>0,'msg'=>'兑换失败'];
                    return $flag;
                }
            }elseif (cookie('shop_user')['did']) {

                $data['desc'] = '金币兑换';
                $data['did'] = $uid;
                $data['price'] = $gold['price'];
                $data['type'] = 2;
                $data['blance'] = $user_balance-$gold['price'];
                $data['save_time'] = time();
                $res = db('driver_log')->insert($data);//消费记录
                
                $param['desc'] = '金币兑换';
                $param['uid'] = $uid;
                $param['gold'] = $gold['gold'];
                $param['type'] = 1;
                $param['ad_time'] = time();
                db('gold_log')->insert($param);//金币明细
                db('driver')->where('did',$uid)->setDec('blance',$gold['price']);//兑换成功扣除司机的余额
                db('driver')->where('did',$uid)->setInc('glod',$gold['gold']);//兑换成功增加司机的金币
                if ($res) {
                    $flag = ['code'=>1,'msg'=>'兑换成功'];
                    return $flag;
                }else{
                    $flag = ['code'=>0,'msg'=>'兑换失败'];
                    return $flag;
                }
            }
            
            
        }else{
            $flag = ['code'=>3,'msg'=>'操作异常'];
            return $flag;
        }
    }

    
}

<?php
namespace app\shop\controller;
use think\Controller;
use think\Loader;
use think\Session;
use think\Request;
use think\captcha\Captcha;
use app\shop\model\Users;
use app\shop\model\Menu;
/**
 *  Index
 */
class Index extends Controller
{
    
    /**
    * 主页
    */
    public function index()
    {   

        $uid_s = input('param.uid');
        $did_s = input('param.did');
        
        if (!empty($uid_s)) {//乘客
            $uid = ($uid_s-10000)/2;
            $user_gold = db('users')->field('uid,nick_name,gold,balance')->where('uid',$uid)->find();
            $user_gold['did'] = 0;
            cookie('shop_user',$user_gold);
        }else if($did_s){
            $did = ($did_s-10000)/2;
            $user_gold = db('driver')->field('did,rela_name,glod,integer')->where('did',$did)->find();
            $user_gold['uid'] = 0;
            $user_gold['balance'] = $user_gold['integer'];
            $user_gold['gold'] = $user_gold['glod'];

            cookie('shop_user',$user_gold);
        }else{
            $user_gold = cookie('shop_user');
            
            $go = model('GoodsModel');
            $this->assign('data',$go->gethotgoods());//热门商品
            $cate = db('partscate')->order('id desc')->select();
            $this->assign('cate',$cate);
            $this->assign('user_gold',$user_gold);
        }
        
        
        $user_gold = cookie('shop_user');
        $go = model('GoodsModel');
        $this->assign('data',$go->gethotgoods());//热门商品
        $cate = db('partscate')->order('id desc')->select();
        $this->assign('cate',$cate);
        $this->assign('user_gold',$user_gold);
        return view();
    }

    /**
    * 金币明细
    */
    public function gold()
    {   
        if (cookie('shop_user')['uid']) {
            $uid = cookie('shop_user')['uid'];
        }elseif (cookie('shop_user')['did']) {
            $uid = cookie('shop_user')['did'];
        }
        $data = db('gold_log')->where('uid',$uid)->order('id desc')->select();
        $this->assign('data',$data);
        
        return view();
    }

    

    /**
    * 积分明细
    */
    public function integral_detail()
    {   
        $uid = cookie('shop_user')['uid'];
        
        return view();
    }

    /**
    * 我的订单
    */
    public function orders()
    {   
        if (cookie('shop_user')['uid']) {
            $uid = cookie('shop_user')['uid'];
        }elseif (cookie('shop_user')['did']) {
            $uid = cookie('shop_user')['did'];
        }
        $data = db('goods_order')->where('uid',$uid)->order('id desc')->select();
        $this->assign('data',$data);
        
        return view();
    }
    /**
     * 发送短信验证码
     */
    public function sendsms()
    {
        $res = array('code' => 2 ,'msg' => '缺少参数');
        if($_POST){
            if(!empty($_POST['mobile'])){
                $sms = new \sms\Sms("C35588802","424b2e67fc7049c7bc6a99fd90aeced1");
                $res = $sms->send_sms($_POST['mobile']);
            }
        }
        return $res;
    }
   
}

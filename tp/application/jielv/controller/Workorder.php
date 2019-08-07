<?php

namespace app\jielv\controller;

use think\Loader;
use think\Session;

class Workorder extends Index
{

    /**
     * 订单列表
     */
    public function workorder_all()
    {   

        $cid = input('param.cid');
        if ($cid) {
            $make_time = time()+10800;
            $wor = model('WorkOrders');
            $param = $wor->getcid($cid,$make_time);
        }else{
            $make_time = time()+10800;
            $wor = model('WorkOrders');
            $param = $wor->getworkorder_all($make_time);
        }
        
        $data = [];
        //把对象转化为数组
        foreach ($param as $key => $val){
            $data[] = $val->toArray();
        }
        foreach ($data as $key => $value) {
            $data[$key]['uid'] = db('users')->where('uid',$value['uid'])->value('nick_name');
            $data[$key]['mobile'] = db('users')->where('uid',$value['uid'])->value('mobile');
        }
        
        $page = $param->render();
        $res = $param->isEmpty();
        $this->assign('page', $page);//分页
        $this->assign('res', $res);//分页
        $this->assign('data',$data);
        $this->assign('cid',$cid);
        return view();
    }
    


    /**
     *  搜索
     */
    public function search_order()
    {
        $cid = input('param.cid');
        $make_time = time()+10800;

      // 接收所搜的关键字
      $keywords = input('param.keyword');
      if ($keywords) {
        $dv = model('WorkOrders');
        $param = $dv->search_list($keywords,$make_time);
      }

      $data = [];
        //把对象转化为数组
        foreach ($param as $key => $val){
            $data[] = $val->toArray();
        }
        foreach ($data as $key => $value) {
            $data[$key]['uid'] = db('users')->where('uid',$value['uid'])->value('nick_name');
            $data[$key]['mobile'] = db('users')->where('uid',$value['uid'])->value('mobile');
        }
        
        $page = $param->render();
        $res = $param->isEmpty();
      $this->assign('page', $page);//分页
      $this->assign('res', $res);//分页
      $this->assign('data',$data);
      $cart_type = db('cart_type')->select();
      $this->assign('cart_type',$cart_type);
      $this->assign('cid',$cid);

      return $this->fetch('workorder_all');
    }

    /**
     *  司机列表
     */
    public function driver_cap()
    {   
        $oid = input('param.oid');
        // dump($oid);die();
        $cid = input('param.cid');
      if ($cid) {
        $dv = model('DriverModel');
        $data = $dv->catedriver_all($cid);
      }else{
        $dv = model('DriverModel');
        $data = $dv->getdriver_all();
      }  
      
      foreach ($data as $key => $value) {
        $data[$key]['region_id'] = db('region')->where('id',$value['region_id'])->value('name');
      }
      $page = $data->render();
      $res = $data->isEmpty();
      $this->assign('page', $page);//分页
      $this->assign('res', $res);//分页
      $this->assign('data',$data);
      $cart_type = db('cart_type')->select();
      $this->assign('cart_type',$cart_type);
      $region_data = db('region')->where('pid=1')->field('id,name')->select();//地区
      $this->assign('region_data', $region_data);
      $this->assign('cid',$cid);
      $this->assign('oid',$oid);
        return view();
    }

    /**
     * 搜索司机
     */
    public function search_driver()
    { 
      $oid = input('param.oid'); 
      $cid = input('param.cid');
      // 接收所搜的关键字
      $keywords = input('param.keyword');
      if ($keywords) {
        $dv = model('DriverModel');
        $data = $dv->search_list($keywords);
      }

      foreach ($data as $key => $value) {
        $data[$key]['region_id'] = db('region')->where('id',$value['region_id'])->value('name');
      }
      $page = $data->render();
      $res = $data->isEmpty();
      $this->assign('page', $page);//分页
      $this->assign('res', $res);//分页
      $this->assign('data',$data);
      $cart_type = db('cart_type')->select();
      $this->assign('cart_type',$cart_type);
      $region_data = db('region')->where('pid=1')->field('id,name')->select();//地区
      $this->assign('region_data', $region_data);
      $this->assign('cid',$cid);
      $this->assign('oid',$oid);

      return $this->fetch('driver_cap');
    }

    /**
     *  指派订单
     */
    public function workorder_assign()
    {   
        if (request()->isAjax()) {
            $did = input('param.did');
            $oid = input('param.oid');
            $rid = db('driver')->where('did',$did)->value('registrationid');
            $res = db('orders')->where('oid',$oid)->update(['did'=>$did,'cid'=>2,'admin_user'=>session('user')['uid']]);
            if ($res) {
                //极光推送消息
                $account = model('Account');
                $pushkey = $account->getAccount('pushuser');
                $app_key = $pushkey['account'];
                $master_secret = $pushkey['secret'];
                $system_data = [
                                'id'=>1,
                                'title'=>'test',
                                'contents'=>'dashduashdioasdjioadasda'
                            ];
                $push_data = [
                                'title'=>'dasdadsa',
                                'extras'=>[
                                    'type'=>'system',
                                    'status'=>'0',
                                    'data'=>$system_data
                                ]
                            ];
                import('push.api.Push');
                $this->push = new \Push($app_key,$master_secret);
                $this->push->regalerts('您有新订单,请及时查看',$rid,$push_data,$push_data);
                $flog = ['code'=>1,'mages'=>'指派成功'];
                return $flog;
            }else{
                $flog = ['code'=>0,'mages'=>'操作失败'];
                return $flog;
            }
        }else{
            $flog = ['code'=>3,'mages'=>'操作异常'];
            return $flog;
        }
        
        
    }


    /**
     * 订单详情
     */
    public function order_list()
    {   
       
        return view();
    }

    
}

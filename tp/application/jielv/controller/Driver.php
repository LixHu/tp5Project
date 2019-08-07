<?php
/**
 * 数据分析
 */

namespace app\jielv\controller;

use think\Db;
use think\Session;

class Driver extends Index
{
    /**
     * 司机列表
     */
    public function driver_list()
    { 
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
      return view();
    }


    /**
     * 新增司机
     */
    public function ad_driver() {
        $data = input('post.');
        $data['aud_status'] = 3;
        if (request()->isAjax()) {
          $mobile = db('driver')->where('mobile',$data['mobile'])->find();
          $id_card = db('driver')->where('id_card',$data['id_card'])->find();
          if ($mobile) {
            $flog = ['code'=>4,'mages'=>'手机号已存在'];
            return json($flog);
          }
          if ($id_card) {
            $flog = ['code'=>5,'mages'=>'身份证号已存在'];
            return json($flog);
          }
          $dv = model('DriverModel');
          $res = $dv->ad_driver($data);

          $did = $dv->getLastInsID();
          $param = [
              'userId'  =>   $arr['unique_id'],
              'name'    =>   $arr['mobile'],
              'portraitUri'  => config('server_url').'/static/user/default_head.png'
          ];

          import('request.SendRequest');

          $account = model('Account','model');
          $apkey = $account->getAccount('rongcloud');
          $send = new \SendRequest($apkey['account'],$apkey['secret']);

          $token = $send->curl('/user/getToken.json',$param);
          $jgtoken = json_decode($token,true)['token'];             //   极光返回的token 放到司机表中的driver_token 字段
          if ($res) {
            $flog = ['code'=>1,'mages'=>'添加成功'];
            return json($flog);
          }else{
            $flog = ['code'=>0,'mages'=>'新增失败'];
            return json($flog);
          }
        }else{
          $flog = ['code'=>3,'mages'=>'操作异常'];
          return json($flog);
        }
    }

    /**
     * ajax查询对应下拉的省市区
     */
    public function change_address() {
        $id = input('param.id');
        $region_data = db('region')->where('pid',$id)->field('id,name')->select();
        return $region_data;
    }



    /**
     * 搜索
     */
    public function search_driver()
    {  
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

      return $this->fetch('driver_list');
    }
    /**
     * 更改状态
     */
    public function save_status()
    {
      $did = input('param.did');
      $status = db('driver')->where('did',$did)->value('aud_status');
      if ($status == 1) {
        $res = db('driver')->where('did', $did)->setField(['aud_status' => 2]);
        if ($res) {
          return 1;
        }else{
          return 0;
        }
      }else{
        $res = db('driver')->where('did', $did)->setField(['aud_status' => 1]);
        if ($res) {
          return 1;
        }else{
          return 0;
        }
      }
       
    }
    /**
     * 待审核司机列表
     */
    public function driver_aud()
    { 
      
        $dv = model('DriverModel');
        $data = $dv->driver_aud();
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

      

      return view();
    }

    /**
     * 审核司机详情
     */
    public function aud_list()
    { 
      $id = input('param.did');
      if ($id) {
          $dv = model('DriverModel');
          $data = $dv->getOneAd($id);
          $data['car_id'] = db('cart_type')->where('id',$data['car_id'])->value('type_name');
          $data['region_id'] = db('region')->where('id',$data['region_id'])->value('name');
          $this->assign('data',$data);
      }

      return view();
    }

    /*
     审核司机
    */
     public function aud(){
        $did = input('param.did');
        if (request()->isAjax()) {
            $aud_status = db('driver')->where('did',$did)->value('aud_status');
            if ($aud_status == 3) {
                $res = db('driver')->where('did',$did)->update(['aud_status'=>1]);
                if ($res) {
                  return 1;
                }else{
                  return 0;
                }
            }
        }else{
          return 3;
        }
        
     }
}
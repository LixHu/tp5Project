<?php
namespace app\index\controller;

class Store extends Index
{

    /*
    * 店铺详情
    */
    public function store_info()
    {
        $arr = $this->arr;
        if(!empty($arr)){
            $flag = true;
            if(empty($arr['user_id'])){
                $flag = false;
            }
            if($flag){
                $user_id = $arr['user_id'];
                $user_info = db('users')
                            ->alias('a')
                            ->field('a.user_id,a.nickname,a.head_img,c.col_name,b.name,b.tel,b.mobile,b.province,b.city,b.area,b.add,b.com_img,b.license_img,b.aud_status')
                            ->join('user_data b','a.user_id = b.user_id','left')
                            ->join('ad_column c','b.column_id = c.col_id','left')
                            ->where('a.user_id ='.$user_id)
                            ->find();
                if(!empty($user_info)){
                    $user_info['ad'] = db('users')
                                     ->alias('a')
                                     ->field('a.user_id,a.nickname,a.head_img,b.ad_id,b.title,b.ad_img,b.see_count,b.price,b.stock,b.add_time,b.groom_status')
                                     ->join('ad b','a.user_id = b.user_id')
                                     ->where('a.user_id ='.$user_id)
                                     ->order('add_time desc')
                                     ->select();
                    foreach ($user_info['ad'] as $key => $val) {
                        $user_info['ad'][$key]['groom_status'] = GetGroomStatus($val['groom_status'] -1)['status'];
                        $user_info['ad'][$key]['add_time'] = date('Y-m-d H:i:s',$val['add_time']);
                        $user_info['ad'][$key]['ad_img'] = explode(',',$val['ad_img']);
                    }
                    if($user_info['aud_status'] != ''){
                        $user_info['aud_status'] = GetAudStatus($user_info['aud_status'])['status'];
                    }else{
                        $user_info['aud_status'] = '无资料';
                    }
                    $user_info = array_filter($user_info);
                    $res = array('code' => 1,'data' => $user_info);
                }else{
                    $res = array('code' => 2,'msg' => '暂无信息');
                }
            }else{
                $res = array('code' => 2,'msg' => '缺少参数');
            }
            return jsonReturn($res);
        }
    }
}

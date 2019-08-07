<?php

namespace app\index\controller;

class Banner extends Index
{
    public function banner_list()
    {
        $arr = $this->arr;
        if(!empty($arr)){
            $flag = true;
            if(empty($arr['banner_pos'])){
                $flag = false;
            }
            if($flag){
                $banner_pos = $arr['banner_pos'];
                $banner_list = db('banner')->field('bn_name,bn_url,bn_jump')->where('bn_pos = '.$banner_pos)->select();
                if(!empty($banner_list)){
                    $res = array('code' => 1, 'data' => $banner_list);
                }else{
                    $res = array('code' => 2, 'msg' => '暂无图片');
                }
            }else{
                $res = array('code' => 2, 'msg' => '参数有误');
            }
            return jsonReturn($res);
        }
    }
}

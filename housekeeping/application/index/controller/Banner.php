<?php

namespace app\index\controller;

class Banner extends Index
{
    public function banner_list (){
        $pt = file_get_contents("php://input");
        $arr = json_decode($pt,true);
        if(!empty($arr)){
            if(!empty($arr['pos'])){
                $pos = $arr['pos'];
            }else{
                $pos = 1;
            }
            $bn_list = db('banner')->field('bn_id,bn_url')->where('bn_pos ='.$pos)->select();
            if(!empty($bn_list)){
                $res = array('code' => 1,'data' => $bn_list);
            }else{
                $res = array('code' => 2,'msg' => '暂无数据');
            }
            return json_encode($res);
        }
    }
}

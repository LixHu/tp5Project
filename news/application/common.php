<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
/**
* base64 上传文件方法
*/
function base_upload($up_dir = '',$base = ''){
    if($up_dir){
        $up_dir = $up_dir;
    }else{
        $up_dir = ROOT_PATH . 'public/static' . DS . 'uploads/';
    }
    if($base){
        if (!file_exists($up_dir)) {
            mkdir($up_dir,0777);
        }
        if(preg_match('/^(data:\s*image\/(\w+);base64,)/',$base,$result)){
            $type = $result[2];
            if(in_array($type,array('pjpeg','jpeg','jpg','gif','bmp','png'))){
                $new_file = $up_dir.date("YmdHis_").rand(10,99).rand(100,999).'.'.$type;
                if(file_put_contents($new_file,base64_decode(str_replace($result[1],'', $base)))){
                    $img_path = str_replace(ROOT_PATH.'public', ' ', $new_file);
                    $res = array('code' => 1,'url' => trim($img_path));
                }else{
                    $res = array('code' => 2);
                }
            }else{
                $res = array('code' => 3);
            }
        }else{
            $res = array('code' => 4 ,'msg' => '格式不正确');
        }
    }else{
        $res = array('code' => -1);
    }
    return $res;
}
/*
*
*/
function proving($preg = false,$msg = null){
    if(!$preg){
        return $msg;
    }
}

/*
* 密码加密
*/
function sysmd5($variable = null){
    if(!empty($variable)){
        $ret = md5(md5(md5($variable)));
    }
    return $ret;
}
/*
* json 返回方法
*/
function jsonReturn($variable = null){
    if(!empty($variable)){
        $ret = json_encode($variable);
    }
    return $ret;
}
/**
 * 获取两个经纬度之间的距离
 * @param  string $lat1 纬一
 * @param  String $lng1 经一
 * @param  String $lat2 纬二
 * @param  String $lng2 经二
 * @return float  返回两点之间的距离
 */
 function calcDistance($lat1, $lng1, $lat2, $lng2) {
    /** 转换数据类型为 double */
    $lat1 = doubleval($lat1);
    $lng1 = doubleval($lng1);
    $lat2 = doubleval($lat2);
    $lng2 = doubleval($lng2);
    /** 以下算法是 Google 出来的，与大多数经纬度计算工具结果一致 */
    $theta = $lng1 - $lng2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    return ($miles * 1.609344);
}
/*
* 获取反馈信息状态
*/
function GetFeedType($index = null)
{
    $feedtype = array(
        ['code' => 0 ,'type' => '请选择'],
        ['code' => 1 ,'type' => '反馈'],
        ['code' => 2 ,'type' => '申请']
    );
    if($index){
        return $feedtype[$index];
    }else{
        return $feedtype;
    }
}
/*
*  获取审核状态
*/
function GetAudStatus($index = null)
{
    $aud_list = array(
        ['code' => 0 ,'status' => '未审核'],
        ['code' => 1 ,'status' => '已通过'],
        ['code' => 2 ,'status' => '已拒绝'],
        ['code' => 3 ,'status' => '已过期']
    );
    if($index >= 0){
        return $aud_list[$index];
    }else{
        return $aud_list;
    }
}
function GetAudStatus2(){
    $aud_list = array(
        ['code' => 0 ,'status' => '未审核'],
        ['code' => 1 ,'status' => '已通过'],
        ['code' => 2 ,'status' => '已拒绝'],
        ['code' => 3 ,'status' => '已过期']
    );
    return $aud_list;
}
/*
* 获取推荐时长
*/
function GetGroomType($index = null)
{
    $groom_type = array(
        ['code' => 0 ,'status' => 'day' ,'desc' => '日'],
        ['code' => 1 ,'status' => 'week' ,'desc' => '周'],
        ['code' => 2 ,'status' => 'month' ,'desc' => '月']
    );
    if($index >= 0 ){
        return $groom_type[$index];
    }else{
        return $groom_type;
    }
}
function GetGroomType2()
{
    $groom_type = array(
        ['code' => 0 ,'status' => 'day' ,'desc' => '日'],
        ['code' => 1 ,'status' => 'week' ,'desc' => '周'],
        ['code' => 2 ,'status' => 'month' ,'desc' => '月']
    );
    return $groom_type;
}
/*
*  获取推荐审核
*/
function GetGroomStatus($index = null){
    $groom_status = array(
        ['code' => 0 ,'status' => '推荐中'],
        ['code' => 1 ,'status' => '拒绝推荐'],
        ['code' => 2 ,'status' => '等待处理'],
        ['code' => 3 ,'status' => '已取消'],
        ['code' => 4 ,'status' => '未申请'],
    );
    if($index >= 0){
        return $groom_status[$index];
    }else{
        return $groom_status;
    }
}
function deep_in_array($value, $array) {
    foreach($array as $item) {
        if(!is_array($item)) {
            if ($item == $value) {
                return true;
            } else {
                continue;
            }
        }

        if(in_array($value, $item)) {
            return true;
        } else if(deep_in_array($value, $item)) {
            return true;
        }
    }
    return false;
}

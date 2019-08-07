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
/*
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
                $new_file = $up_dir.date("YmdHis_").'.'.$type;
                if(file_put_contents($new_file,base64_decode(str_replace($result[1],'', $base)))){
                    $img_path = str_replace(ROOT_PATH.'public', ' ', $new_file);
                    $res = array('code' => 1,'url' => $img_path);
                }else{
                    $res = array('code' => 2);
                }
            }else{
                $res = array('code' => 3);
            }
        }else{
            $res = array('code' => 4);
        }
    }else{
        $res = array('code' => -1);
    }
    return $res;
}
function screen($type = null,$code = null){
    switch ($type) {
        case 'price':
            $price = array(
                ['code' => 0,'esxplain' => '不限工资'],
                ['code' => 1,'esxplain' =>'3000元以下'],
                ['code' => 2,'esxplain' =>'3000~3999元'],
                ['code' => 3,'esxplain' =>'4000~4999元'],
                ['code' => 4,'esxplain' =>'5000~5999元'],
                ['code' => 5,'esxplain' =>'6000~6999元'],
                ['code' => 6,'esxplain' =>'7000~7999元'],
                ['code' => 7,'esxplain' =>'8000~8999元'],
                ['code' => 8,'esxplain' =>'9000~9999元'],
                ['code' => 9,'esxplain' =>'10000~10999元'],
                ['code' => 10,'esxplain' =>'11000~11999元'],
                ['code' => 11,'esxplain' =>'12000~12999元'],
                ['code' => 12,'esxplain' =>'13000~13999元'],
                ['code' => 13,'esxplain' =>'14000~14999元'],
                ['code' => 14,'esxplain' =>'15000~15999元'],
                ['code' => 15,'esxplain' =>'16000~16999元'],
                ['code' => 16,'esxplain' =>'17000~17999元'],
                ['code' => 17,'esxplain' =>'18000~18999元'],
                ['code' => 18,'esxplain' =>'19000~19999元'],
                ['code' => 19,'esxplain' =>'20000元以上'],
            );
            if($code){
                return $price[$code];
            }else{
                return $price;
            }
            break;
        case 'experience':
            $experience = array(
                ['code' => 0,'esxplain' =>'不限经验'],
                ['code' => 1,'esxplain' =>'1年以下'],
                ['code' => 2,'esxplain' =>'1~3年'],
                ['code' => 3,'esxplain' =>'3~5年'],
                ['code' => 4,'esxplain' =>'5年以上'],
            );
            if($code){
                return $experience[$code];
            }else{
                return $experience;
            }
            break;
        case 'age':
            $age = array(
                ['code' => 0,'esxplain' =>'不限年龄'],
                ['code' => 1,'esxplain' =>'20岁一下'],
                ['code' => 2,'esxplain' =>'20~29岁'],
                ['code' => 3,'esxplain' =>'30~39岁'],
                ['code' => 4,'esxplain' =>'40~49岁'],
                ['code' => 5,'esxplain' =>'50岁以上'],
            );
            if($code){
                return $age[$code];
            }else{
                return $age;
            }
            break;
        }
}
/*获取工人状态*/
function getstatus ($status = 0){
    switch ($status) {
        case 0:
            $statu_code = '';
            break;
        case 1:
            $statu_code = '在职';
            break;
        case 2:
            $statu_code = '空闲';
            break;
    }
    if(!empty($statu_code)){
        return $statu_code;
    }
}
/*获取会员卡类型*/
function vip_card ($card_id = 0) {

    $card = array(
        array("id" => 1 ,"type" => '无会员卡'),
        array("id" => 2 ,"type" => '白金卡'),
        array("id" => 3 ,"type" => '紫金卡'),
        array("id" => 4 ,"type" => '蓝金卡'),
        );
    if($card_id){
        $ret = $card[$card_id];
    }else{
        $ret = $card;
    }
	return $ret;
}
/*获取工资计算类型*/
function getprice_type($price_type = 0){
    switch ($price_type) {
        case 1:
            $type['id'] = 1;
            $type['price_type'] = '/月';
            break;
        case 2:
            $type['id'] = 2;
            $type['price_type'] = '/日';
            break;
        case 3:
            $type['id'] = 3;
            $type['price_type'] = '/时';
            break;
        default:
            $type['id'] = 0;
            $type['price_type'] = '/月';
            break;
    }
    return $type;
}
/*获取用户ip 获取当前位置*/
function GetIp(){
    $realip = '';
    $unknown = 'unknown';
    if (isset($_SERVER)){
        if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR']) && strcasecmp($_SERVER['HTTP_X_FORWARDED_FOR'], $unknown)){
            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            foreach($arr as $ip){
                $ip = trim($ip);
                if ($ip != 'unknown'){
                    $realip = $ip;
                    break;
                }
            }
        }else if(isset($_SERVER['HTTP_CLIENT_IP']) && !empty($_SERVER['HTTP_CLIENT_IP']) && strcasecmp($_SERVER['HTTP_CLIENT_IP'], $unknown)){
            $realip = $_SERVER['HTTP_CLIENT_IP'];
        }else if(isset($_SERVER['REMOTE_ADDR']) && !empty($_SERVER['REMOTE_ADDR']) && strcasecmp($_SERVER['REMOTE_ADDR'], $unknown)){
            $realip = $_SERVER['REMOTE_ADDR'];
        }else{
            $realip = $unknown;
        }
    }else{
        if(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), $unknown)){
            $realip = getenv("HTTP_X_FORWARDED_FOR");
        }else if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), $unknown)){
            $realip = getenv("HTTP_CLIENT_IP");
        }else if(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), $unknown)){
            $realip = getenv("REMOTE_ADDR");
        }else{
            $realip = $unknown;
        }
    }
    $realip = preg_match("/[\d\.]{7,15}/", $realip, $matches) ? $matches[0] : $unknown;
    return $realip;
}

function GetIpLookup($ip = ''){
    if(empty($ip)){
        $ip = GetIp();
    }
    $res = @file_get_contents('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js&ip=' . $ip);
    if(empty($res)){ return false; }
    $jsonMatches = array();
    preg_match('#\{.+?\}#', $res, $jsonMatches);
    if(!isset($jsonMatches[0])){ return false; }
    $json = json_decode($jsonMatches[0], true);
    if(isset($json['ret']) && $json['ret'] == 1){
        $json['ip'] = $ip;
        unset($json['ret']);
    }else{
        return false;
    }
    return $json;
}
function get_education($education = null){
    $education_list = array(
        ['code' => 1,'education' => '请选择'],
        ['code' => 2,'education' => '小学'],
        ['code' => 3,'education' => '初中'],
        ['code' => 4,'education' => '高中或中专'],
        ['code' => 5,'education' => '大专'],
        ['code' => 6,'education' => '本科'],
        ['code' => 7,'education' => '研究生'],
     );
     if($education){
         return $education_list[$education];
     }else{
         return $education_list;
     }
}

function getmakestatus($make_status = null){
    $status = array(
        ['id' => 1 ,'pos' => '未被预约'],
        ['id' => 2 ,'pos' => '已被预约'],
    );
    if($make_status){
        return $status[$make_status];
    }else{
        return $status;
    }
}
function banner_pos($pos){
    $banner_pos = array(
        ['id' => 1 ,'pos' => '请选择'],
        ['id' => 2 ,'pos' => '首页banner'],
        ['id' => 3 ,'pos' => '登录'],
    );
    if($pos){
        return $banner_pos[$pos];
    }else{
        return $banner_pos;
    }
}
/**
*计算某个经纬度的周围某段距离的正方形的四个点
*
*@param lng float 经度
*@param lat float 纬度
*@param distance float 该点所在圆的半径，该圆与此正方形内切，默认值为0.5千米
*@return array 正方形的四个点的经纬度坐标
*/
function returnSquarePoint($lng, $lat,$distance = 0.5){
    define(EARTH_RADIUS, 6371);//地球半径，平均半径为6371km
    $dlng = 2 * asin(sin($distance / (2 * EARTH_RADIUS)) / cos(deg2rad($lat)));
    $dlng = rad2deg($dlng);

    $dlat = $distance/EARTH_RADIUS;
    $dlat = rad2deg($dlat);

    return array(
        'left-top'=>array('lat'=>$lat + $dlat,'lng'=>$lng-$dlng),
        'right-top'=>array('lat'=>$lat + $dlat, 'lng'=>$lng + $dlng),
        'left-bottom'=>array('lat'=>$lat - $dlat, 'lng'=>$lng - $dlng),
        'right-bottom'=>array('lat'=>$lat - $dlat, 'lng'=>$lng + $dlng)
    );
}

function getdistance($lng1,$lat1,$lng2,$lat2){
    //根据经纬度计算距离 单位为公里
    //将角度转为狐度
    $radLat1=deg2rad($lat1);
    $radLat2=deg2rad($lat2);
    $radLng1=deg2rad($lng1);
    $radLng2=deg2rad($lng2);
    $a=$radLat1-$radLat2;//两纬度之差,纬度<90
    $b=$radLng1-$radLng2;//两经度之差纬度<180
    $s=2*asin(sqrt(pow(sin($a/2),2)+cos($radLat1)*cos($radLat2)*pow(sin($b/2),2)))*6378.137;
    return $s;
}

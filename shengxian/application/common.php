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
function base_upload($up_dir = '',$base = ''){
    if($up_dir){
        $up_dir = $up_dir;
    }else{
        $up_dir = ROOT_PATH . 'public/static' . DS . 'uploads/';
    }
    if($base){
        if (!file_exists($up_dir)) {
            mkdir($updir,0777);
        }
        if(preg_match('/^(data:\s*image\/(\w+);base64,)/',$base,$result)){
            $type = $result[2];
            if(in_array($type,array('pjpeg','jpeg','jpg','gif','bmp','png'))){
                $new_file = $up_dir.date("YmdHis").rand(1000,9999).'.'.$type;
                if(file_put_contents($new_file,base64_decode(str_replace($result[1],'', $base)))){
                    $img_path = str_replace(ROOT_PATH .'public', '', $new_file);
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
//会员信息
function vip_lv($all = false,$lv = 0)
{
    $vip = array(
        ['lv' =>  0 , 'name' => '请选择'],
        ['lv' =>  1 , 'name' => '普通用户'],
        ['lv' =>  2 , 'name' => '普通会员'],
        ['lv' =>  3 , 'name' => '超级会员']
    );
    if($all){
        return $vip[$lv];
    }else{
        return $vip;
    }
}
//获取订单状态
function order_status($status = -1)
{
    $order_status = array(
        ['code' => '0' , 'status' => '请选择'],
        ['code' => '1' , 'status' => '未支付'],
        ['code' => '2' , 'status' => '待发货'],
        ['code' => '3' , 'status' => '配送中'],
        ['code' => '4' , 'status' => '已配送'],
        ['code' => '5' , 'status' => '已收货'],
        ['code' => '6' , 'status' => '已评价'],
        ['code' => '7' , 'status' => '已取消'],
        ['code' => '8' , 'status' => '退款中'],
        ['code' => '9' , 'status' => '已退款']
    );
    if($status != -1){
        return $order_status[$status];
    }else{
        return $order_status;
    }
}
//支付状态
function pay_status($status = -1)
{
    $pay_status = array(
        ['code' => '0' , 'status' => '请选择'],
        ['code' => '1' , 'status' => '未支付'],
        ['code' => '2' , 'status' => '支付完成']
    );
    if($status != -1){
        return $pay_status[$status];
    }else{
        return $pay_status;
    }
}
//配送状态
function shipping_status($status = -1)
{
    $shipping_status = array(
        ['code' => '0' , 'status' => '请选择'],
        ['code' => '1' , 'status' => '配送中'],
        ['code' => '2' , 'status' => '配送失败'],
        ['code' => '2' , 'status' => '配送完成']
    );
    if($status != -1){
        return $shipping_status[$status];
    }else{
        return $shipping_status;
    }
}
// 支付方式
function get_pay_type($type = -1)
{
    $pay_type = array(
        ['code' => '0' , 'type' => '未支付'],
        ['code' => '1' , 'type' => '货到付款'],
        ['code' => '2' , 'type' => '微信支付'],
        ['code' => '3' , 'type' => '支付宝支付'],
    );
    if($type != -1){
        return $pay_type[$type];
    }else{
        return $pay_type;
    }
}

function base64EncodeImage ($image_file) {
    $base64_image = '';
    $image_info = getimagesize($image_file);
    $image_data = fread(fopen($image_file, 'r'), filesize($image_file));
    $base64_image = 'data:' . $image_info['mime'] . ';base64,' . chunk_split(base64_encode($image_data));
    return $base64_image;
}
//发送短信验证码
// function Post($curlPost,$url){
//     $curl = curl_init();
//     curl_setopt($curl, CURLOPT_URL, $url);
//     curl_setopt($curl, CURLOPT_HEADER, false);
//     curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//     curl_setopt($curl, CURLOPT_NOBODY, true);
//     curl_setopt($curl, CURLOPT_POST, true);
//     curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
//     $return_str = curl_exec($curl);
//     curl_close($curl);
//     return $return_str;
// }
//
// function xml_to_array($xml){
//     $reg = "/<(\w+)[^>]*>([\\x00-\\xFF]*)<\\/\\1>/";
//     if(preg_match_all($reg, $xml, $matches)){
//         $count = count($matches[0]);
//         for($i = 0; $i < $count; $i++){
//         $subxml= $matches[2][$i];
//         $key = $matches[1][$i];
//             if(preg_match( $reg, $subxml )){
//                 $arr[$key] = xml_to_array( $subxml );
//             }else{
//                 $arr[$key] = $subxml;
//             }
//         }
//     }
//     return $arr;
// }

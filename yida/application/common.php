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
* base64 上传
*/
function base_upload($up_dir = '',$base = ''){
    if($up_dir){
        $up_dir = $up_dir;
    }else{
        $up_dir = ROOT_PATH . 'public/static' . DS . 'uploads/';
    }
    if($base){
        if (!file_exists($up_dir)) {
            mkdir($up_dir,0777,true);
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
* 密码加密方式
*/
function sysmd5($param = null){
    if (!empty($param)) {
        return md5(md5(md5($param)));
    }
}
/*
* json数据返回
*/
function jsonReturn($param = null) {
    if(!empty($param)){
        return json_encode($param);
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

/*
* 返回base64 格式图片
*/
function base64EncodeImage($image_file) {
    $base_img = '';
    $image_info = getimagesize($image_file);
    $image_data = fread(fopen($image_file,'r'),filesize($image_file));
    $base64_image = 'data:' . $image_info['mime'] . ';base64,' . chunk_split(base64_encode($image_data));
    return $base64_image;
}

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
*   Md5加密
*/
function sysmd5($param = '')
{
    if (!empty($param)) {
        return md5(md5(md5($param)));
    }
}

/**
* json 返回格式
*/
function jsonReturn($param = '')
{
    if (!empty($param)) {
        return json_encode($param);
    }
}
function deepScanDir($dir, $level=-1)
{
    if ($level == 0) {
        return array('dir'=>array(), 'file'=>array());
    }
    $fileArr = array();
    $dirArr = array();
    $dir = rtrim($dir, '\/');
    if(is_dir($dir)){
        $dirHandle = opendir($dir);
        while(false !== ($fileName = readdir($dirHandle))){
            $subFile = $dir . DIRECTORY_SEPARATOR . $fileName;
            if(is_file($subFile)){
                $fileArr[] = $subFile;
            } elseif (is_dir($subFile) && str_replace('.', '', $fileName)!=''){
                $dirArr[] = $subFile;
                $arr = deepScanDir($subFile, $level==-1?-1:$level-1);
                $dirArr = array_merge($dirArr, $arr['dir']);
                $fileArr = array_merge($fileArr, $arr['file']);
            }
        }
        closedir($dirHandle);
    }
    return array('dir'=>$dirArr, 'file'=>$fileArr);
}
/**
* 返回base64 格式图片
*/
function base64EncodeImage($image_file) {
    $base_img = '';
    $image_info = getimagesize($image_file);
    $image_data = fread(fopen($image_file,'r'),filesize($image_file));
    $base64_image = 'data:' . $image_info['mime'] . ';base64,' . chunk_split(base64_encode($image_data));
    return $base64_image;
}
/**
 * 获取半径地址
 */
function calcScope($lat, $lng, $radius) {
    $degree = (24901*1609)/360.0;
    $dpmLat = 1/$degree;

    $radiusLat = $dpmLat*$radius;
    $minLat = $lat - $radiusLat;       // 最小纬度
    $maxLat = $lat + $radiusLat;       // 最大纬度

    $mpdLng = $degree*cos($lat * (M_PI/180));
    $dpmLng = 1 / $mpdLng;
    $radiusLng = $dpmLng*$radius;
    $minLng = $lng - $radiusLng;      // 最小经度
    $maxLng = $lng + $radiusLng;      // 最大经度

    /** 返回范围数组 */
    $scope = array(
        'minLat'    =>  $minLat,
        'maxLat'    =>  $maxLat,
        'minLng'    =>  $minLng,
        'maxLng'    =>  $maxLng
    );
    return $scope;
}
/**
 * 获取范围数组
 * @return array
 */
function getPos($getIp){
    $content = file_get_contents("http://api.map.baidu.com/location/ip?ak=cgfUI2WrHlGV9zCviIQOEwSbcxFZG6g2&ip={$getIp}&coor=bd09ll");
    $arr = json_decode($content,true);
    $res = calcScope($arr['content']['point']['x'] ,$arr['content']['point']['y'],20000);
    $res['address'] = $arr['content']['address'];
    $res['lat'] = $arr['content']['point']['x'];
    $res['lng'] = $arr['content']['point']['y'];
    return $res;
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
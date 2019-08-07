<?php
/**
 * 司机表
 */

namespace app\index\model;

use think\Model;
class Driver extends Model
{
    protected function getHeaderImgAttr($val){
        if(!empty($val)){
            $value = config('server_url').$val;
        }else{
            $value =  config('server_url').'/static/user/default_head.png';
        }
        return $value;
    }
    protected function getDriverlicensTopAttr($val){
        if(!empty($val)){
            $value = config('server_url').$val;
        }else{
            $value =  $val;
        }
        return $value;
    }
    protected function getDriverlicensUnderAttr($val){
        if(!empty($val)){
            $value = config('server_url').$val;
        }else{
            $value =  $val;
        }
        return $value;
    }
    protected function getDriverlicensHeaderAttr($val){
        if(!empty($val)){
            $value = config('server_url').$val;
        }else{
            $value =  $val;
        }
        return $value;
    }
    protected function getDriverlicensFooterAttr($val){
        if(!empty($val)){
            $value = config('server_url').$val;
        }else{
            $value =  $val;
        }
        return $value;
    }
    protected function getCarPersonAttr($val){
        if(!empty($val)){
            $value = config('server_url').$val;
        }else{
            $value =  $val;
        }
        return $value;
    }
    protected function getPolicyAttr($val){
        if(!empty($val)){
            $value = config('server_url').$val;
        }else{
            $value =  $val;
        }
        return $value;
    }
    protected function getServiceImgAttr($val){
        if(!empty($val)){
            $value = config('server_url').$val;
        }else{
            $value =  $val;
        }
        return $value;
    }
    protected function getCertificationImgAttr($val){
        if(!empty($val)){
            $value = config('server_url').$val;
        }else{
            $value =  $val;
        }
        return $value;
    }
}
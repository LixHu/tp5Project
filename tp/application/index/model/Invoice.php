<?php
/**
 * Created by PhpStorm.
 * User: des16
 * Date: 2018/2/28
 * Time: 12:51
 */

namespace app\index\model;


use think\Model;

class Invoice extends Model
{
    public function getAddTimeAttr($val){
        return date('Y.m.d G:i',$val);
    }
}
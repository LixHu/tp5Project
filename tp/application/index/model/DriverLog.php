<?php
/**
 * Created by PhpStorm.
 * User: des16
 * Date: 2018/2/27
 * Time: 9:26
 */

namespace app\index\model;


use think\Model;

class DriverLog extends Model
{
    protected function getSaveTimeAttr($val){
        return date('Y-n-d G:i',$val);
    }
}
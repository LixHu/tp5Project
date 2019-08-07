<?php
/**
 * Created by PhpStorm.
 * User: des16
 * Date: 2018/3/1
 * Time: 10:06
 */

namespace app\index\model;


use think\Model;

class Account extends Model
{
    public function getAccount($name){
        $info = self::where('`desc` = \''.$name.'\'')->find();
        return $info;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: des16
 * Date: 2018/2/8
 * Time: 8:45
 */

namespace app\index\validate;

use think\Validate;
class Driver extends Validate
{
    protected $rule = [
        'mobile'    =>    'require|unique:driver',
        'password'  =>    'require'
    ];
    protected $message = [
        'mobile.require'      =>     '手机号必填',
        'mobile.unique'       =>     '手机号已经存在',
        'password.require'    =>     '密码必填'
    ];
}
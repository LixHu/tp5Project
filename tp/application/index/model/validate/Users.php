<?php
/**
 * 用户注册验证类
 */
namespace app\index\validate;
use think\Validate;

class Users extends Validate
{
    protected $rule = [
        'mobile'   => 'require|number|unique:users',
        'password' => 'require',
        'type'     => 'require|number'
    ];
    protected $message = [
        'mobile.require'  =>   '手机号必填',
        'mobile.number'   =>   '手机号格式不正确',
        'mobile.unique'   =>   '手机号已经存在',
        'password.require'=>   '手机号必填',
//        'password.max'    =>   '密码最多20位'
    ];
}
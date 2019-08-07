<?php
/**
 *
 */

namespace app\index\validate;

use think\Validate;

class Users extends Validate
{
    protected $regex = [
        'mobile' => '/^0?(13[0-9]|15[0-9]|17[013678]|18[0-9]|14[57])[0-9]{8}$/',
    ];
    protected $rule = [
//        'user_name' => 'require|max:20',
        'nick_name'  => 'require',
        'password' => 'require',
        'mobile' => 'require|number|regex:mobile'
    ];
    protected $message = [
//        'user_name.require'             =>    '用户名必填',
//        'user_name.max'                 =>    '用户名最长20',
        'nick_name.require'              =>    '昵称必填',
        'password.require'              =>    '密码必填',
        'mobile.require'                =>    '手机号必填',
        'mobile.number'                 =>    '手机号必须为数字',
        'mobile.regex'                  =>    '手机号格式不正确'
    ];
}
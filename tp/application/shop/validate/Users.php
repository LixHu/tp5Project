<?php
namespace app\shop\validate;
use think\Validate;
class Users extends Validate
{
    protected $rule = [
        'mobile'    =>  'require|unique:users',
        'password'    =>  'require'
    ];
    protected $message = [
        'mobile.require'  =>   '手机号必填',
        'mobile.unique'   =>   '手机号已经存在',
        'password.require' =>  '密码必填'
    ];
}

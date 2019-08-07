<?php
namespace app\shop\validate;

use think\Validate;

class Driver extends Validate
{
    protected $rule = [
        'mobile'   =>   'require|unique:users',
        'passsword' =>  'require'
    ];
    protected $message = [
        'mobile.require'  =>   '电话必填',
        'mobile.unique'   =>   '电话唯一',
        'password.require'  => '密码必填' 
    ];
}

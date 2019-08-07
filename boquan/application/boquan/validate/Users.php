<?php
/**
 *
 */

namespace app\boquan\validate;

use think\Validate;
class Users extends Validate
{
    protected $rule = [
        'mobile'    => 'require|unique:users',
        'rela_name' => 'require',
//        'user_name' => 'require'
    ];
    protected $message = [
        'mobile.unique'    =>   '手机号已经存在',
        'mobile.require'   =>   '手机号必填',
	    'mobile.unique'    =>   '手机号已经存在',
        'rela_name.require'=>   '姓名必填',
//        'user_name.require'=>   '账户必填',
//        'user_name.unique' =>   '账户已经存在'
    ];
}
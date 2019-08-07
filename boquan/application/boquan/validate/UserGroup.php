<?php
/**
 * 用户组验证类
 */

namespace app\boquan\validate;


use think\Validate;

class UserGroup extends Validate {
	protected $rule = [
		'gname'       =>    'require|unique:user_group',
		'tel'         =>    'require',
		'address'     =>    'require'
	];
	protected $message = [
		'gname.require'    =>   '主机厂名称必填',
		'gname.unique'     =>   '主机厂名称已存在',
		'tel.require'      =>   '电话必填',
		'adderss.require'  =>   '地址必填'
	];
}
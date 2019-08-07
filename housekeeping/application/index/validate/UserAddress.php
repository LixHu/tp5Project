<?php

namespace app\index\validate;

use think\Validate;

class UserAddress extends Validate
{
	protected $rules = [
		'id' => 'require|token',
		'region' => 'require',
		'house_num' => 'require',
		'bus_stops' => 'require'
	];
}
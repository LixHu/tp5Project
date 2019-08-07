<?php
namespace app\index\validate;

use think\Validate;

class DriverOut extends Validate
{
    protected $rule = [
        'did'      =>   'require'
    ];
    protected $message = [
        'did.require'   => '司机ID不存在'
    ];
}

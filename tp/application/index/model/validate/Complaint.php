<?php

namespace app\index\validate;

use think\Validate;

class Complaint extends Validate
{
    protected $rule = [
        'uid'     =>     'require|number',
        'oid'     =>     'require|number',
        'remark'  =>     'require'
    ];
    protected $message = [
        'uid.require'    =>   '用户ID不存在',
        'oid.require'    =>   '订单ID不存在',
        'remark.require' =>   '投诉内容必填'  
    ];
}
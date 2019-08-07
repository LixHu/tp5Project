<?php

namespace app\admin\validate;
use think\Validate;

/**
 *  类型表验证器
 */
class Category extends Validate
{
    protected $rule = [
        'cname'  => 'require|max:16',
        // 'pid'    => '0',
    ];
}

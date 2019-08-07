<?php
namespace app\index\validate;
use think\Validate;
/**
 *
 */
class Email extends Validate
{
    protected $rule = [
        'email'    =>  'require|email'
    ];
}

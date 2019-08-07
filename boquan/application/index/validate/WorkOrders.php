<?php
/**
 * 工单验证类
 */

namespace app\index\validate;

use think\Validate;
class WorkOrders extends Validate
{
    protected $rule = [
        'contact_info'       =>    'require|max:12',
        'address'            =>    'require',
    ];
    protected $message = [
        'contact_info.require'    =>    '联系方式必填',
        'contact_info.max'        =>    '联系方式最多12个字符',
        'contact_info.token'      =>    '请勿重复提交表单',
        'address.require'         =>    '地址必填',
    ];

}
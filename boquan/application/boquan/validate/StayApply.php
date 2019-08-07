<?php
/**
 *
 */

namespace app\boquan\validate;

use think\Validate;
class StayApply extends Validate
{
    protected $rule = [
        'wo_id'        =>  'require|number',
        'apply'        =>  'require|number',
        'apply_reason' =>  'require',
        'apply_num'    =>  'number',
//        'subsity'      =>  '',
        'count_price'  =>  'float'
    ];
    protected $message = [
        'wo_id.require'      =>   '工单ID 必填',
        'wo_id.number'       =>   '工单ID 必须为数字',
        'apply.require'      =>   '申请人ID 必填',
        'apply.number'       =>   '申请人ID 必须为数字',
        'apply_reason'       =>   '申请理由必填',
        'apply_num.number'   =>   '申请天数必须为数字',
        'count_price.float'  =>   '合计费用必须为小数'
    ];
}
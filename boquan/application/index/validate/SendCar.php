<?php
/**
 * 派车申请验证类
 */

namespace app\index\validate;

use think\Validate;
class SendCar extends Validate
{
    protected $rule = [
        'wo_id'         =>     'require|number|token',
        'apper'         =>     'require|number',
        'travel_type'   =>     'require',
        'star_add'      =>     'require',
        'server_add'    =>     'require',
        'km_num'        =>     'float|require',
        'out_time'      =>     'number',
        'out_num'       =>     'number',
        'car_fare'      =>     'number',
        'price'         =>     'float|require'
    ];

    protected $message = [
        'wo_id.require'       =>   '工单ID必填',
        'wo_id.number'        =>   '工单ID必须为数字',
        'apper.require'       =>   '申请人ID必填',
        'apper.number'        =>   '申请人ID必须为数字',
        'travel_type.require' =>   '服务类型必选',
        'star_add.require'    =>   '起始地址必填',
        'server_add.require'  =>   '服务地址必填',
        'km_num.float'        =>   '千米数必须为小数',
        'km_num.require'      =>   '千米数必填',
        'out_time.number'     =>   '出行天数必须为数字',
        'out_num.number'      =>   '出行人数必须为数字',
        'car_fare.number'     =>   '交通费标准ID必填',
        'price.float'         =>   '价格为小数',
        'price.require'       =>   '价格必填'
    ];
}
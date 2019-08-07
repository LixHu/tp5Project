<?php
/**
 * 订单验证类
 */

namespace app\index\validate;

use think\Validate;
class Orders extends Validate
{
    protected $rule = [
        'osn'        => 'unique:orders',
        'car_type'   => 'require|number',
        'make_type'  => 'require|number',
        'uid'        => 'require',
//        'start_lat'  => 'require',
//        'start_lng'  => 'require',
//        'end_lat'    => 'require',
//        'end_lng'    => 'require',
        'start_add'  => 'require',
        'end_add'    => 'require',
        'make_price' => 'require',
        "uid"        => 'require',
//        "km_num"     => 'require'
//        'total_price'=> 'require'
    ];
    protected $message = [
        'osn.unique'         => '订单编号重复',
        'car_type.require'   => '车型必选',
        'uid.require'        => '用户必填',
        'car_type.number'    => '车型为数字',
        'make_type.require'  => '预约类型必选',
        'make_type.number'   => '预约类型为数字',
//        'start_lat.require'  => '开始纬度必填',
//        'start_lng.require'  => '开始经度必填',
//        'end_lat.require'    => '结束纬度必填',
//        'end_lng.require'    => '结束经度必填',
        'start_add.require'  => '开始地址必填',
        'end_add.require'    => '结束地址必填',
        "uid.require"        => '用户ID必填',
//        'km_num.require'     => '千米数必填'
    ];
}
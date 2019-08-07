<?php
/**
 * 用户车辆信息验证类
 */

namespace app\index\validate;


use think\Validate;

class UserCar extends Validate
{
    protected $rule = [
        'uid'         =>   'require|number',
        'license'     =>   'require',
        'engine_type' =>   'require',
        'type'        =>   'require'
    ];
    protected $message = [
        'uid.require'    =>   '用户ID不存在',
        'license.require'=>   '车辆牌照必填',
        'uid.number'     =>   '用户ID 为纯数字',
        'engine_type'    =>   '发动机类型必填',
        'type'           =>   '车辆类型必填'
    ];

}
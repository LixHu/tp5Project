<?php
/**
 * Created by PhpStorm.
 * User: des16
 * Date: 2018/2/28
 * Time: 11:03
 */

namespace app\index\validate;


use think\Validate;

class Invoice extends Validate
{
    protected $rule = [
        'title_type'    =>    'require|number',
        'oid'           =>    'require',
        'title'         =>    'require',
//        'iden_num'      =>    'require',
        'content'       =>    'require',
        'price'         =>    'require',
        'add_person'    =>    'require',
        'mobile'        =>    'require',
        'address'       =>    'require',
        'shipping_type' =>    'require|number',

    ];
    protected $message = [
        'title_type.require'      =>        '抬头类型必选',
        'title_type.number'       =>        '抬头类型为选项',
        'oid.require'             =>        '订单ID必选',
        'title.require'           =>        '发票抬头必填',
//        'iden_num.require'        =>        '纳税人识别号必填',
        'content.require'         =>        '发票内容必填',
        'price.require'           =>        '价格必填',
        'add_person.require'      =>        '收集人必填',
        'mobile.require'          =>        '手机号码必填',
        'shipping_type.require'   =>        '配送方式必选',
        'address.require'         =>        '地址必填',
        'shipping_type.number'    =>        '配送方式为选项',
    ];
}
<?php
namespace app\boquan\validate;
use think\Validate;

/**
 *  WorkOrders验证器
 */
class WorkOrders extends Validate
{
    protected $rule = [
        'wo_sn'          => 'require|number',        #工单编号
        'jour_id'        => 'require|number',        #报修人ID or 客户ID
//        'contact_info'   => 'require',               #联系方式
//        'address'        => 'require',               #客户地址
        // 'server_type'    => 'require',               #服务类型
        // 'server_content' => 'require',               #服务内容
        // 'pro_id'         => 'require',               #产品ID
        // 'charger'        =>  'require'               #负责人
        // 'status'         =>  'require|number'        #工单状态
    ];
    protected $message = [
        'wo_sn.require'          =>   '工单编号必填',
        'wo_sn.number'           =>   '工单编号必须为数字',
        'jour_id.require'        =>   '客户ID/报修人ID必填',
        'jour_id.number'         =>   '客户ID/报修人ID必须为数字',
        'contact_info.require'   =>   '联系方式必填',
        'address.require'        =>   '地址必填',
        // 'server_type.require'    =>   '服务类型必选',
        // 'server_content.require' =>   '服务内容必填',
        // 'pro_id'                 =>   '产品ID必选',
        // 'charger'                =>   '负责人必填',
        // 'status'                 =>   '工单状态必填'
    ];
}

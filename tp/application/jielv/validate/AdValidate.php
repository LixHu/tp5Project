<?php
namespace app\boquan\validate;

use think\Validate;

/**
 * AdValidate验证器
 */
class AdValidate extends Validate
{

    protected $rule = [

        'ad_date|单据日期' => 'require',
        'buyer|工作人员' => 'require', // 工作人员
        'warehouse|仓库' => 'require', // 仓库
        'linkman_cell|联系人手机' => 'require' ,// 联系人手机


    ];

    protected $msg = [

        'ad_date.require' => '单据日期不可为空',
        'client.require' => '客户不可为空',
        'buyer.require' => '工作人员不可为空',
        'warehouse.require' => '仓库不可为空',
        'linkman_cell.number' => '联系人手机必须是数字',

    ];
}
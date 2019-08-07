<?php
/**
 * 审核列表
 */

namespace app\jielv\model;

use think\Model;
class AudList extends Model
{
    protected function getTypeAttr($val){
        $type = [
            1  => '工单审核',
            2  => '采购申请',
            3  => '',
            
        ];
        return $type[$val];
    }

    protected function getStatusAttr($val){
        $status = [
            0  => '',
            1  => '待审核',
            2  => '已审核',
            4  => '待审核',
            6  => '待财务确认',
            7  => '待仓库确认',
            100  => '已入库',
            
        ];
        return $status[$val];
    }

    

}
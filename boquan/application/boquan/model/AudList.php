<?php
/**
 * 审核列表
 */

namespace app\boquan\model;

use think\Model;
class AudList extends Model
{
    protected function getTypeAttr($val){
        $type = [
            1  => '工单审核',
            2  => '采购申请',
            3  => '',
            9  => '派车乘车申请',
            10 => '住宿申请'
            
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
            8  => '审核通过',
            9  => '已驳回',
            100  => '已入库',
            
        ];
        return $status[$val];
    }
    public function saveData($table,$rela_id,$type){
        $adata['gid'] = Session('user')->gid;
        $adata['type'] = $type;
        $adata['table'] = $table;
        $adata['status'] = 1;
        $adata['rela_id'] = $rela_id;
        $adata['add_time'] = time();
        self::allowField(true)->save($adata);
    }

}
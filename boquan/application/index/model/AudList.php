<?php
/**
 * 审核列表
 */

namespace app\index\model;

use think\Model;
class AudList extends Model
{
    public function saveData($table,$rela_id,$type){
        $adata['gid'] = Session('driver')->gid;
        $adata['type'] = $type;
        $adata['table'] = $table;
        $adata['status'] = 1;
        $adata['rela_id'] = $rela_id;
        $adata['add_time'] = time();
        self::allowField(true)->save($adata);
    }
}
<?php
/**
 * 住宿申请
 */

namespace app\boquan\model;

use think\Model;
class StayApply extends Model
{
    public function getInfo($wid){
        $info = self::alias('a')
            ->field('a.*,b.wo_sn,c.user_name as appername')
            ->join('work_orders b','a.wo_id = b.wo_id')
            ->join('users c','a.apply = c.uid')
            ->where('a.wo_id ='.$wid)
            ->find();
        return $info;
    }
}
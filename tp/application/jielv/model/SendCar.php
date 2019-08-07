<?php
/**
 * 派车申请
 */

namespace app\jielv\model;

use think\Model;
class SendCar extends Model
{
    public function getInfo($wid){
        $info = self::alias('a')
            ->field('a.*,b.wo_sn,c.user_name as appername')
            ->join('work_orders b','a.wo_id = b.wo_id')
            ->join('users c','a.apper = c.uid')
            ->where('a.wo_id ='.$wid)
            ->find();
        return $info;
    }
}
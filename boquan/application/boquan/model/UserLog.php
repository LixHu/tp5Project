<?php
/**
 * 用户日志
 */

namespace app\boquan\model;

use think\Model;
class UserLog extends Model
{
    public function WriteLog($str,$uid)
    {
        $data = [];
        $data['log_desc'] = $str;
        $data['uid'] = $uid;
        $data['is_read'] = 2;
        $data['add_time'] = time();
        $res = self::save($data);
        if ($res){
            return true;
        }else{
            return false;
        }
    }
}
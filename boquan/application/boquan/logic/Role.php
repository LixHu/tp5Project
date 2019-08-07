<?php
namespace app\boquan\logic;
use think\Model;

/**
 *  Role
 */
class Role extends Model
{
    public function getDerpart($gid = 0)
    {
        if ($gid) {
            $list = self::where('gid ='.$gid)->order('`order` asc')->select();
            return $list;
        }
    }
}

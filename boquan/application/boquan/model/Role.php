<?php
/**
 * 角色
 */

namespace app\boquan\model;

use think\Model;

class Role extends Model
{
    /**
     * 获取当前组内角色列表
     * @param int $gid
     * @return object $list
     */
    public function getRoleList($gid = 0){
        if ($gid){
            $list = self::where('gid ='.$gid)->select();
            return $list;
        }
    }

    /**
     * 获取角色权限
     * @param int $rid
     * @return object $role_menu
     */
    public function getRoleMenu($rid = 0)
    {
        if ($rid) {
            $info = self::get($rid);
            $role_menu['gid'] = $info->gid;
            $role_menu['menu'] = explode(',',$info->mid);
            return $role_menu;
        }
    }
}
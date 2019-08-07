<?php
/**
 * 用户组
 */

namespace app\boquan\logic;

use think\Model;
use think\Session;

class UserGroup extends Model
{
    /**
     * @param $gid
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getAllGroupRole($gid)
    {
        $list = self::alias('a')
//                    ->join('users b','a.gid = b.gid')
                    ->join('role c','a.gid = c.gid','left')
                    ->where('a.gid ='.$gid )
                    ->select();
        return $list;
    }
    /**
     * 获取所有的用户组
     */
    public function getGroupData($where)
    {
        if(!empty($where)){
            $where = $where;
        }
        if(!empty($where['gname'])){
            $where['gname'] = ['like','%'.$where['gname'].'%'];
        }
//        $where['b.pid'] = 1;
        if (Session('user')->pid == 0) {
            $where['a.pid'] = 1;
        }else{
            $where['a.pid'] = Session('user')->gid;
        }
        $grouplist = self::alias('a')
                    ->field('a.*,c.uid,c.rela_name,c.nick_name')
//                    ->join('Role b','a.gid = b.gid')
                    ->join('Users c','a.gid = c.gid','left')    //b.rid = c.rid
                    ->where($where)
                    ->group('a.gid')
                    ->select();
//        echo self::getLastSql();
        if (Session('user')->pid == 0) {
            foreach ($grouplist as $key => $val){
                $where['a.pid'] = $val['gid'];
                $grouplist[$key]['child'] = self::alias('a')
                    ->field('a.*,c.uid,c.rela_name,c.nick_name')
                    ->join('Users c','a.gid = c.gid','left')    //b.rid = c.rid
                    ->where($where)
                    ->group('a.gid')
                    ->select();
            }
        }
        return $grouplist;
    }
    /**
     * 修改用户组
     */
    public function editData($data){
        if(!empty($data['gid'])){
            $where['gid'] = $data['gid'];
            unset($data['gid']);
            if(self::allowField(true)->save($data,$where)){
                return '';
            }else{
                return '修改失败';
            }
        }
    }
    /**
     * 存取用户组及用户组负责人
     */
    public function saveData($data)
    {
        $msg = '';
        $pid = Session('user')->pid;
        $have = self::where('gname = \''.$data['gname'].'\'')->find();
        if(empty($have)){
            if($pid == 0){
                $data['aid'] = 2;
                $data['pid'] = 1;     // 1为主机厂
            }else{
                $data['aid'] = 4;
                $data['pid'] = Session('user')->gid;     // 设为主机厂下面的服务站
            }

            if(self::allowField(true)->save($data)){    // 添加一条数据到用户组表
                $msg = '';
            }
            $Insgid = self::getLastInsID();
            // 添加主机厂的时候把对应角色加进去
            $rdata = [
                ['rname' => '系统管理员','gid' => $Insgid,'mid' => "1,10,15,20,28,31,53,59,2,3,4,5,8,9,38,41,11,12,13,14,16,17,18,19,21,22,29,30,32,33,34,35,36,42,54,61,62,63,60"],
                ['rname' => '经理','gid' => $Insgid,'mid' => "53,38,42,54,61,62,63"],
                ['rname' => '工单管理员','gid' => $Insgid,'mid' => "1,2,3,4,5,8,9,38,41,56,63"],
                ['rname' => '财务', 'gid' => $Insgid,'mid' => "10,53,11,12,13,14,61"],
                ['rname' => '仓库', 'gid' => $Insgid,'mid' => "15,16,17,18,62"],
                ['rname' => '采购员', 'gid' =>  $Insgid,'mid' => ""],
                ['rname' => '维修工','gid' => $Insgid,'mid' => "1,2,4,43"],
            ];
            $role = model('Role','logic');
            $arr = $role->saveAll($rdata,false);
            // 角色添加完把负责人添加进去
            if(!empty($data['chager'])){
//                    $msg = '';
                $user = model('Users','model');
                $udata['gid'] = $Insgid;
                $udata['mobile'] = $data['mobile'];
                $udata['password'] = sysmd5($data['password']);
                $udata['rid'] = $arr[0]->rid;
                $udata['status'] = 1;
                $udata['user_name'] = $data['chager'];
                if($user->save($udata)){
                    $msg = '';
                }
            }else{
                $msg = '请填写负责人';
            }
        }
        return $msg;
//        $msg = '';
//        $data['aid'] = 2;
//        $have = self::where('gname = \''.$data['gname'].'\'')->find();
//        if(empty($have)){
//            if(self::allowField(true)->save($data)){
//                $flag = true;
//            }
//            // 如有负责人 往用户表中添加负责人数据
//            if(!empty($data['chager'])){
//                $flag = false;
//                $gid = self::getLastInsID();
//                $role = model('Role','logic');
//                $menu = model('Menu','model');
//                $mlist = $menu->where('type = 1')->select();
//                $str = '';
//                foreach($mlist as $key => $val){
//                    $str .= ','.$val['mid'];
//                }
//                $str = substr($str,1);
//                $rodata = array('gid' => $gid,'rname' => '超级管理员','pid' => 1 ,'mid' => $str);
//                $role->save($rodata);
//                $rid = $role->getLastInsID();
//                $udata = array('rid' => $rid ,'user_name' => $data['chager'] ,'password' =>  sysmd5($data['password']) ,'add_time' => time()
//                    ,'aud_status' =>  1,'mobile' => $data['mobile']);
//                $user = model('Users','model');
//                $user->save($udata);
//                $flag = true;
//            }else{
//                $flag = true;
//                $msg = '请填写负责人';
//            }
//        }else{
//            $msg = "账户名已经存在";
//        }
//        if(!$flag){
//            $msg = '';
//        }else{
//            $msg = $msg;
//        }
//        return $msg;
    }
    /**
     * 获取用户组详情
     */
    public function getGroupInfo($gid)
    {
        $info = self::alias('a')
                ->field('a.*,c.user_name')
//                ->join('role b','a.gid = b.gid')
                ->join('users c','a.gid = c.gid','left')     //b.rid = c.rid
                ->where('a.gid ='.$gid)
                ->find();
        return $info;
    }
}

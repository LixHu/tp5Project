<?php
/**
 * 用户组
 */

namespace app\jielv\logic;

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
                    ->join('users b','a.gid = b.gid')
                    ->join('role c','b.rid = c.rid')
                    ->where('a.gid ='.$gid .' and b.rid = 9')
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
                    ->field('a.*,c.uid,c.user_name,c.nick_name')
//                    ->join('Role b','a.gid = b.gid')
                    ->join('Users c','a.gid = c.gid')    //b.rid = c.rid
                    ->where($where)
                    ->select();
        if (Session('user')->pid == 0) {
            foreach ($grouplist as $key => $val){
                $where['a.pid'] = $val['gid'];
                $grouplist[$key]['child'] = self::alias('a')
                                                ->field('a.*,c.uid,c.user_name,c.nick_name')
                                                ->join('Users c','a.gid = c.gid')    //b.rid = c.rid
                                                ->where($where)
                                                ->select();
            }
        }
        return $grouplist;
    }
    /**
     * 修改用户组
     */
    public function editData($data){
       
            return $this->allowField(true)->save($data,['gid'=>$data['gid']]);
        
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

            self::allowField(true)->save($data);
            if(!empty($data['chager'])){
//                    $msg = '';
                $user = model('Users','model');
                $udata['gid'] = self::getLastInsID();
                $udata['mobile'] = $data['mobile'];
                $udata['password'] = sysmd5($data['password']);
                $udata['rid'] = 3;
                $udata['status'] = 1;
                $udata['user_name'] = $data['chager'];
                $udata['mid'] = $data['mid'];
                $udata['add_time'] = time();
                return $user->save($udata);
            }
        }
        
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
                ->join('users c','a.gid = c.gid')     //b.rid = c.rid
                ->where('a.gid ='.$gid)
                ->find();
        return $info;
    }


    
}

<?php
namespace app\boquan\model;
use think\Model;
/**
 * Users
 */
class Users extends Model
{
//    public function getStatusAttr($value){
//        $status = ['1' => '启用','0' => '禁用'];
//        return $status[$value];
//    }
    /**
    * 获取用户权限菜单
    */
    public function getMenu($uid = '')
    {
        $menu = new Menu;
        if (!empty($uid)) {
            $list = self::alias('a')
                    ->join('role b','a.rid = b.rid')
                    ->where('a.uid = '.$uid)
                    ->find();
            $mlist = $menu
                    ->where('mid in ('.$list['mid'].')')
                    ->order('`order` asc')
                    ->select();
            $data = $mlist;
            return $data;
        }
    }
    /**
     * 获取展示菜单
     */
    public function getShowMenu($uid = '')
    {
        $menu = new Menu;
        if (!empty($uid)) {
            $list = self::alias('a')
                ->join('role b','a.rid = b.rid')
                ->where('a.uid = '.$uid)
                ->find();
            $mlist = $menu
                ->where('mid in ('.$list['mid'].')')
                ->order('`order` asc')
                ->where('type =  1')
                ->select();
            $data['mdata'] = $mlist;
            return $data;
        }
    }
    /**
     * 获取当前用户详情
     */
    public function getUserInfo($uid = ''){
        if (!empty($uid)){
            $info = self::where('uid ='.$uid)->find();
            return $info;
        }
    }
    /**
    * 获取用户详情
    */
    public function getInfo($data = [])
    {
        $info = self::alias('a')
                ->field('a.*,c.gid,c.gname,c.pid,d.aid')
            //    ->join('role b','a.rid = b.rid')
                ->join('user_group c','a.gid = c.gid')
                ->join('admin d','c.aid = d.aid')
                ->where($data)
                ->find();
        // echo self::getLastSql();
        return $info;
    }   
    /**
     * 获取对应组列表
     */
    public function getGroupList($gid = '',$where = []){
        if (!empty($gid)){
            $arr  = [];
            if (!empty($where)){
                $arr = $where;
            }
            $arr['a.gid'] = $gid;
            $list = self::alias('a')
                    ->join('role b','a.rid = b.rid')
                    ->where($arr)
                    ->select();
            return $list;
        }
    }
    /**
     * 获取组内未审核用户列表
     */
    public function getGroupAudData($gid){
        if($gid){
            $list = self::alias('a')
                    ->field('a.*')
                    ->join('role b','a.rid = b.rid')
                    ->join('user_group c','b.gid = c.gid')
                    ->where('c.gid ='.$gid .' and a.aud_status = 1')
                    ->select();
            return $list;
        }
    }
    /**
     * 获取客户列表
     */
    public function getDriver($where)
    {
        $list = self::where('rid = 2')->where($where)->select();
        return $list;
    }
    /**
     * 获取搜索的用户组下的角色
     */
    public function getSearchUser($keyword)
    {
        if (!empty($keyword)){
            $list = self::alias('a')
                ->join('role b','a.rid = b.rid')
                ->where('b.gid ='.Session('user')->gid.' and a.user_name REGEXP \''.$keyword.'\'')
                ->select();
            return $list;
        }
    }
    /**
     * 添加角色下用户
     */
    public function saveRole($data)
    {
        $res = array('code' => 2,'msg' => '失败');
        $data['rid'] = $data['roleid'];
        if(!empty($data['password'])){
            $data['password'] = sysmd5($data['password']);
        }else{
            unset($data['password']);
        }
        $vali = validate('Users');
        $have = self::where('mobile = \''.$data['mobile'].'\'')->find();
        if(!empty($have)){
            $where['uid'] = $have->uid;
			if(self::allowField(true)->save($data,$where)){
				$res = array('code' => 1,'msg' => '成功');
			}
        }else{
//            if(!empty($have)){
//                $res = array('code' => 2,'msg' => '手机号或者用户名已经存在');
//            }

            if($vali->check($data)) {
                if (self::allowField(true)->save($data)) {
                    $res = array('code' => 1, 'msg' => '成功');
                }
            }else{
                $res = array('code' => 2, 'msg' => $vali->getError());
            }
        }
        return $res;
    }
}

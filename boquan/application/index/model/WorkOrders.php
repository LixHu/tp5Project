<?php
/**
 * 工单
 */

namespace app\index\model;

use think\Model;
use think\Session;

class WorkOrders extends Model
{
    protected $insert = ['wo_sn'];
    protected $update = ['handle_time'];
    protected function setHandleTimeAttr(){
        return time();
    }
    protected function setWoSnAttr(){
        return date('ymdhis').rand(10,99);
    }

    /**
     * 获取对应状态工单
     * @param $status
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getStatusData($status){

        $where = 'a.status ='.$status;
        if($status != 1){
            $user = model('Users','model');
            $where .= ' and a.gid = '.$user->getGroup(Session('driver')->uid);
        }
        $list = self::alias('a')
            ->field('a.*,b.nick_name as jour_name,c.nick_name as uname')
            ->join('users b','a.jour_id = b.uid','left')
            ->join('users c','a.uid = b.uid','left')
            ->where($where)
            ->select();
        return $list;
    }

    /**
     * 获取用户状态工单
     * @param $status
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getUserData($status)
    {
        $where = '1 = 1';
        if ($status == 9){
            $where .= ' and a.uid = '.Session('driver')->uid;
        }else if($status == 5){
            $where .= ' and a.uid = '.Session('driver')->uid.' and a.status >='.$status.' and a.status < 9';
        }else if($status == 3){
            $where .= ' and a.uid = '.Session('driver')->uid.' and a.status ='.$status;
        }else if($status == 4){
            $where .= ' and a.uid = '.Session('driver')->uid .' and (a.status ='.$status.' or a.status = 9 or a.status = 11)';
        }else if($status == 1){
            $where .= ' and a.uid = '.Session('driver')->uid;
        }else{
            $where .= ' and a.uid = '.Session('driver')->uid.' and (a.status >= 5 or a.status = 11)';
        }
        $list = self::alias('a')
            ->field('a.*,b.nick_name as jour_name,c.client_name as jour_name2,b.mobile as jour_mobile,b.address as jour_add,
            c.client_tel as jour_mobile2,c.client_address as jour_add2')
            ->join('users b','a.jour_id = b.uid','left')
            ->join('client c','a.jour_id = c.id','left')
            ->where($where)
            ->order('add_time desc')
            ->select();
        return $list;
    }

    /**
     * 派车申请
     */
    public function getSendApply($uid)
    {
        $list = self::alias('a')
            ->field('b.*,a.wo_sn')
            ->join('send_car b','a.wo_id = b.wo_id')
            ->where('a.uid = '.$uid)
            ->select();
        return $list;
    }
    /**
     * 住宿申请
     */
    public function getStayApply($uid)
    {
        $list = self::alias('a')
            ->field('b.*,a.wo_sn')
            ->join('stay_apply b','a.wo_id = b.wo_id')
            ->where('a.uid = '.$uid)
            ->select();
        return $list;
    }
}
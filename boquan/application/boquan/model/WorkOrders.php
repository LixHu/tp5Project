<?php
namespace app\boquan\model;

use think\Model;
/**
 *  工单管理
 */
class WorkOrders extends Model
{

    protected $insert = ['gid'];
    protected $update = ['handle_time'];
    protected function setGidAttr(){
        return Session('user')->gid;
    }
    protected function setHandleTimeAttr()
    {
        return time();
    }
    protected function getStatusAttr($val){
        $status = [
            0 => '',
            1 => '待指派',
            2 => '待指派',
            3 => '已指派',
            4 => '已接受',
            5 => '已完成',
            6 => '已完成',
            7 => '已关闭',
            8 => '待抢单',
            9 => '进行中',
            10 => '待审核',
            11 => '故障处理中'
        ];
        return $status[$val];
    }
    protected function getPidAttr($val){
        $pid = [
            0 => '',
            1 => '低',
            2 => '中',
            3 => '高'
        ];
        return $pid[$val];
    }
    /**
     * 获取工单详情
     */
    public function getWorkInfo($wo_id)
    {
        $info = self::alias('a')
                ->field('a.*,b.nick_name as jour_name,b.user_name as custom_name,
                c.name as server_content1,d.user_name as chare_name,e.nick_name as add_name,
                e.user_name as add_name2,f.name,cl.client_name as cus_name,cl.client_tel as cus_mobile,cl.client_address as cus_address')
                ->join('users b','a.jour_id = b.uid','left')
                ->join('services c','a.server_content = c.id','left')
                ->join('users d','a.uid = d.uid','left')
                ->join('users e','a.add_uid = e.uid','left')
                ->join('parts f','a.pro_id = f.id','left')
                ->join('client cl','a.jour_id = cl.id','left')
                ->where('a.wo_id ='.$wo_id)
                ->find();
        return $info;
    }
}

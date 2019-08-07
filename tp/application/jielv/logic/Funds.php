<?php
/**
 * 资金管理
 */

namespace app\jielv\logic;

use think\Model;
class Funds extends Model
{
    protected $update = ['handle_time'];
    protected function setHandleTimeAttr(){
        return time();
    }
    protected function getStatusAttr($val){
        $status = ['','已结算','未结算'];
        return $status[$val];
    }

    /**
     * 获取对应状态的数据
     * @param int $status
     * @param array $param
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getStatusData($status = 0 ,$param = []){
        if ($status){
            $where = [];
            if (!empty($param)){
                $where = $param;
            }
            $where['fund_status'] = $status;
            $list = self::alias('a')
                ->field('a.*,b.wo_sn,c.nick_name as custom_name')
                ->join('work_orders b','a.wo_id = b.wo_id','left')
                ->join('users c','a.custom_id = c.uid','left')
                ->where($where)
                ->select();
            return $list;
        }
    }

    /**
     * 存取资金动态
     * @param $wid
     * @return bool
     */
    public function saveData($wid)
    {
        $data = [];
        $order = model('WorkOrders','model');
        $price = 0;
        $serprice = $order->alias('a')
            ->field('a.wo_sn,b.price,a.server_type')
            ->join('service b','a.server_content = b.id')
            ->where('wo_id ='.$wid)
            ->find();
        if(!empty($serprice)){
            $price += $serprice['price'];
        }
        $proprice = $order->alias('a')
                ->join('parts b','a.pro_id = b.id')
                ->where('wo_id ='.$wid)
                ->find();
        if(!empty($proprice)){
            $price += $proprice['price'];
        }
        $data['wo_id'] = $price['wo_sn'];
        $data['status'] = 2;
        $data['custom_id'] = $price['jour_id'];
        $data['fund_status'] = 1;
        $data['billt_time'] = time();
        $data['is_bill'] = 1;
        $data['must_bill_price'] = sprintf('%.2f',$price);  #写入总价
        $data['not_bill_price'] = sprintf('%.2f',$price);
        $data['add_time'] = time();
        if(self::save($data)){
            return true;
        }else{
            return false;
        }
    }
    /**
     * 更改状态
     */
    public function setStatus($data,$where)
    {
        if(self::save($data,$where)){
            return true;
        }else{
            return false;
        }
    }
}
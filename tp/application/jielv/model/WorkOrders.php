<?php
namespace app\jielv\model;

use think\Model;
/**
 *  工单管理
 */
class WorkOrders extends Model
{
    protected $name = 'orders';
    /**
     * 订单列表
     */
    public function getworkorder_all()
    {
        return $this->field(true)->where('status',7)->order('oid desc')->paginate(10);
    }

    /**
     * 按分类查询订单
     */
    public function getcid($cid,$make_time)
    {
        return $this->field(true)->where(['make_time'=>['>',$make_time],'cid'=>$cid])->order('cid asc')->paginate(10,false,['query' => request()->param(), ]);
    }

    /**
     * 搜索
     */
    public function search_list($keywords,$make_time)
    {    
        return $this->field(true)->where(['osn|end_add'=>['like','%'.$keywords.'%']])->order('oid desc')->paginate(10,false,['query' => request()->param(), ]);
    }
}

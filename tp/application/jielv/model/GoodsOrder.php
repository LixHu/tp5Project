<?php
namespace app\jielv\model;

use think\Model;

class GoodsOrder extends Model
{

    protected $name = 'goods_order';

   

    /**
     * 获取订单列表
     */
    public function getorder_list()
    {    
        return $this->field(true)->order('id desc')->paginate(10);
    }


    /**
     * 搜索
     */
    public function search_list($keywords)
    {    
        return $this->field(true)->where(['order_number|user_name'=>['like','%'.$keywords.'%']])->order('id desc')->paginate(10);
    }

    /**
     * 批量删除
     */
    
    public function del($param){
        return $this->destroy($param);
    }
}
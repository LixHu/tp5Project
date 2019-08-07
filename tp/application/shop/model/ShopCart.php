<?php
namespace app\shop\model;

use think\Model;

class ShopCart extends Model
{

    protected $name = 'shop_cart';

    /**
     * 获取商品信息
     */
    public function getcart($uid)
    {   
        return $this->field(true)->where('uid',$uid)->find();
    }

    /**
     * 加入商品
     */
    public function addcart($param)
    {   
        return $this->allowField(true)->save($param);
    }


    /**
     * 根据id获取一条信息
     * 
     * @param
     *            $id
     */
    public function getOneAd($id)
    {
        return $this->where('id', $id)->find();
    }

    /**
     * 编辑
     * 
     * @param
     *            $param
     */
    public function save_cart($param)
    {
        return $this->allowField(true)->save($param, ['uid' =>$param['uid']]);
    }
}
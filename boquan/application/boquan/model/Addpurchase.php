<?php
namespace app\boquan\model;

use think\Model;

class Addpurchase extends Model
{

    protected $name = 'add_purchase';
    /**
     * 新增
     * 
     */
    public function adpurchase($param)
    {
        return $this->allowField(true)->save($param);
    }
}
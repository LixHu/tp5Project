<?php
namespace app\shop\model;

use think\Model;

/**
 * 优惠券管理
 */
class PartsCate extends Model
{

    protected $name = 'partscate';

    /**
     * 获取产品分类
     */
    public function getpartscate()
    {
        return $this->field(true)->select();
    }

  //新建产品分类
 
  public function adcate($param){

  	return $this->allowField(true)->save($param);
  }
}

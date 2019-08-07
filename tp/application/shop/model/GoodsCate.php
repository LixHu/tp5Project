<?php
namespace app\jielv\model;

use think\Model;

/**
 * 商城分类管理
 */
class GoodsCate extends Model
{

    protected $name = 'goods_cate';

    /**
     * 获取产品分类
     */
    public function cate_all()
    {
        return $this->field(true)->select();
    }

  //新建产品分类
 
  public function cate_add($param){

    return $this->allowField(true)->save($param);
  }


}

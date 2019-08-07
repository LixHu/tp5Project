<?php
namespace app\boquan\model;

use think\Model;

/**
 * 工单管理
 */
class PartsCate extends Model
{

    protected $name = 'partscate';

    /**
     * 获取产品分类
     */
    public function getpartscate($gid)
    {
        return $this->field(true)->where('gid',$gid)->select();
    }

  //新建产品分类
 
  public function adcate($param){

  	return $this->allowField(true)->save($param);
  }
}

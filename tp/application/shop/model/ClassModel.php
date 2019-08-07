<?php
namespace app\shop\model;

use think\Model;


class ClassModel extends Model
{

    protected $name = 'class';

    /**
     * 获取课堂列表
     */
    public function get_class_all()
    {    
        return $this->field(true)->order('id desc')->paginate(10);
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



}

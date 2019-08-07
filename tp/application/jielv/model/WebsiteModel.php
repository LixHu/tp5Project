<?php

namespace app\jielv\model;

use think\Model;
class WebsiteModel extends Model
{
	protected $name = 'banner';

	/**
     * 轮播图列表
     */
    public function banner_all()
    {   
       
        return $this->field(true)->order('id desc')->paginate(10);
    }

    /**
     * 编辑
     * 
     */
    public function edit_banner($param)
    {
        return $this->save($param, ['id' => $param['id']]);
    }


    /**
     * 根据id获取一条消息详情
     */
    public function getOne($id)
    {
        return $this->where('id',$id)->find();
    }
    /**
     * 新增
     */
    public function ad_banner($param)
    {
        return $this->allowField(true)->save($param);
    }


    /**
     * 批量删除
     */
    
    public function del($param){
        return $this->destroy($param);
    }
}
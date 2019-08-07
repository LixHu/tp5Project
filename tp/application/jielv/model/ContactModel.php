<?php

namespace app\jielv\model;

use think\Model;
class ContactModel extends Model
{
	protected $name = 'contact';

	/**
     * 公司信息
     */
    public function contact()
    {   
       
        return $this->field(true)->order('id desc')->paginate(10);
    }

    /**
     * 编辑
     * 
     */
    public function edit_contact($param)
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
    public function ad_contact($param)
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
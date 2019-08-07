<?php
namespace app\boquan\model;

use think\Model;

class Client extends Model
{

    protected $name = 'client';

    /**
     * 获取客户列表
     */
    public function getclientAll($gid)
    {   
        
        return $this->field(true)->where('gid',$gid)->order('id desc')->paginate(10);
    }

    /**
     * 编辑客户
     * 
     */
    public function editclient($param)
    {
        return $this->save($param, ['id' => $param['id']]);
    }


    /**
     * 根据id获取一条消息详情
     */
    public function getone($id)
    {
        return $this->where('id',$id)->find();
    }
    /**
     * 新增客户
     */
    public function addclient($param)
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
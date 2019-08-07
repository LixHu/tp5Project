<?php
namespace app\jielv\model;

use think\Model;

class Client extends Model
{

    protected $name = 'users';

    /**
     * 获取客户列表
     */
    public function getclientAll()
    {   
        
        return $this->field(true)->order('uid desc')->paginate(10);
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
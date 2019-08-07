<?php
namespace app\boquan\model;

use think\Model;

class Bank extends Model
{

    protected $name = 'bank';

    /**
     * 获取全部信息
     */
    public function getbankAll($gid)
    {   
        
        return $this->field(true)->where('gid',$gid)->order('id desc')->paginate(10);
    }

    /**
     * 编辑服务
     * 
     */
    public function edit_bank($data)
    {
        return $this->save($data, ['id' => $data['id']]);
    }


    /**
     * 根据id获取一条数据
     */
    public function getOne($id)
    {
        return $this->where('id',$id)->find();
    }
    /**
     * 新增
     */
    public function add_bank($param)
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
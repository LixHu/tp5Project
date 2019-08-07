<?php
namespace app\boquan\model;

use think\Model;

class Serviceparts extends Model
{

    protected $name = 'service_parts';

    public function getall($uid)
    {   
        
        return $this->field(true)->where('uid',$uid)->order('id asc')->select();
    }

    /**
     * 添加
     */
    public function addcheck($data)
    {
        return $this->allowField(true)->save($data);
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


    /**
     * 删除
     */
    
    public function del($param){
        return $this->destroy($param);
    }

   
}

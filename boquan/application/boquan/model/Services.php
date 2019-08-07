<?php
namespace app\boquan\model;

use think\Model;

class Services extends Model
{

    protected $name = 'services';

    /**
     * 获取服务列表
     */
    public function getserviceAll()
    {   
        $gid = json_decode(session('user')['gid']);//获取到当前操作用户的分类ID
        return $this->field(true)->where('gid',$gid)->order('id desc')->paginate(10);
    }

    /**
     * 编辑服务
     * 
     */
    public function editservice($data)
    {
        return $this->save($data, ['id' => $data['id']]);
    }


    /**
     * 根据id获取一条消息详情
     */
    public function getmessage($id)
    {
        return $this->where('id',$id)->find();
    }
    /**
     * 新增
     */
    public function addservice($param)
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
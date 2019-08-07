<?php
namespace app\index\model;

use think\Model;

/**
 * 工单管理
 */
class Parts extends Model
{

    protected $name = 'parts';

    /**
     * 获取产品列表
     */
    public function getpartsall()
    {   
        $gid = json_decode(session('user')['gid']);//获取到当前操作用户的分类ID
        return $this->field(true)->where('gid',$gid)->order('id desc')->paginate(10);
    }

    /**
     * 新建产品
     */
    public function addparts($data)
    {
        return $this->allowField(true)->save($data);
    }

    /**
     * 编辑产品
     * 
     * @param
     *            $param
     */
    public function editparts($param)
    {
        return $this->allowField(true)->save($param, ['id' =>$param['id']]);
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
     * 批量删除
     */
    
    public function del($param){
        return $this->destroy($param);
    }


}

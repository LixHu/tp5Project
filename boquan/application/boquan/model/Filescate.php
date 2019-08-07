<?php
namespace app\boquan\model;

use think\Model;

class Filescate extends Model
{

    protected $name = 'filecate';

    /**
     * 获取文件类别
     */
    public function getfilecate()
    {   $gid = json_decode(session('user')['gid']);//获取到当前操作用户的分类ID
        return $this->field(true)->where('gid',$gid)->select();
    }

    /**
     * 添加文件类别
     */
    public function addfilecate($adfilecate)
    {
        return $this->allowField(true)->save($adfilecate);
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
     * 编辑
     * 
     * @param
     *            $param
     */
    public function edit_cate($param)
    {
        return $this->allowField(true)->save($param, ['id' =>$param['id']]);
    }
}
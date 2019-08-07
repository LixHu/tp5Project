<?php
namespace app\boquan\model;

use think\Model;

class Files extends Model
{

    protected $name = 'file';

    /**
     * 获取文件库列表
     */
    public function getfileall()
    {   
        $gid = json_decode(session('user')['gid']);//获取到当前操作用户的分类ID
        return $this->field(true)
            ->where('gid',$gid)
            ->order('id desc')
            ->paginate(10);
    }

    /**
     * 新增文件及附件
     * 
     * @param
     *            $param
     */
    public function adfile($addfile)
    {
        return $this->allowField(true)->save($addfile);
    }

    /**
     * 批量删除
     */
    
    public function del($param){
        return $this->destroy($param);
    }
}
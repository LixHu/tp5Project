<?php
namespace app\boquan\model;

use think\Model;

/**
 * ========================================================
 * ==盘点管理==
 * ========================================================
 */
class Check extends Model
{

    protected $name = 'check';
 // 盘点产品
    
    /**
     * 获取盘点列表
     */
    public function getcheckall()
    {   
        $gid = json_decode(session('user')['gid']);//获取到当前操作用户的分类ID
        return $this->field(true)->where('gid',$gid)->order('cid desc')->paginate(10);
    }

    /**
     * 更新盘点产品
     */
    public function addcheck($parts_list)
    {
        return $this->allowField(true)->save($parts_list);
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

<?php
namespace app\jielv\model;

use think\Model;

/**
 * ========================================================
 * ==库存管理==
 * ========================================================
 */
class Inventory extends Model
{

    protected $name = 'supplier';
 // 供应商表
    
    /**
     * 获取供应商列表
     */
    public function getsupplierall()
    {   
        $gid = json_decode(session('user')['gid']);//获取到当前操作用户的分类ID
        return $this->field(true)->where('gid',$gid)->order('id desc')->paginate(10);
    }

    /**
     * 新增供应商
     */
    public function addsupplier($param)
    {
        return $this->allowField(true)->save($param);
    }

    /**
     * 编辑供应商
     * 
     * @param
     *            $param
     */
    public function editsupplier($param)
    {
        return $this->allowField(true)->save($param,['id' => $param['id']]);
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

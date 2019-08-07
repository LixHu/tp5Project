<?php
namespace app\boquan\model;

use think\Model;

/**
 * ========================================================
 * ==安全库存管理==
 * ========================================================
 */
class Safety extends Model
{

    protected $name = 'safety';
 // 安全库存产品
    
    /**
     * 获取安全库存列表
     */
    public function getcheckall()
    {   
        $gid = json_decode(session('user')['gid']);//获取到当前操作用户的分类ID
        return $this->field(true)->where('gid',$gid)->order('cid desc')->paginate(10);
    }

    /**
     * 更新安全库存产品
     */
    public function addsafety($parts_list)
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

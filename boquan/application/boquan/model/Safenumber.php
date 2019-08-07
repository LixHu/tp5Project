<?php
namespace app\boquan\model;

use think\Model;

/**
 * ========================================================
 * ==安全库存值==
 * ========================================================
 */
class Safenumber extends Model
{

    protected $name = 'safenumber';
 
    
    /**
     * 获取安全库存列表
     */
    public function getsafenumberall()
    {   
        $gid = json_decode(session('user')['gid']);//获取到当前操作用户的分类ID
        return $this->field(true)->where('gid',$gid)->order('id desc')->find();
    }

    /**
     * 更新安全库存范围
     */
    public function addsafety($number)
    {   
        
        return $this->allowField(true)->save($number);
    }

    

    

   
}

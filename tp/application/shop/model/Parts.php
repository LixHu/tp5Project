<?php
namespace app\shop\model;

use think\Model;

/**
 * 优惠券管理
 */
class Parts extends Model
{

    protected $name = 'parts';

    /**
     * 获取优惠券列表
     */
    public function getpartsall()
    {    
        return $this->field(true)->order('id desc')->paginate(10);
    }

    /**
     * 按分类获取优惠券列表
     */
    public function getcatepartsall($cateid)
    {    
        return $this->field(true)->where(['cateid'=>$cateid])->order('id desc')->paginate(10,false,['query' => request()->param(), ]);
    }

   

    /**
     * 根据id获取一条信息
     * 
     * @param
     *            $id
     */
    public function getOneAd($pid)
    {
        return $this->where('id', $pid)->find();
    }

    /**
     * 搜索
     */
    public function search_list($keywords)
    {    
        return $this->field(true)->where(['title'=>['like','%'.$keywords.'%']])->order('id desc')->paginate(10);
    }
    


}

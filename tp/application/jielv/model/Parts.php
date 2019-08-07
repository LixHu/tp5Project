<?php
namespace app\jielv\model;

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
     * 新建优惠券
     */
    public function addparts($data)
    {
        return $this->allowField(true)->save($data);
    }

    /**
     * 编辑优惠券
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

    /**
     * 搜索
     */
    public function search_list($keywords)
    {    
        return $this->field(true)->where(['name'=>['like','%'.$keywords.'%']])->order('id desc')->paginate(10);
    }


}

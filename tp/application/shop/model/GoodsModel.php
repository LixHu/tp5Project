<?php
namespace app\shop\model;

use think\Model;

/**
 * 工单管理
 */
class GoodsModel extends Model
{

    protected $name = 'goods';

    /**
     * 获取产品列表
     */
    public function getgoods_list()
    {    
        return $this->field(true)->where('status',1)->order('id desc')->paginate(10);
    }

    /**
     * 获取热门产品
     */
    public function gethotgoods()
    {    
        return $this->field(true)->where(['status'=>1,'hot'=>2])->order('id desc')->paginate(10);
    }

    // /**
    //  * 按分类获取产品列表
    //  */
    // public function getcate_goods($cateid)
    // {    
    //     return $this->field(true)->where('cate_name',$cateid)->order('id desc')->paginate(10,false,['query' => request()->param(), ]);
    // }

    /**
     * 新建产品
     */
    public function ad_goods($data)
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

    /**
     * 搜索
     */
    public function search_list($keywords)
    {    
        return $this->field(true)->where(['name'=>['like','%'.$keywords.'%']])->order('id desc')->paginate(10);
    }





}

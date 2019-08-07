<?php
namespace app\jielv\model;

use think\Model;

class Services extends Model
{

    protected $name = 'cart_fee';
    

    /**
     * 获取车费列表
     */
    public function getserviceAll()
    {   
        $gid = json_decode(session('user')['gid']);//获取到当前操作用户的分类ID
        return $this->field(true)->order('id desc')->paginate(10);
    }

    /**
     * 编辑服务
     * 
     */
    public function editservice($param)
    {
        return $this->save($param, ['id' => $param['id']]);
    }


    /**
     * 根据id获取一条消息详情
     */
    public function getOne($id)
    {
        return $this->where('id',$id)->find();
    }
    /**
     * 新增
     */
    public function ad_cee($param)
    {
        return $this->allowField(true)->save($param);
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
    public function search_list($region_id)
    {    
        return $this->field(true)->where('region_id',$region_id)->order('id desc')->paginate(10,false,['query' => request()->param(), ]);
    }
}
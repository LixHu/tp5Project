<?php
namespace app\jielv\model;

use think\Model;

class DriverModel extends Model
{

    protected $name = 'driver';

  /**
   *	司机列表
   * 
   */
  
    public function getdriver_all(){
          return $this->field(true)->where('aud_status','<',3)->order('did desc')->paginate(10);
    }


      /**
   *  按分类查询司机列表
   * 
   */
  
    public function catedriver_all($cid){
          return $this->field(true)->where(['car_type'=>$cid,'aud_status'=>['<',3]])->order('did desc')->paginate(10,false,['query' => request()->param(), ]);
    }


    /**
     *  待审核司机
     * 
     */
  
    public function driver_aud(){
          return $this->field(true)->where('aud_status',3)->order('did desc')->paginate(10);
    }

    /**
     * 新增
     */
    public function ad_driver($data)
    {
        return $this->allowField(true)->save($data);
        
    }


    /**
     * 批量删除
     */
    
    public function del($param){
        return $this->destroy($param);
    }

    /**
     * 订单列表
     */
    
    public function getorderall($rid){
        $gid = json_decode(session('user')['gid']);//获取到当前操作用户的分类ID
        
        return $this->where(['gid'=>$gid,'status'=>$rid])->order('id desc')->paginate(10);
    }

    /**
     * 根据id获取一条信息
     * 
     * @param
     *            $id
     */
    public function getOneAd($id)
    {
        return $this->where('did', $id)->find();
    }

    /**
     * 搜索
     */
    public function search_list($keywords)
    {    
        return $this->field(true)->where(['rela_name|mobile'=>['like','%'.$keywords.'%']])->order('did desc')->paginate(10,false,['query' => request()->param(), ]);
    }
}
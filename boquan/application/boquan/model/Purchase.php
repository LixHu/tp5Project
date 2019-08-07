<?php
namespace app\boquan\model;

use think\Model;

class Purchase extends Model
{

    protected $name = 'purchase';

  /**
   *	出入库记录
   * 
   */
  
    public function getStatusData($param = []){
            
              $where = [];
              if (!empty($param)){
                  $where = $param;
              }
              $where['gid'] = json_decode(session('user')['gid']);//获取到当前操作用户的分类ID
              $where['status'] = 100;
              $list = self::where($where)->order('id desc')->select();
              return $list;
          
      }

    /**
     * 新增
     */
    public function adpurchase($purchase)
    {
        return $this->allowField(true)->save($purchase);
        
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
        return $this->where('id', $id)->find();
    }
}
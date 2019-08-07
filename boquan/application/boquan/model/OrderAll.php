<?php
namespace app\boquan\model;

use think\Model;

class OrderAll extends Model
{

    protected $name = 'order_list';

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
              
              $list = self::where($where)->order('id desc')->select();
              return $list;
          
      }
  
  /**
   * 新增记录
   */
   public function ad_order($data){
        $this->allowField(true)->save($data);
    }


    /**
     * 批量删除
     */
    
    public function del($param){
        return $this->destroy($param);
    }
    
}
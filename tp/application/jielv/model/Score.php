<?php
namespace app\jielv\model;

use think\Model;

/**
 * 评价标签
 */
class Score extends Model
{

    protected $name = 'appraise_score';
 
    /**
     * 标签列表
     */
    public function getscore_all()
    {   
        
        return $this->field(true)->order('id desc')->paginate(10);
    }

    /**
     * 新增标签
     */
    public function ad_score($param)
    {
        return $this->allowField(true)->save($param);
    }

    /**
     * 编辑服务
     * 
     */
    public function edit_appraise($param)
    {
        return $this->save($param, ['id' => $param['id']]);
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

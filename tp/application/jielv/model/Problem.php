<?php
namespace app\jielv\model;

use think\Model;

/**
 * 问题帮助管理
 */
class Problem extends Model
{

    protected $name = 'problem';

    /**
     * 获取问题帮助
     */
    public function getproblem_list()
    {    
        return $this->field(true)->order('id desc')->paginate(10);
    }



    /**
     * 新增问题帮助
     */
    public function ad_problem($param)
    {
        return $this->allowField(true)->save($param);
    }

    /**
     * 编辑问题帮助
     * 
     * @param
     *            $param
     */
    public function editproblem($param)
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
     * 批量删除问题帮助
     */
    
    public function del($param){
        return $this->destroy($param);
    }

    /**
     * 搜索问题帮助
     */
    public function search_list($keywords)
    {    
        return $this->field(true)->where(['title'=>['like','%'.$keywords.'%']])->order('id desc')->paginate(10);
    }





}

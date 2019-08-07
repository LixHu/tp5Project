<?php
namespace app\jielv\model;

use think\Model;

class AdMessage extends Model
{

    protected $name = 'message';

    /**
     * 获取列表消息
     */
    public function getMessageAll()
    {   
        $gid = json_decode(session('user')['gid']);//获取到当前操作用户的分类ID
        return $this->field(true)->where('gid',$gid)->order('id desc')->paginate(10);
    }

    /**
     * 根据id获取一条消息详情
     */
    public function getmessage($id)
    {
        return $this->where('id', $id)->find();
    }

    /**
     * 插入公告
     */
    public function addmessage($param)
    {
        return $this->allowField(true)->save($param);
    }

    

    /**
     * 审核用户(更新用户状态)
     */
    public function approveuser($id)
    {
        // 实例化审核用户表
        $user = db('user_group');
        if (! empty($id)) {
            return $user->save([
                'status' => 0
            ], [
                'id' => $id
            ]);
        }
    }

    /**
     * 驳回用户(更新用户状态)
     */
    public function rejectuser($id)
    {
        // 实例化审核用户表
        $user = db('user_group');
        if (! empty($id)) {
            return $user->save([
                'status' => 2
            ], [
                'id' => $id
            ]);
        }
    }

    /**
     * 获取新消息
     */
    public function getMessagecount()
    {
        
        // 查询状态为 1 的总条数
        return $this->field(true)->where('status', 1)->count();
    }
    /**
     * 批量删除
     */
    
    public function delmes($param){
        return $this->destroy($param);
    }


    /**
     * 编辑
     * 
     * @param
     *            $param
     */
    public function editmes($param)
    {
        return $this->allowField(true)->save($param, ['id'=>$param['id']]);
    }
}   
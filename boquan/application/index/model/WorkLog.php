<?php
namespace app\index\model;
use think\Model;
/**
 *  WorkLog
 */
class WorkLog extends Model
{
    /**
    * 指派工单写入工单日志
    * @param $str string 拼接好的字符串信息
    * @param $wo_id int 工单ID
    * @param $status int 装填
    */
    public function WriteLog($str = '',$wo_id = '',$status = 0)
    {
        $flag = false;
        if (!empty($str) && !empty($wo_id) && $status != 0)
        {
            $data['desc'] = $str;
            $data['wo_id'] = $wo_id;
            $data['status'] = $status;
            $data['add_time'] = time();
            if (self::save($data)){
                $flag = true;
            }
        }
        return $flag;
    }
    /**
     * 获取当前部门最近几条工单记录
     */
    public function getList($gid = '',$time = '')
    {
        if (!empty($gid)){
            $where = 'b.gid ='.$gid;
            if (!empty($time)){
                $date = explode(' - ',$time);
                $where .= ' and a.add_time between '.strtotime($date[0]).' and '.strtotime($date[1]);
            }
            $list = self::
                    alias('a')
                    ->field('a.add_time,a.desc,a.wo_id,a.status')
                    ->join('work_orders b','a.wo_id = b.wo_id')
                    ->where($where)->order('add_time desc')->select();
            return $list;
        }
    }
    /**
     * 获取工单的状态
     */
    public function getWorkList($wid)
    {
        $list = [];
        if (!empty($wid)){
            $list = self:: where('wo_id ='.$wid)->order('add_time desc')->select();
        }
        return $list;
    }
}

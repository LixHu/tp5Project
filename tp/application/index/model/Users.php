<?php
/**
 * 用户model
 */
namespace app\index\model;
use think\Model;
class Users extends Model
{
//    protected function setPasswordAttr($val){
//        return sysmd5($val);
//    }
    protected function getAddTimeAttr($val)
    {
        return date("Y-m-d H:i:s",$val);
    }
    protected function getHeaderImgAttr($val){
        if(!empty($val)){
            $value = config('server_url').$val;
        }else{
            $value =  config('server_url').'/static/user/default_head.png';
        }
        return $value;
    }
    /**
     * 获取用户优惠券列表
     */
    public function getCoupon($uid)
    {
        $list = self::alias('a')
            ->field('c.id,c.m_price,c.d_price,c.end_time,c.start_time,c.img,b.max_time')
            ->join('parts_user b','a.uid = b.uid')
            ->join('parts c','b.pid = c.id')
            ->where('a.uid ='.$uid.' and b.max_time >'.time())
            ->select();
        return $list;
    }
}
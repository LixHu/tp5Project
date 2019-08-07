<?php
/**
 * 用户
 */

namespace app\index\model;

use think\Model;
use think\Session;

class Users extends Model
{
    protected $insert = ['add_time'];
    protected function setAddTimeAttr(){
        return time();
    }

    /**
     * 注册
     * @param $data
     * @return array
     */
    public function reg($data){
        $data['password'] = sysmd5($_POST['password']);
        $data['rid'] = 2;
        $data['status'] = 1;
        $validate = validate('Users');
        $sms = new \sms\Sms();
        if(!self::where('mobile ='.$data['mobile'])->count()){
            if ($sms->checksms($data['verify'],$data['mobile'])){
                if ($data['password'] != sysmd5($data['password2'])){
                    $res = array('code' => 2,'msg' => '两次密码输入不一致');
                }else{
                    if ($validate->check($data)){
                        $ret = self::allowField(true)->save($data);
                        $res = array('code' => 1,'msg' => '注册成功');
                    }else{
                        $res = array('code' => 2,'msg' => $validate->getError());
                    }
                }
            }else{
                $res = array('code' => 2,'msg' => '验证码输入有误');
            }
        }else{
            $res = array('code' => 2,'msg' => '用户已经存在');
        }
        return $res;
    }
    /**
     * 获取用户常用服务商
     */
    public function getCommonUse($uid)
    {
        $list = [];
        $list = self::alias('a')
                ->join('common_use b','a.uid = b.uid')
                ->join('user_group c','b.gid = c.gid')
                ->where('a.uid ='.$uid)
                ->select();
        return $list;
    }
    /**
     * 获取用户车辆信息
     */
    public function getCarInfo($uid)
    {
        $info = self::alias('a')
                    ->join('user_car b','a.uid = b.uid')
                    ->where('a.uid ='.$uid)
                    ->find();
        return $info;
    }
    /**
     * 获取跳转地址
     */
    public function getUrl($uid){
        $url = '';
        $mid = self::alias('a')
                ->join('role b','a.rid = b.rid')
                ->where('a.uid ='.$uid)
                ->find();
        if ($mid['rid'] == 2){
            $url = url('user/mainuser');
        }else{
            $menu = model('Menu','model');
            $mlist = $menu->where('mid in ('.$mid['mid'].')')->select();
            foreach($mlist as $key => $val){
                $mlist[$key] = $val->toArray();
            }
            foreach($mlist as $key => $val){
                if($val['method'] == 'manage'){
                    $url = url('user/mainmanagement');
                }else if($val['method'] == 'work'){
                    $url = url('user/mainrepair');
                }
            }
        }
        Session('user_url',$url);
        return $url;
    }
    /**
     * 获取用户组ID
     */
    public function getGroup($uid)
    {
        $group = self::alias('a')
                ->join('role b','a.rid = b.rid')
                ->where('uid ='.$uid)
                ->find();
        $gid = $group->gid;
        return $gid;
    }
    /**
     * 获取已接受但未完成的工单
     */

}
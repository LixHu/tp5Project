<?php
/**
 * 短信验证码
 */
namespace app\index\controller;
use think\Loader;
class SendMes extends Index
{
    public function send_sms()
    {
        if($_POST){
            $flag = true;
            $msg = '';
            if (!empty($_POST['method']) && !empty($_POST['mobile'])){
                $user = model('Users','model');
                $info = $user->where('mobile ='.$_POST['mobile'])->find();
                if (!empty($info)){
                    $msg = '手机号已经存在';
                    $flag = false;
                }
                switch ($_POST['method']){
                    case 'edit':
                        $mobile = $user->get(Session('driver')->uid);
                        if($_POST['mobile'] == $mobile['mobile']){
                            $msg = '手机号不能修改为当前的手机号';
                            $flag = false;
                        }
                        break;
                    case 'reg':

                        break;
                }
            }
            if ($flag){
                $sms = new \sms\Sms('C35588802','424b2e67fc7049c7bc6a99fd90aeced1');
                $res = $sms->send_sms($_POST['mobile']);
            }else{
                $res['code'] = 2;
                $res['msg'] = $msg;
            }
            return $res;
        }
    }
}

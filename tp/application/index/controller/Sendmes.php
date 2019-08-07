<?php
/**
 * 短信验证码
 */
namespace app\index\controller;
class SendMes extends Index
{
    /**
     * 发送短信验证码
     */
    public function send_sms()
    {
        $arr = $this->arr;
        if(!empty($arr)){
            $flag = true;
            $msg = '';
            if ($flag){
                $sms = new \sms\Sms('C35588802','424b2e67fc7049c7bc6a99fd90aeced1');
                $res = $sms->send_sms($arr['mobile']);
            }else{
                $res['code'] = 1002;
                $res['msg'] = $msg;
            }
            return json($res);
        }
    }
}

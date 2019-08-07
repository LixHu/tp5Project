<?php
namespace app\index\controller;
class Sms extends Index
{
    public function sendsms()
    {
        $pt = file_get_contents('php://input');
        $arr = json_decode($pt,true);
        if(!empty($arr)){
            if(!empty($arr['mobile'])){
                $mobile = $arr['mobile'];
                vendor('Aliyun.api_demo.SmsDemo');
                if(preg_match('/^1[34578]\d{9}$/',$mobile)){
                    Session([
                        'expire'=> 300,
                    ]);
                    Session($mobile,rand(1000,9999));
                    $qm = config('sms')['qm'];
                    $template = config('sms')['template'];
                    $a = new \SmsDemo();
                    set_time_limit(time());
                    $code = array('code' => Session($mobile) , 'product' => 'dsd');
                    $response = $a->sendSms($qm,$template,$mobile,$code);
                    if($response){
                        $res = array('code' => '1','msg' => '发送成功');
                    }else{
                        $res = array('code' => '2','msg' => '失败');
                    }
                }else{
                    $res = array('code' => '2','msg' => '手机号码格式不正确');
                }
            }else{
                $res = array('code' => '2','msg' => '手机号码格式不正确');
            }
        }else{
            $res = array('code' => '2','msg' => '填写手机号');
        }
        return json_encode($res);
    }
}

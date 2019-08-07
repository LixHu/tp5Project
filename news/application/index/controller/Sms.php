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
                $msg = '失败';
                $flag = true;
                if(preg_match('/^1[34578]\d{9}$/',$mobile)){
                    $user_info = db('users')->where('mobile = '.$mobile)->find();
                    if(empty($user_info)){
                        $flag = true;
                        if (!empty(Session('send_param'.$mobile))) {
                            $time = strtotime('+1 minute',Session('send_param'.$mobile)['send_time']);
                            if ($time > time()) {
                                $flag = false;
                            }
                        }
                        if ($flag) {
                            $send = array('code' => rand(1000,9999),'send_time' => time());
                            Session('send_param'.$mobile,$send);
                            $post_data = "account=C35588802&password=424b2e67fc7049c7bc6a99fd90aeced1&mobile=".$mobile."&content=".rawurlencode("您的验证码是：".$send['code']."。请不要把验证码泄露给其他人。");
                            $target = "http://106.ihuyi.cn/webservice/sms.php?method=Submit";
                            $gets =  $this->xml_to_array($this->Post($post_data, $target));
                            if($gets['SubmitResult']['code'] == 2) {
                                $send1 = true;
                                Session('c'.$mobile,$send['code']);
                            }else{
                                $send1 = false;
                                $msg = $gets['SubmitResult']['msg'];
                            }
                        }else {
                            $send1 = false;
                            $msg = '发送失败(请等待一分钟之后再发送)';
                        }
                    }else{
                        $send1 = false;
                        $msg = '当前手机号已经存在';
                    }
                    // Session([
                    //     'expire'=> 300,
                    // ]);
                    if($send1){
                        $res = array('code' => '1','msg' => '发送成功');
                    }else{
                        $res = array('code' => '2','msg' => $msg);
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

     private function Post($curlPost,$url){
    		$curl = curl_init();
    		curl_setopt($curl, CURLOPT_URL, $url);
    		curl_setopt($curl, CURLOPT_HEADER, false);
    		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    		curl_setopt($curl, CURLOPT_NOBODY, true);
    		curl_setopt($curl, CURLOPT_POST, true);
    		curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
    		$return_str = curl_exec($curl);
    		curl_close($curl);
    		return $return_str;
    }
    //将 xml数据转换为数组格式。
    private function xml_to_array($xml){
    	$reg = "/<(\w+)[^>]*>([\\x00-\\xFF]*)<\\/\\1>/";
    	if(preg_match_all($reg, $xml, $matches)){
    		$count = count($matches[0]);
    		for($i = 0; $i < $count; $i++){
    		$subxml= $matches[2][$i];
    		$key = $matches[1][$i];
    			if(preg_match( $reg, $subxml )){
    				$arr[$key] = $this->xml_to_array( $subxml );
    			}else{
    				$arr[$key] = $subxml;
    			}
    		}
    	}
    	return $arr;
    }
}

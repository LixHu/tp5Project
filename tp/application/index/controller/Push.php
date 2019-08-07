<?php
/**
 * 推送
 */

namespace app\index\controller;


class Push extends Index
{
    /**
     * 极光
     */
    public function easypush()
    {
        $system_data = [
            'id'=>1,
            'title'=>'test',
            'contents'=>'dashduashdioasdjioadasda'
        ];
        $account = model('Account');
        $pushkey = $account->getAccount('pushdriver');
        $app_key = $pushkey['account'];
        $master_secret = $pushkey['secret'];
        import('push.api.Push');
        $push = new \Push($app_key,$master_secret);
        $an = [
//	        "alert" => "Hi, an!",
//            "title" =>  "Send to Android",
//            "builder_id"  =>1,
//            "extras"=> [
//	            "newsid" => 321
//            ]
        ];
        $ios = [
//	        "alert" =>  "Hi, ios!",
////            "sound" => "default",
//            "badge" =>  "+1",
//            "extras"=> [
//	            "newsid" => 321
//            ]
        ];
//        $res = $push->alert('hello world');
        $res = $push->regalerts('八号技师踩背 五号技师按脚 ,安踏鞋脱了。',['13165ffa4e033d7fb67'],$an,$ios);
//        try{
//            $res = $client->push()
//                ->setPlatform('all')
//                ->addAllAudience()
//                ->setNotificationAlert('Hello, JPush')
//                ->send();
//        }catch (\JPush\Exceptions\JPushException $e){
//            dump($e);
//        };
        return json($res);
    }
//    /**
//     * 融云
//     */
//    public function rongcloud()
//    {
//        $app_key = '8luwapkv8raql';
//        $secret = 'jQTea4aqARlOr';
//        $param = array(
//            "fromUserId" =>  "1",
//            "toUserId"   =>  "2",
//            "objectName" => "RC:TxtMsg",
//            "content"    => 'hello world',
//            "pushContent"=> 'hello world'
//        );
//        import('request.SendRequest');
//        $send = new \SendRequest($app_key,$secret);
//        $data = $send->curl('/message/private/publish.json',$param);
//        dump($data);
//    }
}
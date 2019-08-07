<?php
namespace app\index\controller;

use think\Loader;
class Pay extends Index
{
    /*
    *  统一下单
    */
    public function alipay(){
        Loader::import('Alipay.aop.AopClient', EXTEND_PATH);
        Loader::import('Alipay.aop.request.AlipayTradeAppPayRequest', EXTEND_PATH);
        $aop = new \AopClient;
        $pt = file_get_contents("php://input");
        $arr = json_decode($pt,true);
        if(!empty($arr)){
            $flag = true;
            if(empty($arr['order_id'])){
                $flag = false;
            }
            if($flag){
                $order_id = $arr['order_id'];
                $order_info = db('order')
                                ->where('order_id ='.$order_id)
                                ->find();
                $order_goods = db('order_goods')
                                ->alias('a')
                                ->join('goods b','a.goods_id = b.goods_id')
                                ->where('order_id ='.$order_id)
                                ->select();
                $str = '';
                if(!empty($order_info)) {
                    foreach($order_goods as $key => $val){
                        $str .= $val['goods_name'].'-';
                    }
                    $content = array();
                    $content['subject'] = '生鲜'.$str;                                                     //商品的标题/交易标题/订单标题/订单关键字等
                    // $content['out_trade_no'] = $order_info['order_sn'];                                    //商户网站唯一订单号
                    $content['out_trade_no'] = '4';
                    // $content['total_amount'] = "\"".sprintf('%.2f',$order_info['total_price'])."\"" ;                                 //订单总金额(必须定义成浮点型)
                    $content['total_amount'] = "\"".sprintf('%.2f',$order_info['total_price'])."\"";
                    $content['product_code'] = 'QUICK_MSECURITY_PAY';                                       //销售产品码，商家和支付宝签约的产品码，为固定值QUICK_MSECURITY_PAY
                    $content['timeout_express'] = '1d';
                    $con = json_encode($content);                                                           //$content是biz_content的值,将之转化成字符串
                    $param = array();
                    $Client = new \AopClient();                                                             //实例化支付宝sdk里面的AopClient类,下单时需要的操作,都在这个类里面
                    $param['app_id'] = '2017111209883335';                                                  //支付宝分配给开发者的应用ID
                    $param['method'] = 'alipay.trade.app.pay';                                              //接口名称
                    $param['charset'] = 'utf-8';                                                            //请求使用的编码格式
                    $param['sign_type'] = 'RSA2';                                                           //商户生成签名字符串所使用的签名算法类型
                    $param['timestamp'] = date('Y-m-d H:i:s');                                              //发送请求的时间
                    $param['version'] = '1.0';                                                              //调用的接口版本，固定为：1.0
                    $param['notify_url'] = 'http://shengxian.181.021mc.net/index/pay/alipay_res/';          //支付宝服务器主动通知地址
                    $param['biz_content'] = $con;                                                  //业务请求参数的集合,长度不限,json格式
                    $paramStr = $Client->getSignContent($param);
                    $sign = $Client->alonersaSign($paramStr,config('alipay_config')['rsaPrivateKey'],'RSA2');
                    $param['sign'] = $sign;
                    $str = $Client->getSignContentUrlencode($param);
                    $res = $str;
                    return $res;
                }else{
                    $res = array('code' => 2, 'msg' => '订单不存在');
                    return json_encode($res);
                }
            }
        }
    }
    /*
    * 交易回调
    */
    public function alipay_res(){
        $tdata['test'] = json_encode($_POST);
        db('test')->insert($data);
        if(!empty($_POST)){
            if($_POST['trade_status'] == 'TRADE_SUCCESS'){
                $info = db('order')->where('order_sn = '.$_POST['out_trade_no'])->find();
                $data['pay_status'] = 2;
                $data['pay_name'] = '支付宝支付';
                $data['pay_type'] = 3;
                $data['trade_no'] = $_POST['trade_no'];
                db('order')->where('order_id ='.$info['order_id'])->update($data);
            }
        }
    }
    /*
    * 查询
    */
    public function select()
    {
        Loader::import('Alipay.aop.AopClient', EXTEND_PATH);
        Loader::import('Alipay.aop.request.AlipayTradeQueryRequest', EXTEND_PATH);
        $aop = new \AopClient ();
        $aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
        $aop->appId = '2017111209883335';
        $aop->rsaPrivateKey = config('alipay_config')['rsaPrivateKey'];
        $aop->alipayrsaPublicKey='MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAjXYgagjX03BaeMIRI27Bei7UryPV+0fYGQFbX2MZhg3Mql5YSXTZhkuf+G2UIxiJxJAJon+g3BMjdBa8zkhoA7dYOQuQcUKEb7A9pl9EyqtQiPxTNGC6VjaKLpPMsKiepKgp5o/3jv8++trwu0rXqWQDLGSpE5R8qYdsFqVqm5NBFcBlmkzagAxJqH8lzwNVrtxZtbnOa+B2yA6eAMQSEDQilRbMMyA+K/539hBAhLam1RPXRrE7xBuz+h2qdbhDcmToPFCXZdvbOQpCOP4nsz5skd7oTrEKmvUdnhois6ogfFrMwAKnum0CT2LzR0Kds8ya3v8lqgbrlHrlUpZxNwIDAQAB';
        $aop->apiVersion = '1.0';
        $aop->signType = 'RSA2';
        $aop->postCharset='utf-8';
        $aop->format='json';
        $request = new \AlipayTradeQueryRequest ();
        $request->setBizContent("{" .
        "\"out_trade_no\":\"3\"," .
        "\"trade_no\":\"2017111421001104950575663843\"" .
        "}");
        $result = $aop->execute ($request);

        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
        $resultCode = $result->$responseNode->code;
        dump($result);
        if(!empty($resultCode)&&$resultCode == 10000){
            echo "成功";
        } else {
            echo "失败";
        }
    }
    /*
    * 退款
    */
    public function refund(){
        Loader::import('Alipay.aop.AopClient', EXTEND_PATH);
        Loader::import('Alipay.aop.request.AlipayTradeRefundRequest', EXTEND_PATH);
        $pt = file_get_contents('php://input');
        $arr = json_decode($pt,true);
        if(!empty($arr)){
            $flag = true;
            if(empty($arr['order_id'])){
                $flag = false;
            }
            if($flag){
                $order_id = $arr['order_id'];
                $price = '';
                if (!empty($arr['price'])) {
                    $price = $arr['price'];
                }
                $order_info = db('order')->where('order_id ='.$order_id)->find();
                $aop = new \AopClient ();
                $aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
                $aop->appId = '2017111209883335';
                $aop->rsaPrivateKey = config('alipay_config')['rsaPrivateKey'];
                $aop->alipayrsaPublicKey = 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAjXYgagjX03BaeMIRI27Bei7UryPV+0fYGQFbX2MZhg3Mql5YSXTZhkuf+G2UIxiJxJAJon+g3BMjdBa8zkhoA7dYOQuQcUKEb7A9pl9EyqtQiPxTNGC6VjaKLpPMsKiepKgp5o/3jv8++trwu0rXqWQDLGSpE5R8qYdsFqVqm5NBFcBlmkzagAxJqH8lzwNVrtxZtbnOa+B2yA6eAMQSEDQilRbMMyA+K/539hBAhLam1RPXRrE7xBuz+h2qdbhDcmToPFCXZdvbOQpCOP4nsz5skd7oTrEKmvUdnhois6ogfFrMwAKnum0CT2LzR0Kds8ya3v8lqgbrlHrlUpZxNwIDAQAB';
                $aop->apiVersion = '1.0';
                $aop->signType = 'RSA2';
                $aop->postCharset='utf-8';
                $aop->format='json';
                $request = new \AlipayTradeRefundRequest();
                // "\"out_request_no\":\"HZ01RF001\"," .                        #退款编号 如有订单多次退款，必传
                // "\"operator_id\":\"OP001\"," .
                // "\"store_id\":\"NJ_S_001\"," .
                // "\"terminal_id\":\"NJ_T_001\"" .
                $request->setBizContent("{" .
                "\"out_trade_no\":\"".$order_info['order_sn']."\"," .                                #商户订单编号
                // "\"trade_no\":\"".$order_info['trade_no']."\"," .                                 #支付宝交易编号
                "\"refund_amount\":".!empty($price)?$price:$info['total_price']."," .                #退款金额
                "\"refund_reason\":\"申请退款\"," .                                                   # 退款描述
                "  }");
                $result = $aop->execute ($request);
                $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
                $resultCode = $result->$responseNode->code;
                if(!empty($resultCode)&&$resultCode == 10000){
                    $data['order_status'] = 9;
                    $ret = db('order')->where('order_id ='.$order_id)->update($data);
                    if ($res) {
                        $res = array('code' => 1, 'msg' => '退款成功');
                    } else{
                        $res = array('code' => 2, 'msg' => '失败');
                    }
                } else {
                    $res = array('code' => 2, 'msg' => '退款失败');
                }
            }else{
                    $res = array('code' => 2,'msg'=>'缺少参数' );
            }
            return json_encode($res);
        }
    }
    public function wx_pay(){
        Loader::import('WechatPay',EXTEND_PATH);
        $wxpay = new \WechatPay();
        $body = '13213';
        $out_trade_no = '45143';
        $total_fee = '0.01';
        $res = $wxpay->getPrePayOrder($body,$out_trade_no,$total_fee);
        return $res;
    }
    public function cod(){
        $pt = file_get_contents("php://input");
        $arr = json_decode($pt,true);
        if(!empty($arr)){
            $flag = true;
            if(empty($arr['user_id']) && empty($arr['order_id'])){
                $flag = false;
            }
            if($flag){
                $user_id = $arr['user_id'];
                $order_id = $arr['order_id'];
                $data['order_status'] = 2;
                $data['pay_type'] = 1;
                $ret = db('order')->where('user_id = '.$user_id .' and order_id = '.$order_id)->update($data);
                if($ret){
                    $res = array('code' => 1,'msg' => '提交成功' );
                }else{
                    $res = array('code' => 2,'msg' => '失败' );
                }
            }else{
                $res = array('code' => 2,'msg' => '缺少参数' );
            }
            return json_encode($res);
        }
    }

}

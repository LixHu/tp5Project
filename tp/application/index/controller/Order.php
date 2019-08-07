<?php
/**
 * 订单
 */

namespace app\index\controller;
use think\Session;
use think\Validate;

class Order extends Index
{
    protected $batchValidate = true;
    /**
     * 计算价格
     * @return Json
     */
    public function comprice()
    {
        $res = array('code' => 1001,'msg' => '缺少参数');
        $arr = $this->arr;
        if(!empty($arr)){
            if(!empty($arr['start_lat']) && !empty($arr['start_lng']) && !empty($arr['end_lat']) && !empty($arr['end_lng'])){
                $km_num = 0;
                $url = "http://restapi.amap.com/v3/distance?key=3d08506940a7af172d508baa54ce2642&type=1&origins=".$arr['start_lng'].",".$arr['start_lat']."&destination=".$arr['end_lng'].",".$arr['end_lat']."";
                $info = file_get_contents($url);
                $km = json_decode($info,true);
                if($km['status'] == 1){
                    $km_num = $km['results'][0]['distance']/1000;
                }
                $crr['start_lat'] = $arr['start_lat'];
                $crr['start_lng'] = $arr['start_lng'];
                $crr['end_lat'] = $arr['end_lat'];
                $crr['end_lng'] = $arr['end_lng'];
                $crr['km_num'] = sprintf('%.2f',$km_num);
                Session('latlng',$crr);
                $carfee = model('CartFee','model');
                $info = $carfee->where("region_id = 321 and cart_type = {$arr['car_type']}")->order('cart_cate asc')->limit(0,2)->select();
                foreach ($info as $key => $val){
                    if($km_num < 3){
                        $brr[$val['cart_cate']] = $val['base_fare'];
                    }else{
                        $brr[$val['cart_cate']] = sprintf("%.2f",$km_num * $val['km_fee'] + $val['base_fare']);
                    }
                }
//                if($arr['car_type'] == 1){
//                    $brr['common'] = sprintf("%.2f",$km_num * 3 + 10);
//                    $brr['cosy'] = sprintf("%.2f",$km_num * 3.5 + 20);
//                }else if($arr['car_type'] == 2){
//                    $brr['common']  = sprintf("%.2f",$km_num * 3.5 + 15);
//                    $brr['cosyd'] = sprintf("%.2f",$km_num * 4 + 15);
//                    $brr['sixseat'] = sprintf("%.2f",$km_num * 4.5 + 25);
//                }else{
//                    $brr['common'] = sprintf("%.2f",$km_num * 4 + 20);
//                    $brr['cosyd']  = sprintf("%.2f",$km_num * 4.5 + 20);
//                    $brr['sixseat'] = sprintf("%.2f",$km_num * 5 + 25);
//                }
                $brr['km_num'] = sprintf('%.2f',$km_num);
                $res = array('code' => 1000,'price' => $brr ,'crr' => $crr);
            }else{
                $res = array('code' => 1002,'msg' => '缺少经纬度');
            }
////            Session('order',$arr);
////            $validate = validate('Orders');
////            if($validate->check($arr)){
////                $order = model('Orders','model');
////                if($order->allowField(true)->save($arr)){
////                    $res = array('code' => 1000,'msg' => '添加成功');
////                }
////            }else{
////                $res = array('code' => 1002,'msg' => $validate->getError());
////            }
        }
        $res['input'] = $arr;
        return json($res);
    }
    /**
     * 提交订单
     */
    public function suborder()
    {
        $arr = $this->arr;
        $res = array('code' => 1001 ,'msg' => '缺少参数');
        if (!empty($arr)){
            $validate = validate('Orders');
            $arr['start_lat'] = Session('latlng')['start_lat'];
            $arr['start_lng'] = Session('latlng')['start_lng'];
            $arr['end_lat'] = Session('latlng')['end_lat'];
            $arr['end_lng'] = Session('latlng')['end_lng'];
            $arr['km_num'] = Session('latlng')['km_num'];
            $arr['add_time'] = time();
            $arr['status'] = 1;     // 订单状态设为刚开始
            $arr['osn'] = date('ymdhis').rand(10,99).rand(10,99);   // 随机生成一个订单编号
            if($validate->check($arr)){
                $order = model('Orders','model');
                $have = $order->where('status < 7 and uid ='.$arr['uid'])->find();
                if(empty($have)){
                    $user = model('Users','model');
                    $uinfo = $user->get($arr['uid']);
                    if(!empty($uinfo)){
                        if($order->allowField(true)->save($arr)){
                            $res = array('code' => 1000,'msg' => '提交成功' ,'oinfo' => $order->get($order->getLastInsID()));
                        }
                    }else{
                        $res = array('code' => 1004,'msg' => '用户不存在');
                    }
                }else{
                    $res = array('code' => 1003,'msg' => '您有未完成的订单，请处理后再下单');
                }
            }else{
                $res = array('code' => 1002 ,'msg' => $validate->getError());
            }
        }
        return json($res);
    }
    public function suborder2()
    {
        $arr = $this->arr;
        $res = array('code' => 1001 ,'msg' => '缺少参数');
        if (!empty($arr)){
            $validate = validate('Orders');
//            $arr['start_lat'] = Session('latlng')['start_lat'];
//            $arr['start_lng'] = Session('latlng')['start_lng'];
//            $arr['end_lat'] = Session('latlng')['end_lat'];
//            $arr['end_lng'] = Session('latlng')['end_lng'];
//            $arr['km_num'] = Session('latlng')['km_num'];
            $arr['add_time'] = time();
            $arr['status'] = 1;     // 订单状态设为刚开始
            $arr['osn'] = date('ymdhis').rand(10,99).rand(10,99);   // 随机生成一个订单编号
            if($validate->check($arr)){
                $order = model('Orders','model');
                $have = $order->where('status < 7 and uid ='.$arr['uid'])->find();
                if(empty($have)){
                    $user = model('Users','model');
                    $uinfo = $user->get($arr['uid']);
                    if(!empty($uinfo)){
                        if(!empty($arr['make_time'])){
                            $arr['make_time'] = strtotime($arr['make_time']);
                        }
                        if($order->allowField(true)->save($arr)){
                            $res = array('code' => 1000,'msg' => '提交成功' ,'oinfo' => $order->get($order->getLastInsID()));
                        }
                    }else{
                        $res = array('code' => 1004,'msg' => '用户不存在');
                    }
                }else{
                    $res = array('code' => 1003,'msg' => '您有未完成的订单，请处理后再下单');
                }
            }else{
                $res = array('code' => 1002 ,'msg' => $validate->getError());
            }
        }
        return json($res);
    }
    /**
     * 司机听单
     */
    public function allorder()
    {
        $arr = $this->arr;
        $res = array('code' => 1001 ,'msg' => '缺少参数');
        if(!empty($arr)){

            if(!empty($arr['did'])){
                $did = $arr['did'];
                $driver = model('Driver','model');
                $dinfo = $driver->get($did);
                if(!empty($dinfo)){
                    if($dinfo->aud_status == 1){     // 审核通过
                        $latlng['lat'] = $arr['lat'];
                        $latlng['lng'] = $arr['lng'];
                        Session('jwd',$latlng);
                        $order = model('Orders','model');
                        $where['car_id'] = $dinfo->car_id;
                        $where['car_type'] = $dinfo->car_type;
                        $where['a.status'] = ['<=',5];
                        if(!empty($arr['make_type'])){
                            if($arr['make_type'] != 3){
                                $where['a.make_type'] = $arr['make_type'];
                            }
                        }
                        // 如果司机有订单，返回司机当前的订单，否则则返回新订单
                        if(!empty($arr['km'])){
                            $km = $arr['km'];
                        }else{
                            $km = 5;
                        }
                        $oidh = $this->redis->get('have');
                        if(!empty($oidh)){
//                            $where['oid'] = ['notin',$this->redis->get('have')];
                        }
                        $auto = false;
                        if(!empty($arr['auto'])){
                            $auto = $arr['auto'];
                        }
//                        $list = [];
                        $list = $order->getOrderList($where,$did,$km,$arr['lat'],$arr['lng'],$auto);
                        if(!empty($list)){
//                            if($list[0]['status'] == 1){
//                                $this->redis->get('have');
//                                $have = $list[0]['oid'];
//                                $this->redis->set('have',$have);
//                            }
                            foreach ($list as $key => $val){
                                $list[$key]['header_img'] = config('server_url').$val['header_img'];
                            }
                            if($list[0]['status'] >= 4 && $list[0]['status'] <= 5){
                                // 如果司机点击顾客上车，获取司机位置信息 存到list中 ，直到行程结束
                                $list2 = $this->redis->lrange('dlatlng'.$list[0]['oid'],0,$this->redis->llen('dlatlng'.$list[0]['oid']));
                                if(empty($list2)){
                                    //如果第一次计算距离 拿当前订单的起始位置和接收到的位置进行计算
                                    $latarr['km_num'] = sprintf('%.2f',calcDistance($list[0]['start_lat'],$list[0]['start_lng'],$arr['lat'],$arr['lng']));
                                }else{
                                    // 如果不为空，拿到前一条数据的位置和接收到的位置进行计算+前一条数据的千米数
                                    $last = json_decode($list2[count($list2)-1],true);
                                    $latarr['km_num'] = sprintf('%.2f', $last['km_num']+calcDistance($last['lat'],$last['lng'],$arr['lat'],$arr['lng']));
                                }
                                $latarr['lat'] = $arr['lat'];
                                $latarr['lng'] = $arr['lng'];
//                                $latarr['oid'] = $list[0]['oid'];
//                                $latarr['km_num'] = $latarr['km_num']+$list2[count($list2)-1]['km_num']?$list2[count($list2)-1]['km_num']:0;
                                $this->redis->del('dlatlng');
                                $this->redis->rpush('dlatlng'.$list[0]['oid'],json_encode($latarr));
                            }
                        }
                        // 记录在线时间
                        $onlinet = $this->redis->get('onlinet'.$did);
	                    if($onlinet == 3){
		                    $this->redis->set('onlined'.$did,(string)strtotime(date('Y-m-d',strtotime('+1 day',time()))));
	                    }
                        $this->redis->set('onlinet'.$did,$onlinet + 3);
                        // $this->redis->del('onlinet'.$did);
                        $stime = strtotime(date('Y-m-d',time()));
                        $etime = strtotime(date('Y-m-d',strtotime('+1 day',time())));
                        $ocount = $order->where('did ='.$did.' and status > 5 and status != 101 and handle_time between '.$stime.' and '.$etime)->count();
                        // echo $order->getLastSql();
                        $grade = model('Grade','model');
                        $linfo = $grade->where('and_sorce <'.$dinfo->integer.' and end_sorce >'.$dinfo->integer)->find();    // 
                        // dump($linfo);
                        $res = array(
                            'code' => 1000,
                            'data' => $list ,
                            'online' => $this->redis->get('onlinet'.$did),
                            'ocount' => (string)$ocount,
                            'jf'   => (string)$dinfo->integer,
                            'glod'  => (string)$dinfo->glod,
                            'level'  => (string)$linfo->grade_name
                        );
                        if(!empty($arr['not'])){
                            $not = $arr['not'];
                        }else{
                            $not = 2;
                        }
                        if($not == 1){
                            $res['data'] = [];
                        }
//                        else{
//                            $res = array('code' => 1002 ,'msg' => '暂无数据');
//                        }
                    }else{
                        $res = array('code' => 1003 ,'msg' => '审核未通过或者拒绝');
                    }
                }else{
                    $res = array('code' => 1004 ,'msg' => '用户不存在');
                }
            }
        }
        return json($res);
    }
    /**
     * 司机抢单
     */
    public function driverorder()
    {
        $arr = $this->arr;
        $res = array('code' => 1001 ,'msg' => '缺少参数');
        if(!empty($arr)){
            if(!empty($arr['oid']) && !empty($arr['did'])){
                $where['oid'] = $arr['oid'];
                $data['did'] = $arr['did'];
                $data['status'] = 2;     // 把状态改为已接单
                $data['single_time'] = time();
                $order = model('Orders','model');
                $user = model('Users','model');
                $info = $order->get($where['oid']);
                if(!empty($info)){
                	if($info->status != 101){
		                if($info->did == 0){
			                if($order->save($data,$where)){
				                $system_data = [
					                'id'=>1,
					                'title'=>'test',
					                'contents'=>'dashduashdioasdjioadasda'
				                ];
				                $push_data = [
					                'title'=>'dasdadsa',
					                'extras'=>[
						                'type'=>'system',
						                'status'=>'0',
						                'data'=>$system_data
					                ]
				                ];
				                if(!empty($user->get($info->uid)->registrationid)){
					                $this->push->regalerts('您的订单已经被接走，请耐心等待司机到达。',$user->get($info->uid)->registrationid,$push_data,$push_data);
				                }
				                $res = array('code' => 1000 ,'msg' => '接单成功' ,'status' => $data['status']);
			                }
		                }else{
			                $res = array('code' => 1003 ,'msg' => '此订单正在处理');
		                }
	                }else{
		                $res = array('code' => 1005 ,'msg' => '此订单已经取消');
	                }
                }else{
                    $res = array('code' => 1004 ,'msg' => '订单不存在');
                }
            }
        }
        return json($res);
    }
    /**
     * 乘客上车
     */
    public function oncar(){
        $arr = $this->arr;
        $res = array('code' => 1001 ,'msg' => '缺少参数');
        if(!empty($arr)){
            if(!empty($arr['oid']) && !empty($arr['did'])){
                $where['oid'] = $arr['oid'];
                $data['status'] = 4;
                $data['oncar_time'] = time();
                $order = model('Orders','model');
                if($order->save($data,$where)){
                    $res = array('code' => 1000 ,'msg' => '上车成功' ,'status' => $data['status']);
                }
            }
        }
        return json($res);
    }
    /**
     * 行程结束
     */
    public function endtrip(){
        $arr = $this->arr;
        $res = array('code' => 1001 ,'msg' => '缺少参数');
        if(!empty($arr)){
            if(!empty($arr['oid']) && !empty($arr['did'])){
                $where['oid'] = $arr['oid'];
                $data['status'] = 5;
                $data['oncar_time'] = time();
                $order = model('Orders','model');
                $position = $this->redis->lrange('dlatlng'.$arr['oid'],0,$this->redis->llen('dlatlng'.$arr['oid']));
                $data['driver_trip'] = json_encode($position);
                $this->redis->del('dlatlng'.$arr['oid']);
                if($order->allowField(true)->save($data,$where)){
                    $res = array('code' => 1000 ,'msg' => '行程结束' ,'status' => $data['status']);
                }
            }
        }
        return json($res);
    }
    /**
     * 发送车费
     */
    public function sendprice()
    {
        $arr = $this->arr;
        $res = array('code' => 1001 ,'msg' => '缺少参数');
        if(!empty($arr)){
            if(!empty($arr['oid']) && !empty($arr['did']) && !empty($arr['total_price'])){
                $order = model('Orders','model');
                $oinfo = $order->get($arr['oid']);
                if($oinfo->status <= 7){
                    $where['oid'] = $arr['oid'];
                    $data['status'] = 6;
                    $data['total_price'] = $arr['total_price'];
                    if($order->save($data,$where)){
                        $res = array('code' => 1000,'msg' => '发送成功' ,'status' => $data['status']);
                    }else{
                        $res = array('code' => 1002,'msg' => '已经发送');
                    }
                }else{
                    $res = array('code' => 1003 ,'msg' => '乘客已经付款，请勿重新发送');
                }
            }
        }
        return json($res);
    }
    /**
     * 用户查看实时订单
     */
    public function orderinfo()
    {
        $arr = $this->arr;
        $res = array('code' => 1001 ,'msg' => '缺少参数');
        if(!empty($arr)){
            if(!empty($arr['uid']) && !empty($arr['oid'])){
                $order = model('Orders','model');
                $info = $order->getOrderInfo($arr);
                $list = $this->redis->lrange('dlatlng'.$arr['oid'],0,$this->redis->llen('dlatlng'.$arr['oid']));
                if(!empty($list)){
                    foreach ($list as $key => $val){
                        $list[$key] = json_decode($val,true);
                    }
//                    $url = "http://restapi.amap.com/v3/distance?key=3d08506940a7af172d508baa54ce2642&origins={$list[0]['lat']},{$list[0]['lng']}&destination={$list[count($list)-1]['lat']},{$list[count($list)-1]['lng']}";
//                    $reault = file_get_contents($url);
//                    $kmarr = json_decode($reault,true);
//                     $km_num = $kmarr['results'][0]['distance']/1000;
                    if(!empty($info['data'])){
                        $dinfo = $info['data']->toarray();
                        $carfee = model('CartFee')
                            ->where('cart_type ='.$dinfo['car_id'].' and cart_cate = '.$dinfo['car_type'])->find();
                        $info['data']->price = $list[count($list)-1]['km_num'] * $carfee['km_fee_s'] + $carfee['base_fare'];
                    }
                }
                $res = $info;
            }
        }
        return json($res);
    }
    /**
     * 查询用户未完成订单
     */
    public function usernorder()
    {
        $arr = $this->arr;
        $res = array('code' => 1001 ,'msg' => '缺少参数');
        if(!empty($arr)){
            if(!empty($arr['uid'])){
                $order = model('Orders','model');
                $where = ' a.status < 7 and a.uid ='.$arr['uid'];
                $have = $order->getNotcomOrder($where);
                if(!empty($have)){
                    $res = array('code' => 1000 ,'count' => count($have));
                }else{
                    $res = array('code' => 1002 ,'msg' => '暂无数据');
                }
            }
        }
        return json($res);
    }
    /**
     * 用户订单列表
     */
    public function userorderlist()
    {
        $arr = $this->arr;
        $res = array('code' => 1001 ,'msg' => '缺少参数');
        if(!empty($arr)){
            if(!empty($arr['uid'])){
                $order = model('Orders','model');
                $list = $order->getUserOrder($arr['uid']);
//                if(!empty($list)){
                $res = array('code' => 1000 ,'data' => $list);
//                }else{
//                    $res = array('code' => 1002 ,'msg' => '暂无数据');
//                }
            }
        }
        return json($res);
    }
    /**
     * 司机订单列表
     */
    public function driverorderlist()
    {
        $arr = $this->arr;
        $res = array('code' => 1001 ,'msg' => '缺少参数');
        if(!empty($arr)){
            if(!empty($arr['did'])){
                $order = model('Orders','model');
                $list = $order->getDriverOrder($arr['did']);
//                if(!empty($list)){
                    $res = array('code' => 1000 ,'data' => $list);
//                }else{
//                    $res = array('code' => 1002 ,'msg' => '暂无数据');
//                }
            }
        }
        return json($res);
    }
    /**
     * 司机取消订单
     */
    public function dcancelorder()
    {
        $arr = $this->arr;
        $res = array('code' => 1001 ,'msg' => '缺少参数');
        if(!empty($arr)){
            if(!empty($arr['oid']) && !empty($arr['did'])){
                $data['status'] = 1;
                $data['did'] = '';
                $where['oid'] = $arr['oid'];
                $where['did'] = $arr['did'];
                $order = model('Orders','model');
                $user = model('Users','model');
                if($order->save($data,$where)){
                    $system_data = [
                        'id'=>1,
                        'title'=>'test',
                        'contents'=>'dashduashdioasdjioadasda'
                    ];
                    $push_data = [
                        'title'=>'dasdadsa',
                        'extras'=>[
                            'type'=>'system',
                            'status'=>'0',
                            'data'=>$system_data
                        ]
                    ];
                    $info = $order->get($arr['oid']);
                    if(!empty($user->get($info->uid)->registrationid)){
                        $this->push->regalerts('您的订单已经取消，正在等待司机接单。',$user->get($info->uid)->registrationid,$push_data,$push_data);
                    }
                    $res = array('code' => 1000 ,'msg' => '取消成功');
                }
            }
        }
        return json($res);
    }
    /**
     * 用户取消订单
     */
    public function ucancelorder()
    {
        $arr = $this->arr;
        $res = array('code' => 1001 ,'msg' => '缺少参数');
        if(!empty($arr)){
            if(!empty($arr['oid']) && !empty($arr['uid'])){
                $data['status'] = 101;
                if(!empty($arr['reason_id'])){
                    $data['reason_id'] = $arr['reason_id'];
                }
                $where['oid'] = $arr['oid'];
                $where['uid'] = $arr['uid'];
                $order = model('Orders','model');
                $info = $order->get($arr['oid']);
                if(!empty($info)){
                    if($info->status > 3 && $info->did != 0 && $info->status != 101){
                        if($info->status == 101){
                            $res = array('code' => 1003 ,'msg' => '此订单已经取消');
                        }else{
                            $res = array('code' => 1002 ,'msg' => '您已上车，取消失败');
                        }
                    }else{
                        if($order->save($data,$where)){
                            $res = array('code' => 1000 ,'msg' => '取消成功');
                        }
                    }
                }else{
                    $res = array('code' => 1004,'msg' => '订单不存在');
                }
            }
        }
        return json($res);
    }
    /**
     * 提交预约订单
     */
    public function submakeorder()
    {
        $arr = $this->arr;
        $res = array('code' => 1001 ,'msg' => '缺少参数');
        if(!empty($arr)){
            $order = model('Orders','model');
            $validate = validate('Orders');
            $str = '';
            foreach ($arr as $key => $val){
                $str .= ','.$val['uid'];
                $arr[$key]['make_time'] = strtotime($val['make_time']);
                $arr[$key]['status'] = 1;
                $arr[$key]['osn'] = date('ymdhis').rand(10,99).rand(10,99);
                $arr[$key]['add_time'] = time();
                if(!$validate->check($val)){
                    $res = array('code' => 1002,'msg' => $validate->getError());
                    return json($res);
                }
            }
            $str = substr($str,1);
            $have = $order->where('status < 7 and uid in('.$str.')')->find();
            if(empty($have)) {
                if($order->allowField(true)->saveAll($arr)){
                    $res = array('code' => 1000,'msg' => '预约成功');
                }else{
                    $res = array('code' => 1003,'msg' => '失败');
                }
            }else{
                $res = array('code' => 1002,'msg' => '您有订单正在处理，请处理之后下单。');
            }
            $res['input'] = $arr;
        }
        return json($res);
    }
    public function submakeorder2()
    {
        $arr = $this->arr;
        $res = array('code' => 1001 ,'msg' => '缺少参数');
        if(!empty($arr['arr'])){
            $order = model('Orders','model');
            $validate = validate('Orders');
            $str = '';
            foreach ($arr['arr'] as $key => $val){
                $str .= ','.$val['uid'];
                $arr['arr'][$key]['make_time'] = strtotime($val['make_time']);
                $arr['arr'][$key]['status'] = 1;
                $arr['arr'][$key]['osn'] = date('ymdhis').rand(10,99).rand(10,99);
                $arr['arr'][$key]['add_time'] = time();
                if(!$validate->check($val)){
                    $res = array('code' => 1002,'msg' => $validate->getError());
                    return json($res);
                }
            }
            $str = substr($str,1);
            $have = $order->where('status < 5 and uid in('.$str.')')->find();
            if(empty($have)) {
                if($order->allowField(true)->saveAll($arr['arr'])){
                    $res = array('code' => 1000,'msg' => '预约成功');
                }else{
                    $res = array('code' => 1003,'msg' => '失败');
                }
            }else{
                $res = array('code' => 1002,'msg' => '您有订单正在处理，请处理之后下单。');
            }
            $res['input'] = $arr;
        }
        return json($res);
    }
    /**
     * 评价内容
     */
    public function assess_content()
    {

        $ass = model('AppraiseScore','model');
        $list = $ass->all();
//        if(!empty($list)){
            $res = array('code' => 1000 ,'data' => $list);
//        }else{
//            $res = array('code' => 1002 ,'msg' => '暂无数据');
//        }
        return json($res);
    }
    /**
     * 评价司机
     */
    public function assess_driver()
    {
        $arr = $this->arr;
        $res = array('code' => 1001 ,'msg' => '缺少参数');
        if(!empty($arr)){
            if(!empty($arr['oid']) && !empty($arr['assess'])){
                $ass = model('AppraiseScore','model');     // 评价
//                $driver = model('Driver','model');         // 司机
                $order = model('Orders','model');          // 订单
                $data['user_assess'] = $arr['assess'];
                $data['status'] = 8;
                $where['oid'] = $arr['oid'];

//                ('integer',$asinfo['score'])->inc('glod' ,$asinfo['glod']);
                if($order->save($data,$where)){
                    $asinfo = $ass->get($arr['assess']);       // 评价奖励详情
                    // 评价加上对应的分数。金币
                    $driverid = $order->get($arr['oid'])->did;
//                echo $did;
//                exit;
                    db('driver')->where('did ='.$driverid)->update([
                        'integer'    =>  ['exp','`integer`+'.$asinfo['score']],
                        'glod'       =>  ['exp','`glod` +'.$asinfo['glod']],
                        // 'level'      =>  ['exp','`level`+50']
                    ]);
                    
                    $res = array('code' => 1000 , 'msg' => '评价成功');
                }else{
                    $res = array('code' => 1002 , 'msg' => '评价失败');
                }
            }
        }
        return json($res);
    }
    /**
     * ===================================================================================================================
     */
    /**
     * 身份信息
     */
    public function editiden()
    {
        $arr = $_POST;
        $res = array('code' => 1001 ,'msg' => '缺少参数');
        if(!empty($arr)) {
            if(!empty($arr['did']) && !empty($arr['bank_name']) && !empty($arr['bank_num'])){
                $where['did'] = $arr['did'];
                $driver = model('Driver','model');
//                $arr['first_driver'] = strtotime($arr['first_driver']);
                $data = $arr;
//                $header_img = request()->file('header_img');      // 头像
//                if(!empty($header_img)){
//                    $info = $header_img->validate(['ext' => 'jpg,jpeg,gif,png'])->move(ROOT_PATH.'public/static'.DS.'upload/driver/');
//                    if($info){
//                        $data['header_img'] = '/static/'.$info->getSaveName();
//                    }else{
//                        $res['top'] = '头像未上传';
//                    }
//                }
                $info = $driver->get($arr['did']);
                if($info->aud_status != 1){
                    if($driver->allowField(true)->save($data,$where)){
                        $driverbank = model('DriverBank','model');
                        $dcount = $driverbank->where('did ='.$info->did)->count();
                        if($dcount > 3){
                            $bdata['did'] = $arr['did'];
                            $bdata['bank_num'] = $arr['bank_num'];
                            $bdata['bank_name'] = $arr['bank_name'];
                            $driverbank->allowField(true)->save($bdata);
                        }
                        $res = array('code' => 1000 ,'msg' => '添加成功');
                    }else{
                        $res = array('code' => 1002 ,'msg' => '添加失败');
                    }
                }else{
                    $res = array('code' => 1002 ,'msg' => '您审核已经通过。请勿重新提交。');
                }
            }
        }
        return json($res);
    }
    /**
     * 车辆信息
     */
    public function upload()
    {
        $arr = $_POST;
        $res = array('code' => 1001 ,'msg' => '缺少参数');
        if(!empty($arr)){
            if(!empty($arr['did']) && !empty($arr['owner']) && !empty($arr['car_date']) && !empty($arr['car_num']) ){
                $driver = model('Driver','model');
                $where['did'] = $arr['did'];       // 接受到的司机ID
                unset($arr['did']);           // 删除司机ID
                $data = $arr;
                $driverlicens_top = request()->file('driverlicens_top');        // 行驶证正面
                if(!empty($driverlicens_top)){
                    $info = $driverlicens_top->validate(['ext' => 'jpg,jpeg,gif,png'])->move(ROOT_PATH.'public/static'.DS.'upload/driver/');
                    if($info){
                        $data['driverlicens_top'] = '/static/upload/driver/'.$info->getSaveName();
                    }else{
                        $res['top'] = '行驶证正面未上传成功';
                    }
                }
                $driverlicens_under = request()->file('driverlicens_under');      // 行驶证反面
                if(!empty($driverlicens_under)){
                    $info = $driverlicens_under->validate(['ext' => 'jpg,jpeg,gif,png'])->move(ROOT_PATH.'public/static'.DS.'upload/driver/');
                    if($info){
                        $data['driverlicens_under'] = '/static/upload/driver/'.$info->getSaveName();
                    }else{
                        $res['top'] = '行驶证反面未上传成功';
                    }
                }
                $driverlicens_header = request()->file('driverlicens_header');       // 驾驶证正面
                if(!empty($driverlicens_header)){
                    $info = $driverlicens_header->validate(['ext' => 'jpg,jpeg,gif,png'])->move(ROOT_PATH.'public/static'.DS.'upload/driver/');
                    if($info){
                        $data['driverlicens_header'] = '/static/upload/driver/'.$info->getSaveName();
                    }else{
                        $res['top'] = '行驶证反面未上传成功';
                    }
                }
                $driverlicens_footer = request()->file('driverlicens_footer');       // 驾驶证反面
                if(!empty($driverlicens_footer)){
                    $info = $driverlicens_footer->validate(['ext' => 'jpg,jpeg,gif,png'])->move(ROOT_PATH.'public/static'.DS.'upload/driver/');
                    if($info){
                        $data['driverlicens_footer'] = '/static/upload/driver/'.$info->getSaveName();
                    }else{
                        $res['top'] = '行驶证反面未上传成功';
                    }
                }
                $car_person = request()->file('car_person');        //人车合一
                if(!empty($car_person)){
                    $info = $car_person->validate(['ext' => 'jpg,jpeg,gif,png'])->move(ROOT_PATH.'public/static'.DS.'upload/driver/');
                    if($info){
                        $data['car_person'] = '/static/upload/driver/'.$info->getSaveName();
                    }else{
                        $res['top'] = '行驶证反面未上传成功';
                    }
                }
                $policy = request()->file('policy');                      // 保单
                if(!empty($policy)){
                    $info = $policy->validate(['ext' => 'jpg,jpeg,gif,png'])->move(ROOT_PATH.'public/static'.DS.'upload/driver/');
                    if($info){
                        $data['policy'] = '/static/upload/driver/'.$info->getSaveName();
                    }else{
                        $res['top'] = '行驶证反面未上传成功';
                    }
                }
                if($driver->allowField(true)->save($data,$where)){
                    $res = array('code' => 1000 ,'msg' => '添加成功');
                }else{
                    $res = array('code' => 1002 ,'msg' => '添加失败');
                }
            }
        }
        return json($res);
    }
    /**
     * 从业信息
     */
    public function cyinfo()
    {
        $arr = $_POST;
        $res = array('code' => 1001 ,'msg' => '缺少参数');
        if(!empty($arr)){
            if(!empty($arr['did'])){
                $driver = model('Driver','model');
                $where['did'] = $arr['did'];       // 接受到的司机ID
                unset($arr['did']);           // 删除司机ID
                $data = $arr;
                $driverlicens_top = request()->file('service_img');        // 服务卡照片
                if(!empty($driverlicens_top)){
                    $info = $driverlicens_top->validate(['ext' => 'jpg,jpeg,gif,png'])->move(ROOT_PATH.'public/static'.DS.'upload/driver/');
                    if($info){
                        $data['service_img'] = '/static/upload/driver/'.$info->getSaveName();
                    }else{
                        $res['top'] = '服务卡照片未上传成功';
                    }
                }
                $driverlicens_under = request()->file('certification_img');      // 从业资格证照片
                if(!empty($driverlicens_under)){
                    $info = $driverlicens_under->validate(['ext' => 'jpg,jpeg,gif,png'])->move(ROOT_PATH.'public/static'.DS.'upload/driver/');
                    if($info){
                        $data['certification_img'] = '/static/upload/driver/'.$info->getSaveName();
                    }else{
                        $res['top'] = '从业资格证照片未上传成功';
                    }
                }
                if($driver->allowField(true)->save($data,$where)){
                    $res = array('code' => 1000 ,'msg' => '添加成功');
                }else{
                    $res = array('code' => 1002 ,'msg' => '添加失败');
                }
            }
            $res['input'] = $arr;
        }
        return json($res);
    }
    /**
     * 支付
     */
    public function payprice()
    {
        $arr = $this->arr;
        $res = array('code' => 1001 ,'msg' => '缺少参数');
        if(!empty($arr)){
            if(!empty($arr['oid']) && !empty($arr['uid']) && !empty($arr['type'])){
                $order = model('Orders','model');
                $user = model('Users','model');
                $driver = model('Driver','model');
                $oinfo = $order->get($arr['oid']);
                if(!empty($oinfo)){
                               // 获取订单价格
                    $uinfo = $user->get($arr['uid']);
                    $blance = $uinfo->balance;             // 获取用户余额
                    if($oinfo->status < 7){
                        $data['status'] = 7;               // 订单状态
                        $data['pay_type'] = $arr['type'];  // 1余额支付2现金支付
                        $data['dis_price'] = $arr['price'];  // 应付款
                        $where['oid'] = $oinfo->oid;
                        if($arr['type'] == 1) {         // 如果为余额支付 否则为现金支付
                            $price = $arr['price'];
                            if ($blance > $price) {
                                if ($order->allowField(true)->save($data, $where)) {
                                    $user->where('uid =' . $uinfo->uid)->Dec('balance', $price)->update();
                                    // echo $user->getLastSql();
                                    // exit;
                                    // 支付完成后删除优惠券
                                    if(!empty($arr['youid'])){
                                        db('parts_user')->where('uid = '.$uinfo->uid.' and pid ='.$arr['youid'])->delete();
                                    }
                                    $res = array('code' => 1000, 'msg' => '支付成功');
                                    $log = model('PriceLog', 'model');
                                    if ($oinfo->car_id == 1) {
                                        $str = '出租车消费';
                                    } else if ($oinfo->car_id == 1) {
                                        $str = '快车消费';
                                    } else {
                                        $str = '尊享车消费';
                                    }
                                    $ldata['uid'] = $uinfo->uid;
                                    $ldata['desc'] = $str;
                                    $ldata['blance'] = $user->get($uinfo->uid)->balance;
                                    $ldata['type'] = 2;
                                    $ldata['oid'] = $oinfo->oid;
                                    $ldata['price'] = $oinfo->total_price;
                                    $ldata['tran_time'] = time();
                                    $log->allowField(true)->save($ldata);
                                    $dlog = model('DriverLog', 'model');
                                    $dldata['did'] = $oinfo->did;
                                    $dldata['desc'] = $uinfo->nick_name . '支付';
                                    $dldata['blance'] = $driver->get($oinfo->did)->blance;
                                    $dldata['type'] = 1;
                                    $dldata['price'] = $oinfo->total_price;
                                    $dldata['save_time'] = time();
                                    $dlog->save($dldata);
                                }
                            } else {
                                $res = array('code' => 1004, 'msg' => '余额不足');
                            }
                        }else{
	                        $system_data = [
		                        'id'=>1,
		                        'title'=>'test',
		                        'contents'=>'dashduashdioasdjioadasda'
	                        ];
	                        $push_data = [
		                        'title'=>'dasdadsa',
		                        'extras'=>[
			                        'type'=>'system',
			                        'status'=>'0',
			                        'data'=>$system_data
		                        ]
	                        ];
	                        if(!empty($driver->get($oinfo->did)->registrationid)){
		                        $this->dpush->regalerts($uinfo->nick_name.' 成功支付，金额：'.$oinfo->total_price.'元。',$driver->get($oinfo->did)->registrationid,$push_data,$push_data);
	                        }
                            if ($order->save($data, $where)) {
                                $res = array('code' => 1000, 'msg' => '支付成功');
                            }
                        }
                    }else{
                        $res = array('code' => 1003,'msg' => '已经支付');
                    }
                }else{
                    $res = array('code' => 1002,'msg' => '订单不存在');
                }
            }
        }
        return json($res);
    }
    /**
     * 用户支付完成订单
     */
    public function paycomorder()
    {
         $arr = $this->arr;
         $res = array('code' => 1001 ,'msg' => '缺少参数');
         if(!empty($arr)){
             if(!empty($arr['uid'])){
                 $where['uid'] = $arr['uid'];
                 $order = model('Orders','model');
                 $where['status'] = ['>=',7];
                 $where['openin'] = 0;
                 $list = $order->where($where)->select();
                //  echo $order->getLastSql();
//                 if(!empty($list)){
                foreach($list as $key => $val){
                    unset($list[$key]['driver_trip']);
                }
                 $res = array('code' => 1000 , 'data' => $list);
//                 }else{
//                     $res = array('code' => 1002, 'msg' => '暂无数据');
//                 }
             }
         }
         return json($res);
    }
    /**
     * 开发票
     */
    public function openinvoice()
    {
        $arr = $this->arr;
        $res = array('code' => 1001 , 'msg' => '缺少参数');
        if(!empty($arr) && !empty($arr['oid'])){
            $validate = validate('Invoice');
            if($validate->check($arr)){
                $arr['add_time'] = time();
                $order = model('Orders','model');
                $price = 0;
                foreach ($arr['oid'] as $key => $val){
                    $list[] = ['oid' => $val , 'openin' => 1];
                    $price += $order->get($val)->total_price;
                }
                $order->saveAll($list);
                $arr['oid'] = implode(',',$arr['oid']);
                $arr['total_price'] = $price;
                $invoice = model('Invoice','model');
                if($invoice->allowField(true)->save($arr)){
                    $res = array('code' => 1000 ,'msg' => '添加成功');
                }
            }else{
                $res = array('code' => 1003 ,'msg' => $validate->getError());
            }
        }
        return json($res);
    }
    /**
     * 开票历史
     */
    public function openhistory()
    {
        $arr = $this->arr;
        $res = array('code' => 1001 , 'msg' => '缺少参数');
        if(!empty($arr)){
            if(!empty($arr['uid'])){
                $where['uid'] = $arr['uid'];
                $invoice = model('Invoice','model');
                $order = model('Orders','model');
                $list = $invoice->where($where)->order('add_time desc')->select();
                if(!empty($list)){
                    foreach ($list as $key => $val){
                        $list[$key]->order = [];
                        $list[$key]->order = $order
                            ->field('oid,osn,uid,did,car_id,car_type,make_type,make_id,start_add,end_add,total_price,add_time')
                            ->order('add_time asc')
                            ->where('oid in ('.$val->oid.')')
                            ->select();
                    //         echo $order->getLastSql();
                        if(!empty($list[$key]->order)){
                            $count = count($list[$key]['order'])-1;
                            if($count < 0){
                                $count = 0;
                            }
                            $list[$key]['setime'] = $list[$key]['order'][0]->add_time .' - '.
                                $list[$key]['order'][$count]->add_time;
                        }
                    }
                }
                $res = array('code' => 1000 ,'data' => $list);
            }
        }
        return json($res);
    }
    /**
     * 扫码支付回调
     */
    public function alipay_res()
    {
        if($_POST){
            $osn = $_POST['out_trade_no'];
            $status = $_POST['trade_status'];
            if($status == 'TRADE_SUCCESS'){
                $order = model('Orders','model');
                $data['status'] = 7;
                $data['pay_type'] = 3;
                $order->where('osn ='.$osn)->update($data);
                $log = model('PriceLog','model');
                $dlog = model('DriverLog','model');
                $driver = model('Driver','model');
                $user = model('Users','model');
                $oinfo = $order->where('osn ='.$osn)->find();     //订单详情
                $uinfo = $user->get($oinfo->uid);                //用户详情
                $udata['uid'] = $oinfo->uid;
                $udata['price'] = $oinfo->total_price;
//                $udata['desc']
                if($oinfo->car_type == 1){
                    $str = '出租车消费';
                }else if($oinfo->car_type == 2){
                    $str = '快车消费';
                }else{
                    $str = '尊享车消费';
                }
                $udata['desc'] = $str;
                $udata['oid'] = $oinfo->oid;
                $udata['blance'] = $uinfo->balance;
                $udata['type'] = 2;
                $udata['pay_type'] = 2;
                $udata['tran_time'] = time();
                $log->save($udata);
                $ddata['did'] = $oinfo->did;
                $ddata['desc'] = '车费收入';
                $ddata['price'] = $oinfo->total_price;
                $ddata['type'] = 1;
                $ddata['blance'] = $driver->get($oinfo->did)->blance;
                $ddata['save_time'] = time();
                $driver->where('did ='.$oinfo->did)->inc('blance',$oinfo->total_price)->update();
                $dlog->save($ddata);
	            $system_data = [
		            'id'=>1,
		            'title'=>'test',
		            'contents'=>'dashduashdioasdjioadasda'
	            ];
	            $push_data = [
		            'title'=>'dasdadsa',
		            'extras'=>[
			            'type'=>'system',
			            'status'=>'0',
			            'data'=>$system_data
		            ]
	            ];
	            if(!empty($driver->get($oinfo->did)->registrationid)){
		            $this->dpush->regalerts($uinfo->nick_name.' 成功支付，金额：'.$oinfo->total_price.'元。',$driver->get($oinfo->did)->registrationid,$push_data,$push_data);
	            }
            }
        }
//        $arr = [
//            'input'    => input('post.'),
//            'get1'     => input('get.'),
//            'get'      => $_GET,
//            'post'     => $_POST,
//            'arr'      => $this->arr
//        ];
////        if(!emfile_put_contentspty(input())){
//            ($dir.'1.txt',json_encode($arr));
//        }
    }
    /**
     * 获取支付宝二维码
     */
    public function alipay(){
//        $config = array (
//            //签名方式,默认为RSA2(RSA2048)
//            'sign_type' => "RSA2",
//            'sign'      => '',
//            //支付宝公钥
//            'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAvGSw9WRmbyJVWGts4UStXJdvDb6KoVOVF45Q2q46GJIU1pLnkCxXLaZEOsJ0r3LXWFWUnInTOkOqDoe+xMKyhZxCBdjw2atJPMbNr0MSa90pojlUIVS9inChUhuLHl3U7y+NYQbbCeRFlcQLDls6QJSHU9L221hZBPo0Vp4UNYEvMEMFvSq2NbR3auRwrGq3DZAeek5V5cKtYNnchiMU9bp2D7XxW+4EKrPHCI3ihRxoj4KUIuH/VMu4gj8KUyFK9NMUQsu/Q8A2d2lcf5ihL3XojHRxGHJPHTQIfqRtAQ8cz/RxYHD80SaBijcNjNsQyHPdl9LlBn76sS/fINIqLwIDAQAB",
//            //商户私钥
//            'merchant_private_key' => "MIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQC6FQateTGc3QycTocRh8gCrvOj0/NyAsJJZ+H4kHn288+6mr4lRuiKBrdIBqh/0CbfceL18lQFOJIj0k9i9Auaf6PnOVY8lHNgYE1IgtdsF+TnVCltAOZZuNCjw/lsLZ58Dn9IQrU+IvYUWwgT2Su2L8xRO/WqjtEQjbPbFLx7B6ScKrVFaceol8Lxm4m+7gxc+UBHLmF/T38Cc60Xq06WMbOVw110VbrsmXcaDuyNotQIgMQp4BmWz17hc0053fm4GB2zVssgZbtGhDK58ToK0YFiZHM11D++rTdTuDkW5tQrTZ6sJ4q2covDH9a6bb/FKLeikIWIZF6oIoPlC/X5AgMBAAECggEBAK2hsPltfL3CBWJUY/QXnqniVbUosKBRsriMFm65YRTtq4eTnJlr8M/aNGsgy1l4AM2+luinlX7JqpOCSlErJyiisW2wMqeUXZQwR+zBKgHSyeSQw5bSoB5YNVaaJsKqTpezb1Ed7cBtHvEfgAoFOqRlNWEXccQUP0AS+SAT2Utx3sNa6AR4GpziPMaFY9OsrYs0EAN2DAHQSx67Oavhk9H6DHaVw7VJY7cYXnnFXorYZaHej7NF2x785PSUnEd0JJ81gDlvFdmr8q3ErVmXj+IfxG1VSVGH3VaR6XYlHQoXKVbCylJTn3FbVd+wTiI9jj/ZnrteZCrEQPfyyiFEr4ECgYEA4Sxu33q2XN+shX949+vzaazuBVLIJE6i6XZSJ52CHjz785ZQEEDCmNUZMGJ6RLP6tFF5dn9IfLpFdL/HflN+jVjEwLu2vzaNV+yXOI3VSFPvDw/5bcXeZoDab9qIkxDkhoEJCNYYmdUTkUAHBDlN1CJguim1K22kwLuCuOFQpssCgYEA046SQm/f5WfPZxI1rsnvPmJ5O4ao4xF6BtDTlnXk3q8nsMpkdKx8qC9c0fX9lFujGSzDT7wvVKLVuFvWVlnpnu3ARqrNIKQLPd5QzH+uMLPfND43WfA5Kzt7b7HsuLbjJJ1bWqu8NmKqXlWGNfXBiu07EZzFQBPhmAvBJAPNucsCgYA4qeHMwyiY/oB/p7BdUzcR5L6RAF/1IwTEE05hQbW4vkf46F6FeIZ/x0BreJykJVZ1gfs64pTvLkDEPG6LT5+NGkWI6rP2MlgnRBZZ2PdPGDAUbkSqZxysVsihVTEBMUMQxe/sFVRjgcdGygH6AiGfvHby4gQBRbor9gPTWn/dOQKBgQDNzE55dK1AU8kNwkgYnXYvoMnAX1GhelnTkYeTQWKAQbGBqJEqcrTdQx2vXfXtQWuazNG+mhkM4062hhgubk72fN/jnrnnO813xPGizb4cwI2sG63qvuZOKRH96P6X/clez/iTbqar3TVQiTADA+vgAsDIdFHp8K0vJJghOdYCGwKBgCQPThsagvRcHg1piTi9L+r9BKpKKgOKdcHrK/8qczI/J8Qppm2NLf+DIp8fcgyMRW0T0sIpxXQkQOf0L60OdVbyCkQrvAGRyhVhtyERsIlR7WRWwdogBJR+IVn+2zHbW6m/wwyGWdQi/JY3ONXS8S6UbyPsdz9t3fh0Ivv/vC3i",
//            //编码格式
//            'charset' => "UTF-8",
//            //支付宝网关
//            'gatewayUrl' => "https://openapi.alipay.com/gateway.do",
//            //应用ID
//            'app_id' => "2016090800464865",
//            //异步通知地址,只有扫码支付预下单可用
//            'notify_url' => "http://jielv.181.021mc.net/index.php/index/order/alipay",
//            //最大查询重试次数
//            'MaxQueryRetry' => "10",
//            //查询间隔
//            'QueryDuration' => "3"
//        );
        $arr = $this->arr;
        $res = array('code' => 1001 ,'msg' => '缺少参数');
        if(!empty($arr)){
            if(!empty($arr['oid'])){
                $order = model('Orders','model');
                $info = $order->get($arr['oid']);
                if($info->status < 7){
                    if($info->car_type == 1){
                        $str = '捷律出行出租车服务费';
                    }else if($info->car_type == 2){
                        $str = '捷律出行快车服务费';
                    }else{
                        $str = '捷律出行尊享车服务费';
                    }

                    import('dmf.aop.AopClient');
                    import('dmf.aop.request.AlipayTradePrecreateRequest');
                    $account = model('Account','model');
                    $config = $account->getAccount('alipay');
                    $aop = new \AopClient ();
                    $aop->gatewayUrl = $config->gatewayurl;
                    $aop->appId = $config->appid;
                    $aop->rsaPrivateKey = $config->secret;  //account
                    $aop->alipayrsaPublicKey = $config->account; //secret
                    $aop->apiVersion = '1.0';
                    $aop->signType = 'RSA2';
                    $aop->postCharset='UTF-8';
                    $aop->format='json';
                    $request = new \AlipayTradePrecreateRequest();
                    $request->setNotifyUrl('http://jielv.181.021mc.net/index.php/index/order/alipay_res');
                    $request->setApiMethodName('alipay.trade.precreate');
                    if(!empty($info)){
                        $request->setBizContent("{" .
                            "\"out_trade_no\":\"{$info->osn}\"," .
                            "\"total_amount\":{$info->total_price}," .
                            "\"subject\":\"{$str}\"" .
                            "}");
                    }
                    $result = $aop->execute($request);
                    $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
                    $data = $result->$responseNode;
                    import('phpqrcode.phpqrcode');
                    // 纠错级别：L、M、Q、H
                    $level = 'H';
                    // 点的大小：1到10,用于手机端4就可以了
                    $size = 4;
                    $time_path = date('Y/m/d/', time());
                    $server_path = ROOT_PATH.'public/static/upload/code/' . $time_path;
                    $filename = uniqid() . '.png';
                    $file = $server_path . $filename;
                    // 判断目录书否创建
                    if(!is_dir($server_path)){
                        mkdir($server_path,0777,true);
                    }
                    $url_data = $data->qr_code;
                    $qr_code = new \QRcode();
                    $qr_code::png($url_data, $file, $level, $size);
                    $res = array('code' => 1000 ,'img' => config('server_url').'/static/upload/code/'.$time_path . $filename);
    //                return "<img src=\"/static/upload/code/".$time_path . $filename."\" />";
                }else{
                    $res = array('code' => 1002 ,'msg' => '此订单支付完成');
                }
            }
        }
        return json($res);
//        if(!empty($resultCode)&&$resultCode == 10000){
////            echo $result->$responseNode->pr_code;
//        } else {
//            echo "失败";
//        }
//        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
//        $resultCode = $result->$responseNode->code;
//        return json($result);
    }
    /**
     * 投诉订单
     */
    public function complaint()
    {
        $arr = $this->arr;
        $res = array('code' => 1001 ,'msg' => '缺少参数');
        if(!empty($arr)){
            $complaint = model('Complaint');
            $validate = validate('Complaint');
            if($validate->check($arr)){
                if($complaint->allowField(true)->save($arr)){
                    $res = array('code' => 1000 ,'msg' => '投诉成功');
                }else{
                    $res = array('code' => 1002 , 'msg' => '失败');
                }
            }else{
                $res = array('code' => 1003 ,'msg' => $validate->getError());
            }
        }
        return json($res);
    }
}

<?php
/**
 * 订单类
 */

namespace app\index\model;

use think\Model;
use think\Session;

class Orders extends Model
{
    protected $update = ['handle_time'];
    protected function setHandleTimeAttr(){
        return time();
    }
	protected function getMakeTimeAttr($val){
    	if(!empty($val)){
		    return date("n月d日 G点i分",$val);
	    }
	}
    protected function getAddTimeAttr($val){
        return date("n月d日 G点i分",$val);
    }
    /**
     * 获取订单详情
     */
    public function getOrderList($where,$did,$km = 5,$lat,$lng,$auto = false)
    {
        $where['a.did'] = $did;
        $where['a.status'] = [['<=',6],['>=',2]];
        $have = self::alias('a')
            ->field('a.*,b.mobile,b.nick_name,b.header_img,b.unique_id')
            ->join('users b','a.uid = b.uid')
            ->order('a.status asc')
            ->where($where)
            ->limit(0,1)
            ->select();
        unset($where['a.did']);
        unset($where['a.status']);
        $where['a.status'] = 1;
        $where['make_time'] = ['<',strtotime('+3 hours', time())];     // 订单为预约单，派发三小时内的订单
        if(!empty($have)){
//            $list = self::alias('a')
//                ->field('a.*,b.mobile,b.nick_name,b.header_img,b.unique_id')
//                ->join('users b','a.uid = b.uid')
//                ->order( 'add_time desc')
//                ->where($where)
//                ->select();
//            foreach($list as $key => $val){
//                $list[$key]['str'] = '新订单,预约,,从,,,'.$val->start_add .',,到,,'.$val->end_add.',,,,全程'
//                    .$val->km_num.'公里,,,预计车费,,,'.ceil($val->make_price).'元';
//                array_push($have,$list[$key]);
//            }
	        foreach ($have as $key => $val){
		        unset($have[$key]['driver_trip']);
	        }
            return $have;
        }else{
            $list = self::alias('a')
                ->field('a.*,b.mobile,b.nick_name,b.header_img,b.unique_id')
                ->join('users b','a.uid = b.uid')
                ->order( 'add_time desc')
                ->where($where)
	            ->order(" RAND()")
                ->limit(0,1)
                ->select();
                // echo self::getLastSql();
            foreach($list as $key => $val){
                $list[$key] = $val->toArray();
                if($val['make_type'] == 1){
                    $str = '实时';
                }else{
                    $str = '预约,,,'.$val['make_time'].'出发';
                }
                $distance = calcDistance($val['start_lat'],$val['start_lng'],$lat,$lng);
                // 如果在公里内打开了自动接单，自动接单。
                $list[$key]['str'] = '新订单,'.$str.'全程'.$val->km_num.'公里,,从,,,'.$val->start_add .',,到,, '.$val->end_add.',,,
                ,,预计车费,,,'.ceil($val->make_price).'元';
                if($distance >= $km){
                    unset($list[$key]);
                }else{
                    if($auto == 2){
                        $data['did'] = $did;
                        $data['status'] = 2;
                        self::allowField(true)->save($data,['oid' => $val['oid']]);
                        $list[$key]['str'] = '自动接单成功,'.$str.'全程'.$val->km_num.'公里,,从,,,'.$val->start_add .',,到,, '.$val->end_add.',,,
                        ,,预计车费,,,'.ceil($val->make_price).'元';
                    }
                }
            }
        }
        foreach ($list as $key => $val){
            unset($list[$key]['driver_trip']);
        }
//        foreach ()
        return $list;
    }
    /**
     * 即时获取订单详情，返回不同的数据
     */
    public function getOrderInfo($where){
//        $stime = strtotime('-2 second');
//        $stime = strtotime('-1 day');
//        $endtime = time();
        $where['a.uid'] = $where['uid'];
//        $where['a.status'] = ['<','7'];
        unset($where['uid']);
        unset($where['lat']);
        unset($where['lng']);
//        $where['handle_time'] = ['between',[$stime,$endtime]];
//        echo $stime.','.$endtime;
        $info = self::alias('a')
            ->where($where)
            ->order('add_time desc')
            ->find();
//        echo self::getLastSql();
        if(!empty($info)){
            $data = self::alias('a')
                ->field('a.*,b.balance,c.mobile,c.car_num,c.rela_name,c.header_img as driver_img,c.car_plate,c.unique_id')
                ->join('users b','a.uid = b.uid')
                ->join('driver c','a.did = c.did','left')
                ->where($where)
                ->order('a.add_time desc')
                ->find();
//            echo self::getLastSql();
            $user = model('Users','model');
            if(!empty($data['total_price'])){
                $parts = $user->alias('a')
                    ->join('parts_user b','a.uid = b.uid')
                    ->join('parts c','b.pid = c.id')
                    ->where('m_price <= '.$data['total_price'].' and end_time >'.time().' and b.max_time >'.time())
                    ->order('d_price desc')
                    ->find();
                if(!empty($parts)){
                    $data->youid = $parts->id;      // 优惠券id
                    $data->reduce_price = $parts->d_price;     // 优惠多少钱
                    $data->y_price = (string)sprintf('%.2f',$data->total_price - $parts->d_price);    // 应付价格
                }
            }
            $data->driver_img = config('server_url').$data->driver_img;
            $data['km_num'] = sprintf('%.2f',calcDistance(Session('jwd')['lat'],Session('jwd')['lng'],$data['start_lat'],$data['start_lng']));
            if(!empty($data['rela_name'])){
                $data['rela_name'] = mb_substr($data['rela_name'],0,1).'师傅';
            }
            unset($data['driver_trip']);
            $res = array('code' => 1000 ,'data' => $data);
        }else{
            $res = array('code' => 1002 ,'msg' => '暂无数据');
        }
        return $res;
    }
    /**
     * 获取用户未完成订单
     */
    public function getNotcomOrder($where){
        $info = self::alias('a')
            ->field('a.oid,a.osn,b.uid,a.car_id,a.car_type,a.make_type,a.start_lat,a.start_lng,a.end_lat,a.end_lng,a.start_add,a.end_add
            ,a.remark,a.remark,a.total_price,a.status,a.add_time,b.nick_name,b.mobile,b.header_img,c.did,c.header_img as driver_img,
            c.rela_name')
            ->join('users b','a.uid = b.uid')
            ->join('driver c','a.did = c.did','left')
            ->where($where)
            ->find();
        return $info;
    }
    /**
     * 获取用户订单列表
     */
    public function getUserOrder($uid){
        $list = self::alias('a')
            ->field('a.*,b.nick_name,b.mobile,c.rela_name,c.car_num,c.car_plate,c.mobile as dmobile')
            ->join('users b','a.uid = b.uid')
            ->join('driver c','a.did = c.did','left')
            ->where('a.uid = '.$uid.' and a.add_time <'.strtotime('+3 month',time()))
            ->order('add_time desc')
            ->select();
        foreach ($list as $key => $val){
            if(!empty($val['rela_name'])){
                $list[$key]['rela_name'] = mb_substr($val['rela_name'],0,1).'师傅';
            }
            unset($list[$key]['driver_trip']);
        }
        return $list;
    }
    /**
     * 获取司机订单列表
     */
    public function getDriverOrder($did){
        $list = self::alias('a')
            ->field('a.*,b.header_img,b.nick_name,b.mobile,b.sex,c.mobile,b.unique_id')
            ->join('users b','a.uid = b.uid')
            ->join('driver c','a.did = c.did')
            ->order('add_time desc')
            ->where('a.did = '.$did)
            ->select();
        foreach ($list as $key => $val){
            unset($list[$key]['driver_trip']);
            if(!empty($val['header_img'])){
                $list[$key]['header_img'] = config('server_url').$val['header_img'];
            }
        }
        return $list;
    }
    /**
     * 评价
     */
//    public function assesave($data,$where)
//    {
//        $ass = model('AppraiseScore','model');     // 评价
//        $driver = model('Driver','model');         // 司机
//        $asinfo = $ass->get($data['user_assess']);       // 评价奖励详情
//        $dwhe['did'] = self::get($where['oid'])->did;
//        $drr = [
//            'integer'   => ['ext','integer+'.$asinfo['score']],
//            'glod'      => ['ext'.'glod+'.$asinfo['glod']]
//        ];
//        if(self::save($data,$where)){
//
//            if($driver->where($dwhe)->update($drr)) {
//                // 加积分结束
//                return true;
//            }else{
//                return false;
//            }
//        }
//    }
}

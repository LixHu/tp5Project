<?php
namespace app\boquan\logic;
use think\Model;
use think\Session;

/**
 * 工单管理逻辑处理类
 */
class WorkOrders extends Model
{
    protected function getStatusAttr($value)
    {
        $status = [
            0 => '',
            1 => '待指派',
            2 => '待指派',
            3 => '已指派',
            4 => '已接受',
            5 => '已完成',
            6 => '待回访',
            7 => '已关闭',
            8 => '待抢单',
            9 => '进行中',
            10 => '待审核',
            11 => '故障处理中'
        ];
        return $status[$value];
    }
    protected $update = ['handle_time'];
    protected function setHandleTimeAttr()
    {
        return time();
    }
    protected function getAddTimeAttr($val){
        return date("Y-m-d H:i:s",$val);
    }
    protected function getHandleTimeAttr($val)
    {
        if (!empty($val)){
            return date("Y-m-d H:i:s",$val);
        }
    }
    protected function getCompleTimeAttr($val)
    {
        if (!empty($val)){
            return date("Y-m-d H:i:s",$val);
        }
    }
    protected function getAssTimeAttr($val){
        if (!empty($val)){
            return date("Y-m-d H:i:s",$val);
        }
    }
    protected function getPlanTimeAttr($val){
        if (!empty($val)){
            return date("Y-m-d H:i:s",$val);
        }
    }
    /**
    * 获取工单状态对应的数据
    */
    public function getStatusData($status = 0,$param)
    {
//        if(!empty($param['createtime'])){
//            $times = explode(' - ',$param['createtime']);
//            unset($param['createtime']);
//            $param['a.add_time'] = ['between',array(strtotime($times[0]),strtotime($times[1]))];
//        }
        $where = [];
        if (!empty($param)){
            $where = $param;
        }
        if ($status != 8){
            $where['a.gid'] = Session('user')->gid;
        }
        $order = 'add_time desc';
//        $where['is_del'] = 0;
        if($status != ''){
            $where['a.status'] = $status;
        }
        if(Session('user')->pid == 1){
//            $where['a.status'] =  11;
            $where['a.zid'] = Session('user')->gid;
            unset($where['a.gid']);
        }
        $wlist = self::alias('a')
                ->field('a.*,b.nick_name as jour_name,b.mobile as jour_mobile,c.nick_name as add_name,c.user_name as add_name2,
                d.user_name as ass_name,d.address as ass_add,d.mobile as ass_mobile,f.user_name as take_name,cl.client_name as cus_name,
                cl.client_tel as cus_mobile,cl.client_address as cus_address')
                ->join('users b','a.jour_id = b.uid','left')
                ->join('users c','a.add_uid = c.uid','left')
                ->join('users d','a.ass_id = d.uid','left')
                ->join('users f','a.uid = f.uid','left')
                ->join('user_car e','a.jour_id = e.uid','left')
                ->join('client cl','a.jour_id = cl.id','left')
                ->where($where)
                ->order($order)
                ->paginate(10);
        $list['list'] = $wlist;
        $list['page'] = $wlist->render();
        return $list;
    }
    public function getStatusData2($status = 0,$param)
    {
//        if(!empty($param['createtime'])){
//            $times = explode(' - ',$param['createtime']);
//            unset($param['createtime']);
//            $param['a.add_time'] = ['between',array(strtotime($times[0]),strtotime($times[1]))];
//        }
        if($status){

            $where = [];
            if (!empty($param)){
                $where = $param;
            }
            if ($status != 8){
                $where['a.gid'] = Session('user')->gid;
            }
            $order = 'add_time desc';
            $where['is_del'] = 0;
            if($status != ''){
                $where['a.status'] = $status;
            }
            $list = self::alias('a')
                ->field('a.*,e.*,b.nick_name as jour_name,b.mobile as jour_mobile,c.nick_name as add_name,c.user_name as add_name2,
                d.user_name as ass_name,d.address as ass_add,d.mobile as ass_mobile,f.user_name as take_name,cl.client_name as cus_name,
                cl.client_tel as cus_mobile,cl.client_address as cus_address')
                ->join('users b','a.jour_id = b.uid','left')
                ->join('users c','a.add_uid = c.uid','left')
                ->join('users d','a.ass_id = d.uid','left')
                ->join('users f','a.uid = f.uid','left')
                ->join('user_car e','a.jour_id = e.uid','left')
                ->join('client cl','a.jour_id = cl.id','left')
                ->where($where)
                ->order($order)
                ->select();

            return $list;
        }
    }
    /**
    *  设定派发给谁的工单
    */
    public function setStatus($data = [])
    {
        if (!empty($data)) {
            $flag = '';
            $status = 3;
            if (empty($data['uid'])){
                $status = 1;
            }
            $uid = $data['uid'];
            $flag = self::save(['uid' => $uid , 'status' => $status],['wo_id' => $data['wo_id']]);
            return $flag;
        }
    }
    /**
     * 审核结算工单
     */
    public function tie_work($wo_id = '')
    {
        if (!empty($wo_id)) {
            $flag = '';
            $flag = self::save(['status' => 6],['wo_id' => $wo_id]);
            $fund = model('Fund');
            $info = self::get($wo_id);
            $fund->wo_sn = $info->wo_sn;
            $fund->save();
            return $flag;
        }
    }
    /**
     *  回访并关闭工单
     */
    public function VisitWork($data = [])
    {
        if (!empty($data))
        {
            $data['status'] = 7;
            $wo_id = $data['wo_id'];
            unset($data['wo_id']);
            $flag = self::save($data,['wo_id' => $wo_id]);
            return $flag;
        }
    }
    /**
     * 获取日期内统计数据
     */
    public function getCount($type = '',$star_time = '',$end_time = ''){
        $data = [];
        switch ($type){
            case '1':
                $data = self::where('gid = '.Session::get('user')->gid.' and add_time between '.$star_time.' and '.$end_time)->count();
                break;
            case '2':
                $data = self::where('gid = '.Session::get('user')->gid.' and comple_time between '.$star_time.' and '.$end_time)->count();
                break;
        }
        return $data;
    }
    /**
     * 获取用户的工单
     */
    public function getMyOrder($uid,$limit){
        if (!empty($limit)){
            $limit = '0 , '.$limit;
        }else{
            $limit = '';
        }
        $list = self::alias('a')
                ->field('a.*,b.nick_name as jour_name')
                ->join('users b','a.jour_id = b.uid')
                ->where('add_uid ='.$uid.' or a.uid ='.$uid)->limit($limit)->select();
        return $list;
    }
    /**
     * 获取用户创建人
     */
    public function getAddList($where)
    {
        $list = self::
                alias('a')
                ->field('b.*')
                ->join('users b','a.add_uid = b.uid')
                ->where($where)
                ->group('b.uid')
                ->select();
        return $list;
    }
}

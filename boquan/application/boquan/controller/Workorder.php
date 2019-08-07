<?php

namespace app\boquan\controller;

use think\Loader;
use think\Session;

/**
 *  Workorder
 * 工单状态列表
 * 1:工单池内
 * 2:待指派
 * 3:已指派
 * 4:已接受
 * 5:已完成
 * 6:回访
 * 7:已关闭
 * 8:待抢单
 * 10:待审核
 * 11：故障申报
 */
class Workorder extends Index
{
    /**
     * 故障申报
     */
    public function declares()
    {
        $res = array('code' => 2,'msg' => '失败');
        if($_POST){
            if(!empty($_POST['wid']) && !empty($_POST['desc'])){
                $where['wo_id'] = $_POST['wid'];
                $data['status'] = 11;
                $data['zid'] = Session('user')->pid;
                $work = model('WorkOrders','model');
                $arr = [];
                if(!empty($_POST['img'])){
                    $arr = explode(' - ',$_POST['img']);      // 拿到base64 格式字符串，根据 - 进行切割
                }
                if($work->save($data,$where)){
                    $log = model('WorkLog', 'logic');
                    $str = Session('user')->rela_name . '故障上报 工单号 #' . $work->get($_POST['wid'])->wo_sn."\n".
                    "故障描述：".$_POST['desc']."\n".
                    "图片：";
                    $up_dir = 'public/static' . DS . 'uploads/decl';
                    foreach ($arr as $key => $val){
                        $res = base_upload($up_dir,$val);
                        if($res['code'] == 1){
                            $str .= '<img src=\''.$res['url'].'\' width="50" height:50 />';
                        }
                    }
                    $log->WriteLog($str, $_POST['wid'], 13);
                    $res = array('code' => 1,'msg' => '申报成功');
                }
            }
        }
        return $res;
    }
    /**
     *  工单池
     */
    public function workorder_all()
    {
        return view();
    }
    /**
     *  工单列表
     */
    public function workorder_list()
    {
        $where = [];
        $status = '';
        $pagesize = 10;
        if(!empty($_GET['status'])){
            $status = $_GET['status'];
        }
        if (!empty($_GET['pagesize'])){
            $pagesize = $_GET['pagesize'];
        }
        $work = model('WorkOrders','logic');
        $list = $work->getStatusData($status,$where);
        $this->assign('list',$list['list']);
        $this->assign('page',$list);
        $this->assign('pagesize',$pagesize);
        return view();
    }
    /**
     * 待指派工单
     */
    public function workorder_tobe()
    {
        return view();
    }
    /**
     *  已完成工单
     */
    public function workorder_completed()
    {
        return view();
    }
    /**
     *  回访工单
     */
    public function workorder_back()
    {
        return view();
    }
    /**
     *  关闭工单
     */
    public function workorder_close()
    {
        return view();
    }
    /**
     * 工单详情
     */
    public function workorder_details()
    {
        if (!empty($_GET['wid'])){
            $order = model('WorkOrders','model');
            $info = $order->getWorkInfo($_GET['wid']);
            if(empty($info)){
               $this->redirect('workorder/workorder_list');
            }
            setcookie('wid',$_GET['wid']);
            $parts = model('Parts','model');
            $services = model('Services','model');
            $rece = model('WorkReceipt','model');
            $list = $parts->where('p_count > 0 and gid ='.Session('user')->gid)->select();
            $serverlist = $services->where('gid = '.Session('user')->gid)->select();
            $reinfo = $rece->where('wo_id = '.$_GET['wid'])->find();      // 获取当前工单的回执信息
//            echo $rece->getLastSql();
            if(!empty($reinfo)){
                if(!empty($reinfo->ago_img)){
                    $str = substr($reinfo->ago_img,1);         // 获取维修前图片，展示
                }
                if(!empty($reinfo->back_img)){
                    $str1 = substr($reinfo->back_img,1);         // 获取维修前图片，展示
                }
                $agoimg = explode(',',$str);
                $backimg = explode(',',$str1);
                $reinfo->back_img = $backimg;
                $reinfo->ago_img = $agoimg;
                // 根据填写的备件ID 列出备件详情
                $part = json_decode($reinfo->parts_desc,true);
                $arr = [];
                $brr = [];
                if(!empty($part)){
                    foreach ($part as $key => $val){
                        $arr['parinfo'][$key] = @$parts->where('id = '.$val['id'])->find()->toArray();
                        $arr['parinfo'][$key]['num'] = $val['num'];
                    }
                    $reinfo->parts_desc = $arr;
                }
                // 根据填写的服务信息 列出服务详情
                $ser = json_decode($reinfo->server_desc,true);
                if (!empty($ser)){
                    foreach ($ser as $key => $val){
                        $brr[$key] = @$services->where('id = '.$val['id'])->find()->toArray();
                        $brr[$key]['num'] = $val['num'];
                    }
                    $reinfo->server_desc = $brr;
            }
                $this->assign('reinfo',$reinfo);
            }
            $this->assign('serverlist',$serverlist);
            $this->assign('parlist',$list);
            $this->assign('info',$info);
        }else{
            $this->error('缺少ID');
        }
        $role = model('Role','logic');
        $rinfo = $role->get(Session('user')->rid);
        $marr = explode(',',$rinfo->mid);
        $this->assign('rinfo',$marr);
        return view();
    }
    /**
     * 新建工单
     */
    public function workorder_new()
    {
//        $user = model('Users','model');
        $client = model('Client','model');
//        $clist = $client->where('gid ='.Session('user')->gid)->select();
        $service = model('Services','model');
        $server = $service->where('gid ='.Session('user')->gid)->select();
//        $clist = $user->where('rid = 2')->select();
//        $this->assign('clist',$clist);
        $this->assign('server',$server);
        return view();
    }
    /**
     * 新增工单处理
     */
    public function add_work()
    {
        $res = array('code' => 2,'msg' => '失败');
        if ($_POST) {
            $data = $_POST;
            $data['wo_sn'] = date('ymdHis'). rand(10, 99);
            $data['plan_time'] = strtotime($data['plan_time']);
            $data['add_time'] = time();
            $data['status'] = 2;
            $data['type'] = 2;
            $data['add_uid'] = Session('user')->uid;
            $workorder = model('WorkOrders', 'model');
            $validate = validate('WorkOrders');
            if ($validate->check($data)) {
                if(Session('user')->pid == 1){
                    $data['zid'] = Session('user')->gid;
                }
                if ($workorder->allowField(true)->save($data)) {
                    $log = model('WorkLog', 'logic');
                    $str = Session('user')->rela_name . '新建了工单 #' . $data['wo_sn'];
                    $insid = $workorder->getLastInsID();
                    $log->WriteLog($str, $insid, 1);
                    $res = array('code' => 1 ,'msg' => '添加成功' ,'wid' => $insid);
                }
            }else{
                $res = array('code' =>2 ,'msg' => $validate->getError());
            }
        }
        return $res;
    }
    /**
     * 获取客户地址
     */
    public function getAdd()
    {
        if ($_POST){
            if(!empty($_POST['uid'])){
                $client = model('Client','model');
                $uinfo = $client->field('client_tel,client_address')->find($_POST['uid']);
                return $uinfo;
            }
        }
    }
    /**
     *  获取工单列表
     */
    public function getWorkList()
    {
        $arr = [];
        if (input('post.')) {
            if (!empty(input('post.status')) && !empty(input('post.page')) && !empty(input('post.pagesize'))) {
                $workorder = model('WorkOrders', 'logic');
                $where = [];
                if (!empty($_POST['wo_sn'])) {
                    $where['wo_sn'] = input('post.wo_sn');
                }
                if(!empty($_POST['pid'])){
                    $where['pid'] = input('post.pid');
                }
                if(!empty($_POST['createtime'])){
                    $where['createtime'] = input('post.createtime');
                }
                $list = $workorder->getStatusData2(input('post.status'), $where);
                foreach ($list as $key => $val) {
                    $arr[$key] = $val->toArray();
                    $arr[$key]['url'] = url('workorder/workorder_details',array('wid' => $val['wo_id']));
                }
                $arr =array_splice($arr, (input('post.page') - 1) * input('post.pagesize'), input('post.pagesize'));
                if (!empty($arr)) {
                    $res = array('code' => 1, 'data' => $arr, 'count' => count($list), 'countpage' => ceil(count($list) / input('post.pagesize')));
                } else {
                    $res = array('code' => 2, 'msg' => '暂无数据');
                }
                return $res;
            }
        }
    }
    /**
     * 指派工单
     */
    public function designate()
    {
        // 需要负责人ID 和工单编号
        $role = model('Role', 'logic');
        $depart['list'] = $role->getDerpart(Session('user')->gid);                                  #获取部门列表
        $depart['title'] = db('user_group')->where('gid =' . Session('user')->gid)->find()['gname'];  #获取名称
        $workorder = model('WorkOrders', 'logic');
        $users = model('users', 'model');
        if ($_POST) {
            if ($workorder->setStatus($_POST)) {
                $log = Loader::model('WorkLog', 'logic');
                $str = Session('user')->rela_name . '把工单' . $workorder->get($_POST['wo_id'])->wo_sn . '指派给' .$users->getUserInfo($_POST['uid'])->rela_name;
                $log->WriteLog($str, $_POST['wo_id'], 2);
                $this->success('指派成功', url('workorder/work_list', array('status' => 3)));
            }
        }
        $this->assign('depart', $depart);
        return view();
    }
    /**
     * 回访工单并关闭工单
     */
    public function SubFeedB()
    {
        #需要满意度 satisfaction。 工单号wo_id， 和反馈feedback
        $res = array('code' => 2 ,'msg' => '失败');
        if ($_POST) {             //接收到回访请求
            $workorder = model('WorkOrders', 'logic');
            if ($workorder->VisitWork($_POST)) {    // 把工单关闭。并不进行处理。
                $log = model('WorkLog', 'logic');
                // 把工单状态写入日志
                if($_POST['satisfaction'] == 1){
                    $satisfaction = '不满意';
                }else if ($_POST['satisfaction'] == 2){
                    $satisfaction = '满意';
                }else{
                    $satisfaction = '非常满意';
                }
                $str = Session('user')->rela_name . '回访并关闭了工单' . $workorder->get($_POST['wo_id'])->wo_sn."\n
                满意度：{$satisfaction}\n客户反馈：{$_POST['feedback']}";
                $log->WriteLog($str, $_POST['wo_id'], 9);
                $res = array('code' => 1 ,'msg' => '成功');
            }
        }
        return $res;
    }
    /**
     * 在工单池内接单
     */
    public function set_take()
    {
        $res = array('code' => 2, 'msg' => '失败');
        if ($_POST) {
            if (!empty($_POST['wo_id'])) {
                $order = model('WorkOrders', 'model');
                $where['wo_id'] = $_POST['wo_id'];
                $data['status'] = 2;
                $data['is_take'] = 1;
                $data['type'] = 2;
                $data['gid'] = Session('user')->gid;
                if ($order->save($data, $where)) {
                    $log = Loader::model('WorkLog', 'logic');
                    $str = Session('user')->rela_name . '从工单池接取工单   #' . $order->get($_POST['wo_id'])->wo_sn;
                    $log->WriteLog($str, $_POST['wo_id'], 11);
                    $res = array('code' => 1, 'msg' => '接单成功');
                }
            }
        }
        return $res;
    }
    public function dispath()
    {
        if(!empty($_GET['wid'])){
            $wid = $_GET['wid'];
            $this->assign('wid',$wid);
        }
        $group = model('UserGroup','logic');
        $list = $group->getAllGroupRole(Session('user')->gid);
        $this->assign('list',$list);

        return view();
    }
    /**
     *  获取角色下用户
     */
    public function getRoleUser()
    {
        $res = array('code' => 2 , 'msg' => '暂无数据');
        if($_POST){
            if(!empty($_POST['rid'])){
                $rid = $_POST['rid'];
                $user = model('Users','model');
                $list = $user->where('rid = '.$rid .' and gid ='.Session('user')->gid)->select();
                if (!empty($list)){
                    $res = array('code' => 1,'data' => $list);
                }
            }
        }
        return $res;
    }
    /**
     * 派单
     */
    public function dispath_handle()
    {
        $res = array('code' => 2, 'msg' => '缺少参数');
        if ($_POST) {
            if (!empty($_POST['wid']) && !empty($_POST['type'])) {
                $order = model('WorkOrders', 'model');
                $user = model('users', 'model');
                $log = model('WorkLog', 'logic');
                $type = $_POST['type'];
                $data['status'] = 3;
                $where['wo_id'] = $_POST['wid'];
                if ($type == 1){
                    $data['status'] = 1;
                    $str = Session('user')->rela_name .'把工单    #'. $order->get($_POST['wid'])->wo_sn.'指派到了工单池';
                }else{
                    if(!empty($_POST['uid'])){
                        $data['uid'] = $_POST['uid'];
                        $data['ass_id'] = Session('user')->uid;      //指派人ID
                        $data['ass_time'] = time();
                        $str = Session('user')->rela_name . '把工单   #' . $order->get($_POST['wid'])->wo_sn . '指派给了' . $user->get($_POST['uid'])->rela_name;
                    }else{
                        return $res;
                    }
                }
                if ($order->save($data,$where)){
                    $log->WriteLog($str, $_POST['wid'], 2);
                    $res = array('code' => 1, 'msg' => '指派成功');
                }
            }
        }
        return $res;
    }
//    /**
//     * 接受工单
//     */
//    public function accept_work()
//    {
//        $res = array('code' => 2,'msg' => '失败');
//        if ($_POST){
//            if (!empty($_POST['wo_id'])){      //接收到接受请求的工单编号
//                $order = model('WorkOrders','model');
//                $where['wo_id'] = $_POST['wo_id'];
//                $data['status'] = 4;           // 将工单状态改为4(已接受)
//                if ($order->save($data,$where)){
//                    $log = model('WorkLog','logic');
//                    // 将工单状态写入当前工单日志
//                    $str = Session('user')->user_name . '接受了工单    #'.$order->get($_POST['wo_id'])->wo_sn;
//                    $log->WriteLog($str,$_POST['wo_id'],4);
//                    $res = array('code' => 1,'msg' => '接受成功');
//                }
//            }
//        }
//        return $res;
//    }
    /**
     * 完成工单
     */
    public function ComOrder(){
        $res = array('code' => 2 ,'msg' => '失败');
        if ($_POST){
            if (!empty($_POST['wo_id'])){       // 接收到完成工单的请求工单ID
                $order = model('WorkOrders','model');
                $where['wo_id'] = $_POST['wo_id'];
                $data['status'] = 5;           // 将工单状态改为5（已完成）
                $data['comple_time'] = time(); // 将完成时间设为当前时间
                if ($order->save($data,$where)){
                    $log = model('WorkLog','logic');
                    // 将工单状态写入日志
                    $str = Session('user')->rela_name . '完成了工单    #'.$order->get($_POST['wo_id'])->wo_sn;
                    $log->WriteLog($str,$_POST['wo_id'],7);
                    $res = array('code' => 1 , 'msg' => '完成成功');
                }
            }
        }
        return $res;
    }
    /**
     * 确认已付款 进入回访
     */
    public function comple_pay()
    {
        $res = array('code' => 2,'msg' => '失败');
        if ($_POST){
            if (!empty($_POST['wo_id'])){           //接收到结算请求
                $order = model('WorkOrders','model');
                $fund = model('Funds','logic');
                $where['wo_id'] = $_POST['wo_id'];
                $data['status'] = 6;                // 将工单状态改为6（待回访）
                if ($order->save($data,$where)){
                    if($fund->saveData($_POST['wo_id'])){   //将工单内的产品费用+服务费用存入应收列表
                        $log = model('WorkLog','logic');
                        // 将工单状态存入对应的日志
                        $str = Session('user')->rela_name. '结算了工单   #'.$order->get($_POST['wo_id'])->wo_sn;
                        $log->WriteLog($str,$_POST['wo_id'],7);
                        $res = array('code' => 2 , 'msg' => '结算成功');
                    }
                }
            }
        }
        return $res;
    }
    /**
     * 获取工单日志
     */
    public function getworkstatus(){
        $list = [];
        $page_size = 5;
        if ($_POST){
            $worklog = model('WorkLog','logic');
            $list = $worklog->getWorkList(cookie('wid'));
            foreach ($list as $key => $val){
                $list[$key]->add_time = date('Y-m-d H:i:s',$val->add_time);
            }
            $list = array_splice($list,($_POST['currpage']-1)*$page_size,$page_size);

            if(!empty($list)){
                $res = array('code' => 1,'data' => $list);
            }else{
                $res = array('code' => 2,'msg' => '沒有了');
            }
            return $res;
        }
    }
    /**
     * 司机指定服务商 服务商接取工单，或者拒绝工单，拒绝的工单在工单池内
     */
    public function TakeOrder()
    {
        $res = array('code' => 2,'msg' => '失败');
        if ($_POST){
            if(!empty($_POST['wo_id']) && !empty($_POST['type'])){
                $work_order = model('WorkOrders','model');
                $userlog = model('UserLog','model');
                $usergroup = model('UserGroup','logic');
                $type = $_POST['type'];
                $wo_id = $_POST['wo_id'];
                $info = $work_order->get($_POST['wo_id']);
                $uid = $info->jour_id;
                if($type == 1){
                    $str = $usergroup->get(Session('user')->gid)->gname.'已接单';
                    if($userlog->WriteLog($str,$uid)){
                        $ret = $work_order->save(['is_take' => 1],['wo_id' => $wo_id]);
                        $msg = '接单成功';
                    }
                }else{
                    $str = $usergroup->get(Session('user')->gid)->gname.'已拒绝';
                    if($userlog->WriteLog($str,$uid)){
                        $ret = $work_order::destroy($wo_id);
                        $msg = '拒绝成功,订单已删除';
                    }
                }
                if ($ret){
                    $res = array('code' =>1,'msg' => $msg);
                }
            }
        }
        return $res;
    }
    /**
     * 拒绝工单
     */
    public function RefuseWork()
    {
        $res = array('code' => 2,'msg' => '失败');
        $order = model('WorkOrders','logic');
        $data['refuse_reason'] = $_POST['refuse_reason'];
        $data['uid'] = 0;         //接收到拒绝请求，把负责人ID改为0
        $data['status'] = 2;      // 工单状态改为2(待指派)
        $where['wo_id'] = $_POST['wo_id'];
        if($order->save($data,$where)){
            $log = model('WorkLog','logic');
            //把拒绝工单理由写入日志
            $str = Session('user')->rela_name. '拒绝了工单   #'.$order->get($_POST['wo_id'])->wo_sn.' 拒绝理由：'.$data['refuse_reason'];
            $log->WriteLog($str,$_POST['wo_id'],7);
            $res = array('code' => 1 ,'msg' => '拒绝成功');
        }
        return $res;
    }
    /**
     * 取消工单
     */
    public function OffTake()
    {
        $res = array('code' => 2 ,'msg' => '失败');
        if ($_POST){
            if(!empty($_POST['wo_id'])){
                $where['wo_id'] = $_POST['wo_id'];
                $order = model('WorkOrders','model');
//                $data['is_del'] = 1;
                if($order->where($where)->delete()){
                    $res = array('code' => 1 ,'msg' => '取消成功');
                }
            }
        }
        return $res;
    }
    /**
     * 添加备注
     */
    public function SetRemark()
    {
        $res = array('code' => 2,'msg' => '添加失败');
        $log = model('WorkLog','logic');
        $wo_id = $_POST['wid'];
        $str = Session('user')->rela_name.'添加了备注：'.$_POST['remark'];
        if($log->WriteLog($str,$wo_id,12)){
            $res = array('code' => 1,'msg' => '添加成功');
        }
        return $res;
    }
    /**
     * 获取申请信息
     */
    public function getApply()
    {
        $res = array('code' => 2,'msg' => '暂无信息');
        if ($_POST){
            if (!empty($_POST['wid'])){
                $sendcar = model('SendCar','model');
//                $info = $sendcar->where('wo_id ='.$_POST['wid'])->find();
                $info = $sendcar->getInfo($_POST['wid']);
                $str = '<table class="table table-hover" style="text-align: center;">';
                $str .= '<tr><td>申请ID：</td><td>'.$info['send_id'].'</td></tr>';
                $str .= '<tr><td>工单编号：</td><td>'.$info['wo_sn'].'</td></tr>';
                $str .= '<tr><td>申请人姓名：</td><td>'.$info['appername'].'</td></tr>';
                $str .= '<tr><td>派车类型：</td><td>'.$info['travel_type'].'</td></tr>';
                $str .= '<tr><td>起始地点：</td><td>'.$info['star_add'].'</td></tr>';
                $str .= '<tr><td>服务地点：</td><td>'.$info['server_add'].'</td></tr>';
                $str .= '<tr><td>千米数：</td><td>'.$info['km_num'].'</td></tr>';
                $str .= '<tr><td>出行时间：</td><td>'.$info['out_time'].'</td></tr>';
                $str .= '<tr><td>出行人数：</td><td>'.$info['out_num'].'</td></tr>';
                $str .= '<tr><td>交通费标准：</td><td>'.$info['car_fare'].'</td></tr>';
                $str .= '<tr><td>交通费：</td><td>'.$info['price'].'</td></tr>';
                $str .= '<tr><td>状态：</td><td>'.$info['status'].'</td></tr>';
                $str .= '<tr><td>申请时间：</td><td>'.$info['add_time'].'</td></tr>';
                $str .= '</table>';
                if(!empty($info)){
                    $res = array('code' => 1,'data' => $str);
                }
            }
        }
        return $res;
    }
    /**
     * 获取住宿申请
     */
    public function getStayApply()
    {
        $res = array('code' => 2,'msg' => '暂无信息');
        if ($_POST){
            if (!empty($_POST['wid'])){
                $stayapp = model('StayApply','model');
//                $info = $sendcar->where('wo_id ='.$_POST['wid'])->find();
                $info = $stayapp->getInfo($_POST['wid']);
                $str = '<table class="table table-hover" style="text-align: center;">';
                $str .= '<tr><td>申请ID：</td><td>'.$info['sapp_id'].'</td></tr>';
                $str .= '<tr><td>工单编号：</td><td>'.$info['wo_sn'].'</td></tr>';
                $str .= '<tr><td>申请人姓名：</td><td>'.$info['appername'].'</td></tr>';
                $str .= '<tr><td>申请理由：</td><td>'.$info['apply_reason'].'</td></tr>';
                $str .= '<tr><td>申请天数：</td><td>'.$info['apply_num'].'</td></tr>';
                $str .= '<tr><td>补贴标准：</td><td>'.$info['subsity'].'</td></tr>';
                $str .= '<tr><td>申请时间：</td><td>'.$info['add_time'].'</td></tr>';
                $str .= '</table>';
                if(!empty($info)){
                    $res = array('code' => 1,'data' => $str);
                }
            }
        }
        return $res;
    }
    /**
     * 获取客户列表
     */
    public function getCustom()
    {
        $arr = [];
        // 判断身份搜索数据
        $where = '';
        if(Session('user')->pid == 1){
            // 主机厂
            if(!empty($_GET['keyword'])){
                $where = ' and gname like %'.$_GET['keyword'].'%';
            }
            $group = model('UserGroup');
            $list = $group->where('find_in_set(\''.Session('user')->gid.'\',pid)'.$where)->select();
            
        }else{
            // 服务站
            if(!empty($_POST['keyword'])){
                $where = ' and client_name like %'.$_GET['keyword'].'%';
            }
            $custom = model('Client');
            $list = $custom
                ->field('id as gid,client_name as gname ,client_tel as tel,client_address as address,gid as zid')
                ->where('gid ='.Session('user')->gid.$where)
                ->select();
                // echo $custom->getLastSql();
        }
        $arr['list'] = $list;
        // 以下是搜索客户列表
//         if(!empty($_GET['keyword'])){
//             $client = model('Client','model');
// //            $user = model('Users','model');
//             $where['client_name'] = ['like','%'.$_GET['keyword'].'%'];
//             $arr['list'] = $client->where($where)->select();
//         }
        return $arr;
    }
    /**
     * 获取搜索的产品列表
     */
    public function getProduct()
    {
        if(!empty($_GET['keyword'])){
            $parts = model('Parts','model');
            $list['list'] = $parts->where('product_number REGEXP \''.$_GET['keyword'].'\'')->select();
            return $list;
        }
    }
    /**
     * 获取创建人ID
     */
    public function getAddUser()
    {
        if (!empty($_GET['keyword'])){
            $order = model('WorkOrders','logic');
            $where['user_name'] = ['like','%'.$_GET['keyword'].'%'];
            $list['list'] = $order->getAddList($where);
            return $list;
        }
    }
    /**
     * 搜索员工
     */
    public function SearchKey()
    {
        $res = array('code' => 2 ,'msg' => '失败');
        if($_POST){
            if(!empty($_POST['keyword'])){
                $keyword = $_POST['keyword'];
                $user = model('Users','model');
                $list = $user->getSearchUser($keyword);
                if(!empty($list)){
                    $res = array('code' => 1,'data' => $list);
                }
            }
        }
        return $res;
    }
    /**
     * 审核通过或者拒绝
     */
    public function setAud()
    {
        $res = array('code' => 2,'msg' => '失败');
        if($_POST){
            if(!empty($_POST['aud_status'])){
                $send = model('SendCar','model');
                if($send->where('wo_id ='.$_POST['wo_id'])->update(['status' => $_POST['aud_status']])){
                    $res = array('code' => 1,'msg' => '成功');
                }
            }
        }
        return $res;
    }
    /**
     * 审核拒绝住宿申请
     */
    public function setAud2()
    {
        $res = array('code' => 2,'msg' => '失败');
        if($_POST){
            if(!empty($_POST['aud_status'])){
                $send = model('StayApply','model');
                if($send->where('wo_id ='.$_POST['wo_id'])->update(['status' => $_POST['aud_status']])){
                    $res = array('code' => 1,'msg' => '成功');
                }
            }
        }
        return $res;
    }
    /**
     * 抢单
     */
    public function glabsingle()
    {

        return view();
    }
    /**
     * 处理抢单
     */
    public function GlabS()
    {
        $res = array('code' => 2,'msg' => '失败');
        if($_POST){
            if(!empty($_POST['wo_id'])){
                $order = model('WorkOrders','model');
                $edit = $order->where('wo_id ='.$_POST['wo_id'])->find();
                if($edit->gid == 0 || $edit->gid == ''){
                    $data['status'] = 1;
                    $data['gid'] = Session('user')->gid;
                    $where['wo_id'] = $_POST['wo_id'];
                    if($order->save($data,$where)){
                        $res = array('code' => 1,'msg' => '抢单成功');
                    }
                }else{
                    $res = array('code' => 2,'msg' => '工单已经被抢单');
                }
            }
        }
        return $res;
    }
    /**
     * 维修工接单
     */
    public function AcceptWork()
    {
        $res = array('code' => 2 ,'msg' => '失败');
        if($_POST){
            if(!empty($_POST['plan_time']) && !empty($_POST['wo_id'])){
                $order = model("WorkOrders",'model');
                $log = model('WorkLog','logic');
                $data['status'] = 4;
                $data['plan_time'] = strtotime($_POST['plan_time']);
                $where['wo_id'] = $_POST['wo_id'];
                if($order->save($data,$where)){
                    $str = Session('user')->rela_name . '接受了工单    #'.$order->get($_POST['wo_id'])->wo_sn;
                    $log->WriteLog($str,$_POST['wo_id'],4);
                    $res = array('code' => 1,'msg' => '接受成功');
                }
            }
        }
        return $res;
    }
    /**
     * 维修工拒绝工单
     */
    public function RefuseOrder()
    {
        $res = array('code' => 2,'msg' => '失败');
        if($_POST){
            if(!empty($_POST['wo_id'])){
                $order = model('WorkOrders','model');
                $log = model('WorkLog','logic');
                $data['status'] = 2;
                $data['uid'] = 0;
                $where['wo_id'] = $_POST['wo_id'];
                if($order->save($data,$where)){
                    $str = Session('user')->rela_name . '拒绝了工单    #'.$order->get($_POST['wo_id'])->wo_sn;
                    $log->WriteLog($str,$_POST['wo_id'],4);
                    $res = array('code' => 1,'msg' => '拒绝成功');
                }
            }
        }
        return $res;
    }
    /**
     * 维修工开始工作
     */
    // public function StartWork()
    // {
    //     $res = array('code' => 2,'msg' => '失败');
    //     if ($_POST){
    //         if(!empty($_POST['wo_id'])){
    //             $order = model('WorkOrders','model');
    //             $log = model('WorkLog','logic');
    //             $data['status'] = 9;
    //             $where['wo_id'] = $_POST['wo_id'];
    //             if ($order->save($data,$where)){
    //                 $str = Session('user')->rela_name .'开始工作 工单号   #'.$order->get($_POST['wo_id'])->wo_sn;
    //                 $log->WriteLog($str,$_POST['wo_id'],6);
    //                 $res = array('code' => 1,'msg' => '开始工作');
    //             }
    //         }
    //     }
    //     return $res;
    // }
    /**
     * UploadFile
     */
    public function UploadFile()
    {
        $res = array('code' => 2,'msg' => '上传失败');
        $files = request()->file('file');
        $fileorder = model('WorkorderImg','model');
        if(!empty($_GET['wid'])){
            foreach($files as $key => $file){
                // 移动到框架应用根目录/public/uploads/ 目录下
                $info = $file->move(ROOT_PATH . 'public/static' . DS . 'upload/workorder');
                if($info){
                    $data['file_url'] = 'static/upload/workorder/'.$info->getSaveName();
                    $data['file_name'] = $info->getFilename();
                    $data['wo_id'] = $_GET['wid'];
                    if($fileorder->save($data)){
                        $res = array('code' => 1 ,'msg' => '上传成功');
                    }
                }else{
                    // 上传失败获取错误信息
                    $res = array('code' => 1 ,'msg' => $file->getError());
                }
            }
        }
        return $res;
    }
    /**
     * 获取配件详情
     */
    public function getParInfo()
    {
        $res = array('code' => 2,'msg' => '暂无数据');
        if($_POST){
            if(!empty($_POST['parid'])){
                $parts = model('Parts','model');
                $info = $parts->get($_POST['parid']);
                if(!empty($info)){
                    $res  = array('code' => 1,'data' => $info);
                }
            }
        }
        return $res;
    }
    /**
     * 获取服务详情
     */
    public function getServerInfo()
    {
        $res = array('code' => 2,'msg' => '暂无数据');
        if($_POST){
            if(!empty($_POST['sid'])){
                $server = model('Services','model');
                $info = $server->get($_POST['sid']);
                if(!empty($info)){
                    $res = array('code' => 1,'data' => $info);
                }
            }
        }
        return $res;
    }
    /**
     * 添加回执
     */
    public function SubRece()
    {
        $res = array('code' => 2,'msg' => '失败');
        if($_POST){
            if(!empty($_POST['backimg']) && !empty($_POST['agoimg'])){
                $flag = false;
                $ago = $_POST['agoimg'];
                $back = $_POST['backimg'];
                $arr = explode(' - ',$ago);      // 拿到base64 格式字符串，根据 - 进行切割
                $brr = explode(' - ',$back);
                $data['ago_img'] = '';
                $data['back_img'] = '';
                $up_dir = ROOT_PATH . 'public/static' . DS . 'uploads/order';
                foreach ($arr as $key => $val){
                    $res = base_upload($up_dir,$val);
                    if($res['code'] == 1){
                        $data['ago_img'] .= ','.$res['url'];
                    }
                }
                foreach ($brr as $key => $val){
                    $res = base_upload($up_dir,$val);
                    if($res['code'] == 1){
                        $data['back_img'] .= ','.$res['url'];
                    }
                }
                unset($_POST['agoimg']);unset($_POST['backimg']);
                if(!empty($_POST['proinfo'])){
                    $data['parts_desc'] = json_encode($_POST['proinfo']);
                }
                if(!empty($_POST['sinfo'])){
                    $data['server_desc'] = json_encode($_POST['sinfo']);
                }
                if(!empty($_POST['total'])){
                    $data['totalprice'] = $_POST['total'];
                }
                if(!empty($_POST['wid'])){
                    $data['wo_id'] = $_POST['wid'];
                }
                if(!empty($_POST['discount'])){
                    $data['discount'] = $_POST['discount'];
                }
                $receipt = model('WorkReceipt','model');
                $log = model('WorkLog','logic');
                $order = model('WorkOrders','model');
                $have = $receipt->where('wo_id ='.$_POST['wid'])->find();
                if(!empty($_POST['reid']) || !empty($have)){
                    if($receipt->allowField(true)->save($data,['reid' => !empty($_POST['reid'])?$_POST['reid']:$have->reid])){
                        $flag = true;
                        $wdata['status'] = 10;
                        $order->allowField(true)->save($wdata,['wo_id' => $_POST['wid']]);
                        $str = Session('user')->rela_name .'编辑了回执 #'.$order->get($_POST['wid'])->wo_sn;
                        $log->WriteLog($str,$_POST['wid'],13);
                    }
                }else{
                    if($receipt->allowField(true)->save($data)){
                        $str = Session('user')->rela_name .'填写了回执 #'.$order->get($_POST['wid'])->wo_sn;
                        $log->WriteLog($str,$_POST['wid'],13);
                        $wdata['status'] = 10;
                        $order->allowField(true)->save($wdata,['wo_id' => $_POST['wid']]);
                        $adata['type'] = 1;
                        $adata['rela_id'] = $_POST['wid'];
                        $adata['gid'] = Session('user')->gid;
                        $adata['table'] = 'work_orders';
                        $adata['status'] = 1;
                        $adata['add_time'] = time();
                        // 存入审核列表数据
                        $aud = model('AudList','model');
                        $aud->save($adata);
                        // 生成应收记录
//                        exit;
                        $flag = true;
                    }
                }
                if($flag){
                    $res = array('code' => 1,'msg' => '成功');
                }
            }
        }
        return $res;
    }
    /**
     * 审核
     */
    public function AudSett()
    {
        $res = array('code' => 2,'msg' => '失败');
        if ($_POST){
            if (!empty($_POST['wid']) && !empty($_POST['type'])){
                $order = model('WorkOrders','model');
                $log = model('WorkLog','logic');
                $data['status'] = 6;
                $where['wo_id'] = $_POST['wid'];
                $aud = model('AudList','model');
                if($_POST['type'] == 1){
                    $status = 6;
                }else{
                    $status = 5;
                }
                $aud->where('rela_id ='.$_POST['wid'] .' and `table` = \'work_orders\'')->update(['status' => $status]);
                if($_POST['type'] == 2){
                    unset($data['type']);
                    $str = Session('user')->rela_name .'驳回了工单   #'.$order->get($_POST['wid'])->wo_sn;
                }else{
                    $str = Session('user')->rela_name .'审核结算了工单   #'.$order->get($_POST['wid'])->wo_sn;
                    $oinfo = $order->getWorkInfo($_POST['wid']);
                    $fund = model('Funds','logic');
                    $workrece = model('WorkReceipt','model');
                    $fdata['wo_id'] = $order->get($_POST['wid'])->wo_sn;
                    $fdata['billt_time'] = time();
                    $fdata['custom_id'] = !empty($oinfo->jour_name)?$oinfo->jour_name:$oinfo->cus_name;
                    $fdata['must_bill_price'] = $workrece->where('wo_id = '.$_POST['wid'])->find()['totalprice'];
                    $fdata['handle_time'] = time();
                    $fdata['add_time'] = time();
                    $fdata['status'] = 2;
                    $fdata['fund_status'] = 1;
                    $fund->save($fdata);
                }
                $log->WriteLog($str,$_POST['wid'],8);
                if($order->save($data,$where)){
                    $res = array('code' => 1,'msg' => '成功');
                }
            }
        }
        return $res;
    }
    /**
     * 返回解决方案
     */
    public function AddPromshe()
    {
        $res = array('code' => 2,'msg' => '失败');
        if ($_POST){
            if(!empty($_POST['wo_id']) && !empty($_POST['promeshen'])){
                $where['wo_id'] = $_POST['wo_id'];
                $data['promeshen'] = $_POST['promeshen'];
                $data['zid'] = 0;
                $data['status'] = 9;
                $order = model('WorkOrders','model');
                $log = model('WorkLog','logic');
                if($order->save($data,$where)){
                    $str = Session('user')->rela_name ."工单号\t #".$order->get($_POST['wo_id'])->wo_sn."填写了解决方案：".$_POST['promeshen'];
                    $log->WriteLog($str,$_POST['wo_id'],13);
                    $res = array('code' => 1,'msg' => '成功');
                }
            }
        }
        return $res;
    }
    /**
     * 添加派车申请
     */
    public function AddSendCar()
    {
        $res = array('code' => 2 , 'msg' => '失败');
        if ($_POST){
            $send = model('SendCar','model');
            $aud = model('AudList','model');
            $validate = Validate('SendCar');
            $_POST['apper'] = Session('user')->uid;
            $_POST['add_time'] = time();
            if($validate->check($_POST)){
                $log = model('WorkLog','logic');
                $order = model('WorkOrders','model');
                $have = $send->where('wo_id ='.$_POST['wid'])->find();
                if(empty($have)){
                    if($send->allowField(true)->save($_POST)){
                        $aud->saveData('send_car',$send->getLastInsID(),9);
                        $str = Session('user')->rela_name ."工单号\t \t #".$order->get($_POST['wo_id'])->wo_sn."填写了派车申请";
                        $log->WriteLog($str,$_POST['wo_id'],13);
                        $res = array('code' => 1 , 'msg' => '成功');
                    }
                }else{
                    $res = array('code' => 2 , 'msg' => '工单已有出车申请');
                }
            }else{
                $res['msg'] = $validate->getError();
            }
        }
        return $res;
    }
    /**
     * 添加住宿申请
     */
    public function AddStay()
    {
        $res = array('code' => 2 , 'msg' => '失败');
        if($_POST){
            $send = model('StayApply','model');
            $aud = model('AudList','model');
            $validate = Validate('StayApply');
            $_POST['wo_id'] = $_POST['wid'];
            $_POST['apply'] = Session('user')->uid;
            $_POST['add_time'] = time();
            $order = model('WorkOrders','model');
            if($validate->check($_POST)){
                $log = model('WorkLog','logic');
                $have = $send->where('wo_id = '.$_POST['wid'])->find();
                if(empty($have)){
                    if($send->allowField(true)->save($_POST)){
                        $aud->saveData('stay_apply',$send->getLastInsID(),10);
                        $str = Session('user')->rela_name ."工单号\t \t #".$order->get($_POST['wo_id'])->wo_sn."填写了住宿申请";
                        $log->WriteLog($str,$_POST['wo_id'],13);
                        $res = array('code' => 1, 'msg' => '成功');
                    }
                }else{
                    $res = array('code' => 2 , 'msg' => '工单已有住宿申请');
                }
            }else{
                $res['msg'] = $validate->getError();
            }
        }
        return $res;
    }
    /**
     * 导出工单
     */
    public function export_order()
    {
    	import('Classes.PHPExcel.PHPExcel',EXTEND_PATH);
    	$excel = new \PHPExcel();
    	$order = model('WorkOrders','model');
    	$excel->getProperties()->setCreator("转弯的阳光")
	          ->setLastModifiedBy("转弯的阳光")
	          ->setTitle("数据EXCEL导出")
	          ->setSubject("数据EXCEL导出")
	          ->setDescription("备份数据")
	          ->setKeywords("excel")
	          ->setCategory("result file");
    	$data = $order->all();
		foreach($data as $k => $v){
			$num = $k+1;
			$excel->setActiveSheetIndex(0)
				//Excel的第A列，uid是你查出数组的键值，下面以此类推
				->setCellValue('A'.$num, $v['wo_id'])
				->setCellValue('B'.$num, $v['wo_sn'])
				->setCellValue('C'.$num, $v['jour_id'])
				->setCellValue('D'.$num,$v['contact_info']);
		}
	    $excel->getActiveSheet()->setTitle(date('YmdHis'));
	    $excel->setActiveSheetIndex(0);
		$name = "561564564";
	    header('Content-type: application/vnd.ms-excel;charset=utf-8;name="' . $name . '.xls"');
	    header("Content-Disposition: attachment; filename=$name.xls");
		header('Cache-Control: max-age=0');
		//header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		//header ('Cache-Control: cache, must-revalidate');
		header ('Pragma: public');

		$objWriter = \PHPExcel_IOFactory::createWriter($excel, 'Excel5');
		$objWriter->save('php://output');
             exit;
    }
}

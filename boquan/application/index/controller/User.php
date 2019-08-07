<?php
/**
 * 用户管理
 */

namespace app\index\controller;


use think\Session;
use think\Db;
class User extends Index
{
    /**
     * 注册界面
     */
    public function reg()
    {

        return view();
    }
    /**
     * 注册
     */
    public function reg_handle()
    {
        $res = array('code' => 2, 'msg' => '失败');
        if ($_POST) {
            $users = model('Users','model');
            $data = $_POST;
            $res = $users->reg($data);
            return $res;
        }
        return $res;
    }
    /**
     * 登录界面
     */
    public function login()
    {

        return view();
    }
    /**
     * 登录操作
     */
    public function login_handle(){
        $res = array('code' => 2,'msg' => '登录失败');
        if ($_POST){
            if (!empty($_POST['mobile']) && !empty($_POST['password'])){
                $data = $_POST;
                $data['password'] = sysmd5($_POST['password']);
                $where = '';
                if ($_POST['mobile']){
                    $where .= 'user_name = \''.$_POST['mobile'].'\' or mobile =\''.$_POST['mobile'].'\'';
                }
                $user = model('Users','model');
                $info = $user->where($where)->find();
                if (!empty($info)){
                    Session('driver',$info);
                    $url = $user->getUrl($info->uid);
                    $res = array('code' => 1,'msg' => '登录成功' ,'url' => $url);
                }else{
                    $res = array('code' => 2,'msg' => '用户名或者密码不正确');
                }
            }else{
                $res = array('code' => 2,'msg' => '请填写表单');
            }
        }
        return jsonReturn($res);
    }
    /**
     * 主页
     */
    public function mainuser()
    {
        $server = [];
        $arr = getPos("114.88.143.169");      //$_SERVER['REMOTE_ADDR']
        $sql = "select * from bq_user_group where `lat` < ".$arr['maxLat'].' and `lat` > '.$arr['minLat']
            .' and `lng` > '.$arr['maxLng'].' and `lng` < '.$arr['minLng'] .' and pid != 1';
        $server['address'] = $arr['address'];
        $ret = db('user_group')->query($sql);
        foreach($ret as $key => $val){
            $ret[$key]['kmnum'] =sprintf('%.2f',calcDistance($val['lat'],$val['lng'],$arr['lat'],$arr['lng']));
        }
        $this->assign('near_server',$ret);
        $user = model('Users','model');
        $userlog = model('WorkLog','model');
        $common = $user->getCommonUse(Session('driver')->uid);
        $a = 0;
        $server['common'] = [];
        foreach ($common as $key => $val){
            if($key % 3 == 0){
                $a++;
            }
            $server['common'][$a][] = $val;
        }
        $server['car_info'] = $user->getCarInfo(Session('driver')->uid);
        $server['info'] = $user->get(Session('driver')->uid);
        $server['log_list'] = $userlog->alias('a')->field('a.desc,a.add_time')->join('work_orders b','a.wo_id = b.wo_id')
            ->where('b.jour_id = '.Session('driver')->uid.' and a.status < 7')->select();
//        echo $userlog->getLastSql();
//        $server['nearby'] = $group->getNearby();
        $server['logcount'] = $userlog->alias('a')->field('a.desc,a.add_time')->join('work_orders b','a.wo_id = b.wo_id')
            ->where('b.jour_id = '.Session('driver')->uid.' and a.status < 7 and is_read = 0')->count();
        $this->assign('server',$server);
        return view();
    }
    /**
     * 搜索用户组
     */
    public function getSearchGroup()
    {
        $res = array('code' => 2,'msg' => '暂无数据');
        if(!empty($_POST['keyword'])){
            $search_group = db('user_group')->where('gname REGEXP \''.$_POST['keyword'].'\'')->select();
            if(!empty($search_group)){
                $res = array('code' => 1,'data' => $search_group);
            }
        }
        return $res;
    }
    /**
     * 读取消息
     */
    public function ReadLog()
    {
        $res = array('code' => 2 ,'msg' => '读取失败');
        $data['is_read'] = 1;
        $userlog = model('WorkLog','model');

        if($userlog->alias('a')->join('work_orders b','a.wo_id = b.wo_id')
        ->where('b.jour_id = '.Session('driver')->uid.' and a.status < 7 and is_read = 0')->update($data)){
//            echo $userlog->getLastSql();
            $res = array('code' => 1,'msg' => '读取成功');
        }
        return $res;
    }
    /**
     *  mainrepair
     */
    public function mainrepair()
    {
        $workorder = model('WorkOrders','model');
        $wo_list['all'] = $workorder->getUserData(1);                //维修工全部工单
        $wo_list['wait_take'] = $workorder->getUserData(3);          //等待接受
        $wo_list['take'] = $workorder->getUserData(4);               // 已接受进行中
        $wo_list['comple'] = $workorder->getUserData(5);             // 已经完成
        $wo_list['send_apply'] = $workorder->getSendApply(Session('driver')->uid);
        $wo_list['stay_apply'] = $workorder->getStayApply(Session('driver')->uid);
        $this->assign('wo_list',$wo_list);
        return view();
    }

    /**
     *
     */
    public function mainmanagement()
    {
        $workorder = model('WorkOrders','model');
        $wo_list['grab'] = $workorder->getStatusData(1);
        $wo_list['take'] = $workorder->getStatusData(2);
        $wo_list['aleady'] = $workorder->getStatusData(3);
        $this->assign('wo_list',$wo_list);
        return view();
    }
    /**
     * 忘记密码
     */
    public function forget()
    {

        return view();
    }
    /**
     * 重置密码
     */
    public function setpwd()
    {
        if ($_POST){
            if (!empty($_POST['password']) && !empty($_POST['password2'])){
                $password = $_POST['password'];
                $password2 = $_POST['password2'];
                if ($password == $password2){
                    $user = model('Users','model');
                    $data['password'] = sysmd5($password);
                    $where['uid'] = Session('setpwd')->uid;
                    if($user->save($data,$where)){
                        Session('setpwd',null);
                        echo '<script>alert("修改成功");"</script>';
                        sleep(3);
                        $this->redirect(url('user/login'));
                    }else{
                        echo '<script>alert("密码不能和以前的相同");</script>';
                    }
                }
            }
        }
        return view();
    }
    /**
     * 维修预约提交
     */
    public function sub_order()
    {
        $res = array('code' => 1, 'msg' => '失败');
        if($_POST){
            $data = $_POST;
            $workorder = model('WorkOrders','model');
            $validate = validate('WorkOrders');
            if ($data['type'] == 2){
                $data['status'] = 8;
            }else{
                $data['status'] = 2;
            }
            $data['ip_add'] = $_SERVER['REMOTE_ADDR'];
            $data['jour_id'] = Session('driver')->uid;
            $data['add_time'] = time();
            $user = model('Users','model');
            $info = $user->get(Session('driver')->uid);
            $data['contact_info'] = $info['mobile'];
            $data['add_uid'] = Session('driver')->uid;
            $path = [];
            if($data['imgBase']){
                $base64 =explode (' - ',$data['imgBase']);
                foreach ($base64 as $key => $val){
                    $path[] = base_upload('',$val);
                }
            }
            $str = '';
            foreach($path as $key => $val){
                if($val['code'] == 1){
                    $str .= $val['url'].',';
                }
            }
            $data['imgpath'] = $str;
            if ($validate->check($data)){
                if($workorder->allowField(true)->save($data)){
                    if($_POST['gid']){
                        $common = db('common_use')->where('uid ='.Session('driver')->uid)->select();
                        if(count($common) >= 6){
                            $sql = 'DELETE from bq_common_use where uid = '.Session('driver')->uid.' limit 1';
                            Db::query($sql);
                        }
                        $arr = [];
                        foreach($common as $keys => $val){
                            $arr['flag'] = $val['gid'] != $_POST['gid'];
                        }
                        if(empty($common) && in_array(true,$arr)){
                            db('common_use')->insert(['uid' => Session('driver')->uid ,'gid' => $_POST['gid']]);
                        }
                    }
                    $res = array('code' => 1 , 'msg' => '成功');
                }
            }else{
                $res = array('code' => 2 , 'msg' => $validate->getError());
            }
        }
        return $res;
    }
    /**
     * 设置我的车辆信息
     */
    public function submycar()
    {
        $res = array('code' => 2 ,'msg' => '失败');
        if ($_POST){
            $usercar = model('UserCar','model');
            $uid = Session('driver')->uid;
            $data = $_POST;
            $data['uid'] = $uid;
            $info = $usercar->where('uid = '.$uid)->find();
            if ($info){
                $ret = $usercar->allowField(true)->save($data,['uid' => $uid]);
            }else{
                $ret = $usercar->allowField(true)->save($data);
            }
            if ($ret){
                $res = array('code' => 1,'msg' => '成功');
            }
        }
        return $res;
    }
    /**
     * 退出登录
     */
    public function signout()
    {
        Session('driver',null);
        if(empty(Session('driver'))){
            $this->redirect(url('user/login'));
        }
    }
    /**
     * 修改手机号
     */
    public function EditMobile()
    {
        $sms = new \sms\Sms;
        $res = array('code' => 2, 'msg' => '请填写完整表单');
        if ($_POST){
            if (!empty($_POST['verify']) && $_POST['mobile']){
                if($sms->checksms($_POST['verify'],$_POST['mobile'])){
                    $user = model('Users','model');
                    $where['uid'] = Session('driver')->uid;
                    $data['mobile'] = $_POST['mobile'];
                    if($user->allowField(true)->save($data,$where))
                    {
                        $res = array('code' => 1,'msg' => '成功');
                    }
                }else{
                    $res['msg'] = '验证码不正确';
                }
            }
        }
        return $res;
    }
    /**
     * 修改密码
     */
    public function EditPass()
    {
        $res = array('code' => 2 ,'msg' => '请填写完整');
        if ($_POST){
            $user = model('Users','model');
            if(!empty($_POST['oldpassword']) && !empty($_POST['newpassword'])&& !empty($_POST['newpassword2'])){
                $oldpassword = sysmd5($_POST['oldpassword']);
                $info = $user->where('uid = '.Session('driver')->uid.' and password = "'.$oldpassword.'"')->find();
                if(!empty($info)){
                    $data['password'] = sysmd5($_POST['newpassword']);
                    $where['uid'] = Session('driver')->uid;
                    if ($_POST['newpassword'] == $_POST['newpassword2']){
                        if($user->save($data,$where)){
                            $res = array('code' => 1,'msg' => '修改成功');
                        }
                    }else{
                        $res['msg'] = '两次输入密码不一致';
                    }
                }else{
                    $res['msg'] = '原密码不正确';
                }
            }
        }
        return $res;
    }
    /**
     * 检查手机信息是否存在
     */
    public function CheckMobile()
    {
        $res = array('code' => 2,'msg' => '请填写表单');
        if ($_POST){
            if (!empty($_POST['mobile']) && !empty($_POST['verify'])) {
                $data['mobile'] = $_POST['mobile'];
                $verify = $_POST['verify'];
                $sms = new \sms\Sms();
                if ($sms->checksms($verify,$data['mobile'])){
                    $user = model('Users','model');
                    $info = $user->where('mobile='.$data['mobile'])->find();
                    if (!empty($info)){
                        Session('setpwd',$info);
                        $res = array('code' => 1,'msg' => '存在');
                    }else{
                        $res['msg'] = '手机号不存在';
                    }
                }else{
                    $res['msg'] = '验证码不正确';
                }
            }
        }
        return $res;
    }
    /**
     * 抢单
     */
    public function grab_order()
    {
        $res = array('code' => 1,'msg' => '当前订单存在');
        if ($_POST){
            $where = $_POST;
            $data['status'] = 2;
            $user = model('Users','model');
            $gid = $user->getGroup(Session('driver')->uid);
            $data['gid'] = $gid;
            $workorder = model('WorkOrders','model');
            if($workorder->save($data,$where)){
                $res = array('code' => 1,'msg' => '抢单成功');
            }
        }
        return $res;
    }
    /**
     * 获取用户接受的订单
     */
    public function getUserTake()
    {
        $res = array('code' => 2,'msg' => '暂无数据');
        $work = model('WorkOrders','model');
        $list = $work->getUserData(4);
        if (!empty($list)){
            foreach ($list as $key => $val){
                $list[$key] = $val->toArray();
            }
            $res = array('code' => 1,'data' => $list);
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
            if($validate->check($_POST)){
                if($send->allowField(true)->save($_POST)){
                    $res = array('code' => 1 , 'msg' => '成功');
                    $aud->saveData('send_car',$send->getLastInsID(),9);
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
            $_POST['wo_id'] = $_POST['wo_id2'];
            if($validate->check($_POST)){
                if($send->allowField(true)->save($_POST)){
                    $res = array('code' => 1 , 'msg' => '成功');
                    $aud->saveData('stay_apply',$send->getLastInsID(),10);
                }
            }else{
                $res['msg'] = $validate->getError();
            }
        }
        return $res;
    }
    /**
     * 远程诊断
     */
    public function Remote(){
        return  1;
    }
    /**
     * 接受工单
     */
    public function AcceptWork()
    {
        $res = array('code' => 2 ,'msg' => '失败');
        if($_POST){
            if(!empty($_POST['plan_time']) && !empty($_POST['wid'])){
                $order = model("WorkOrders",'model');
                $log = model('WorkLog','model');
                $data['status'] = 4;
                $data['plan_time'] = strtotime($_POST['plan_time']);
                $where['wo_id'] = $_POST['wid'];
                if($order->save($data,$where)){
                    $str = Session('driver')->user_name . '在移动端接受了工单    #'.$order->get($_POST['wid'])->wo_sn;
                    $log->WriteLog($str,$_POST['wid'],4);
                    $res = array('code' => 1,'msg' => '接受成功');
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
        $order = model('WorkOrders','model');
        $data['refuse_reason'] = $_POST['refuse_reason'];
        $data['uid'] = 0;         //接收到拒绝请求，把负责人ID改为0
        $data['status'] = 2;      // 工单状态改为2(待指派)
        $where['wo_id'] = $_POST['wo_id'];
        if($order->save($data,$where)){
            $log = model('WorkLog','model');
            //把拒绝工单理由写入日志
            $str = Session('driver')->user_name. '在移动端拒绝了工单   #'.$order->get($_POST['wo_id'])->wo_sn.' 拒绝理由：'.$data['refuse_reason'];
            $log->WriteLog($str,$_POST['wo_id'],7);
            $res = array('code' => 1 ,'msg' => '拒绝成功');
        }
        return $res;
    }
    /**
     * 维修工开始工作
     */
    public function StartWork()
    {
        $res = array('code' => 2,'msg' => '失败');
        if ($_POST){
            if(!empty($_POST['wo_id'])){
                $order = model('WorkOrders','model');
                $log = model('WorkLog','model');
                $data['status'] = 9;
                $where['wo_id'] = $_POST['wo_id'];
                if ($order->save($data,$where)){
                    $str = Session('driver')->user_name .'在移动端开始工作 工单号   #'.$order->get($_POST['wo_id'])->wo_sn;
                    $log->WriteLog($str,$_POST['wo_id'],6);
                    $res = array('code' => 1,'msg' => '开始工作');
                }
            }
        }
        return $res;
    }
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
                    $log = model('WorkLog','model');
                    // 将工单状态写入日志
                    $str = Session('driver')->user_name . '完成了工单    #'.$order->get($_POST['wo_id'])->wo_sn;
                    $log->WriteLog($str,$_POST['wo_id'],7);
                    $res = array('code' => 1 , 'msg' => '完成成功');
                }
            }
        }
        return $res;
    }
    /**
     * 获取当前工单进度
     */
    public function getStatusLog()
    {
        $res = array('code' => 2,'msg' => '暂无数据');
        if($_POST){
            if(!empty($_POST['wid'])){
                $log = model('WorkLog','model');
                $list = $log->where('wo_id ='.$_POST['wid'])->order('add_time desc')->select();
                if(!empty($list)){
                    $res = array('code' => 1,'data' => $list);
                }
            }
        }
        return $res;
    }
    /**
     * 添加备注
     */
    public function AddRemark()
    {
        $res = array('code' => 2,'msg' => '添加失败');
        $log = model('WorkLog','model');
        $wo_id = $_POST['wid'];
        if(!empty($_POST['remark'])){
            $str = Session('driver')->user_name.'在移动端添加了备注：'.$_POST['remark'];
            if($log->WriteLog($str,$wo_id,12)){
                $res = array('code' => 1,'msg' => '添加成功');
            }
        }else{
            $res = array('code' => 2,'msg' => '请填写备注');
        }
        return $res;
    }
    /**
     * 添加回执
     */
    public function feedback()
    {
        return view();
    }
    /**
     * 查看回执
     */
    public function ShowReceipt()
    {
        $res = array('code' => 2,'msg' => '暂无数据');
        if($_POST){
            if(!empty($_POST['wid'])){
                $parts = model('Parts','model');        //备件model
                $services = model('Services','model');  // 服务model
                $wid = $_POST['wid'];
                $receipt = model('WorkReceipt','model');
                $info = $receipt->where('wo_id ='.$wid)->find();
                $ago = substr($info->ago_img,1);
                $back = substr($info->back_img,1);
                $info->ago_img = explode(',',$ago);
                $info->back_img = explode(',',$back);
                // 根据填写的备件ID 列出备件详情
                $part = json_decode($info->parts_desc,true);
                $arr = [];
                $brr = [];
                foreach ($part as $key => $val){
                    $arr['parinfo'][$key] = $parts->where('id = '.$val['id'])->find()->toArray();
                    $arr['parinfo'][$key]['num'] = $val['num'];
                }
                $info->parts_desc = $arr;
                // 根据填写的服务信息 列出服务详情
                $ser = json_decode($info->server_desc,true);
                foreach ($ser as $key => $val){
                    $brr['serinfo'][$key] = $services->where('id = '.$val['id'])->find()->toArray();
                    $brr['serinfo'][$key]['num'] = $val['num'];
                }
                $info->server_desc = $brr;
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
    public function work_order_receipt()
    {
        $ser = model('Services','model');
        $part = model('Parts','model');
        $plist = $part->where('p_count > 0 and gid ='.Session('driver')->gid)->select();     // 配件
        $slist = $ser->where('gid ='.Session('driver')->gid)->select();      // 服务
        $this->assign('server',$slist);
        $this->assign('parts',$plist);
        return  view();
    }
    /**
     * getServer
     */
    public function getServer()
    {
        $res = array('code' => 2,'msg' => '暂无数据');
        if($_POST){
            if(!empty($_POST['sid'])){
                $sid = $_POST['sid'];
                $ser = model('Services','model');
                $info = $ser->get($sid);
                if(!empty($info)){
                    $res = array('code' => 1,'data' => $info);
                }
            }
        }
        return $res;
    }
    /**
     * getParts
     */
    public function getParts()
    {
        $res = array('code' => 2,'msg' => '暂无数据');
        if($_POST){
            if(!empty($_POST['pid'])){
                $sid = $_POST['pid'];
                $par = model('Parts','model');
                $info = $par->get($sid);
                if(!empty($info)){
                    $res = array('code' => 1,'data' => $info);
                }
            }
        }
        return $res;
    }
    /**
     * 提交回执
     */
    public function SubReceipt()
    {
        $res = array('code' => 2,'msg' => '失败');
        if($_POST){
            if(!empty($_POST['img'])){
                $flag = false;
                $img = $_POST['img'];      // 修改前的都注释掉
//                $ago = $_POST['agoimg'];
//                $back = $_POST['backimg'];
//                $arr = explode(' - ',$ago);      // 拿到base64 格式字符串，根据 - 进行切割
//                $brr = explode(' - ',$back);
                $arr = explode(' - ',$img);
//                $data['ago_img'] = '';
//                $data['back_img'] = '';
                $imgs = '';
                $up_dir = ROOT_PATH . 'public/static' . DS . 'uploads/order';
                foreach($arr as $key => $val){
                    $res = base_upload($up_dir,$val);
                    if($res['code'] == 1){
                        $imgs .= ','.$res['url'];
                    }
                }
                $imgs = substr($imgs,1);
                $iarr = explode(',',$imgs);
                $data['ago_img'] = ','.$iarr[0];
                $data['back_img'] = ','.$iarr[1];
//                foreach ($arr as $key => $val){
//                    $res = base_upload($up_dir,$val);
//                    if($res['code'] == 1){
//                        $data['ago_img'] .= ','.$res['url'];
//                    }
//                }
//                foreach ($brr as $key => $val){
//                    $res = base_upload($up_dir,$val);
//                    if($res['code'] == 1){
//                        $data['back_img'] .= ','.$res['url'];
//                    }
//                }
                unset($_POST['img']);
//                unset($_POST['agoimg']);unset($_POST['backimg']);
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
                $log = model('WorkLog','model');
                $order = model('WorkOrders','model');
                $have = $receipt->where('wo_id ='.$_POST['wid'])->find();
                if(!empty($_POST['reid']) || !empty($have)){
                    if($receipt->allowField(true)->save($data,['reid' => $_POST['reid']?$_POST['reid']:$have->reid])){
                        $flag = true;
                        $str = Session('driver')->user_name .'编辑了回执 #'.$order->get($_POST['wid'])->wo_sn;
                        $log->WriteLog($str,$_POST['wid'],13);
                    }
                }else{
                    if($receipt->allowField(true)->save($data)){
                        $str = Session('driver')->user_name .'填写了回执 #'.$order->get($_POST['wid'])->wo_sn;
                        $log->WriteLog($str,$_POST['wid'],13);
                        $wdata['status'] = 10;
                        $order->allowField(true)->save($wdata,['wo_id' => $_POST['wid']]);
                        $aud = model('AudList','model');
                        $adata['type'] = 1;
                        $adata['rela_id'] = $_POST['wid'];
                        $adata['gid'] = Session('driver')->gid;
                        $adata['table'] = 'work_orders';
                        $adata['status'] = 1;
                        $adata['add_time'] = time();
                        $aud->save($adata);
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
     * 故障申报
     */
    public function declares()
    {
        $res = array('code' => 2,'msg' => '失败');
        if($_POST){
            if(!empty($_POST['wid']) && !empty($_POST['desc'])){
                $where['wo_id'] = $_POST['wid'];
                $data['status'] = 11;
//                $data['zid'] = Session('driver')->pid;
                $pid = db('user_group')->where('gid ='.Session('driver')->gid)->find()['pid'];
                $data['zid'] = $pid;
                $work = model('WorkOrders','model');
                $arr = [];
                if(!empty($_POST['base'])){
                    $arr = explode(' - ',$_POST['base']);      // 拿到base64 格式字符串，根据 - 进行切割
                }
                if($work->save($data,$where)){
                    $log = model('WorkLog', 'model');
                    $str = Session('driver')->user_name . '故障上报 工单号 #' . $work->get($_POST['wid'])->wo_sn."\n".
                        "故障描述：".$_POST['desc']."\n".
                        "图片：";
                    $up_dir = ROOT_PATH.'public/static' . DS . 'uploads/decl';
                    foreach ($arr as $key => $val){
                        $res = base_upload($up_dir,$val);
                        if($res['code'] == 1){
                            $str .= "<img src=\"".$res['url']."\" width=\"50\" height=\"50\" />";
                        }
                    }
                    $log->WriteLog($str, $_POST['wid'], 13);
                    $res = array('code' => 1,'msg' => '申报成功');
                }
            }
        }
        return $res;
    }
}

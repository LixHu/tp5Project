<?php
namespace app\shop\controller;
use think\Db;


class Guide extends Index
{

    /**
     * 指南列表
     */
    public function guide_all()
    {   
        $guide = model('GuideModel');
        $data = $guide->get_guide_all();
        $page = $data->render();
        $res = $data->isEmpty();//判断数据集
        $this->assign('res', $res);
        $this->assign('page', $page);
        $this->assign('data', $data);
        $rules = db('rules')->find();//规则与处罚
        $this->assign('rules', $rules);
        // dump($guide);die();
        
        return view();
    }

    /**
     * 指南详情
     */
    public function guide_list()
    {   
        $id = input('param.id');
        $rid = input('param.rid');
        if ($id) {
            $guide = model('GuideModel');
            
            $this->assign('data', $guide->getOneAd($id));
        }
        if ($rid) {
            $rules_list = db('rules')->where('id',$rid)->find();
            
            $this->assign('data', $rules_list);
        }
        
        
        return view();
    }
    
   

    /**
     * 捷律课堂
     */
    public function class_all()
    {   
        $class = model('ClassModel');
        $data = $class->get_class_all();
        $page = $data->render();
        $res = $data->isEmpty();//判断数据集
        $this->assign('res', $res);
        $this->assign('page', $page);
        $this->assign('data', $data);
        return view();
    }

    /**
     * 课堂详情
     */
    public function class_list()
    {   
        $id = input('param.id');
        if ($id) {
            $guide = model('ClassModel');
            
            $this->assign('data', $guide->getOneAd($id));
        }
        return view();
    }

    /**
     * 服务中心
     */
    public function service_all()
    {   
        $data = db('problem')->order('id asc')->select();
        $this->assign('data', $data);
        return view();
    }

    /**
     * 服务中心详情
     */
    public function service_list()
    {   
        $id = input('param.id');
        if ($id) {
            $data = db('problem')->where('id',$id)->find();
            
            $this->assign('data', $data);
        }
        return view();
    }

    /**
     * 任务中心
     */
    public function task()
    {   
        $time = time();
        $param = db('task')->where('start_time','>',$time)->order('id desc')->select();
    
        $data = db('task')->where('start_time','<',$time)->order('id desc')->select();
        $this->assign('data', $data);
        $this->assign('param', $param);
        $this->assign('time', $time);
        return view();
    }

    /**
     * 任务详情
     */
    public function task_list()
    {   
        $id = input('param.id');
        $time = time();
        if ($id) {
            $data = db('task')->where('id',$id)->find();
            if ($data['start_time'] < $time) {
                $data['status'] = '进行中';
            }elseif ($data['start_time'] > $time) {
                $data['status'] = '未开始';
            }elseif ($data['end_time'] < $time) {
                $data['status'] = '已结束';
            }
            $this->assign('data', $data);
        }
        return view();
    }

    /**
     * 司机等级
     */
    public function level()
    {   
        $did = input('param.did');
        if ($did) {
            $param = db('grade')->order('id asc')->select();//等级规则
            $integer = db('driver')->where('did',$did)->value('integer');//司机当前积分
            $level = db('grade')->where('and_sorce <'.$integer.' and end_sorce >'.$integer)->value('grade_name');
            
            
            $this->assign('integer', $integer);
            $this->assign('level', $level);
            $this->assign('param', $param);
        }
        return view();
    }

    /**
     * 消息中心
     */
    public function mes()
    {   
        $data = db('message')->order('id desc')->select();
        $this->assign('data', $data);
        return view();
    }
    /**
     * 消息详情
     */
    public function mes_list()
    {   
        $id = input('param.id');
        if ($id) {
            $data = db('message')->where('id',$id)->find();
            $this->assign('data', $data);
        }
        return view();
    }
    /**
     * 二维码
     */
    public function h5_qrcode()
    {
        $url = '';
    	if(!empty($_GET)){
    		if(!empty($_GET['uid']) || !empty($_GET['did'])){
			    import('phpqrcode.phpqrcode');
			    // 纠错级别：L、M、Q、H
			    $level = 'H';
			    // 点的大小：1到10,用于手机端4就可以了
			    $size = 4;
			    $time_path = date('Y/m/d/', time());
			    $server_path = ROOT_PATH.'public/static/upload/yqcode/' . $time_path;
			    $filename = uniqid() . '.png';
			    $file = $server_path . $filename;
			    // 判断目录书否创建
			    if(!is_dir($server_path)){
				    mkdir($server_path,0777,true);
			    }
			    $contact = model('Contact');
                $config = $contact->find();
                if(!empty($_GET['uid'])){
                    $url_data = $config['home_link'].'/h5_reg.html?uid='.$_GET['uid'];
                }else{
                    $url_data = $config['home_link'].'/h5_reg.html?did='.$_GET['did'];
                }
			    $qr_code = new \QRcode();
			    $qr_code::png($url_data, $file, $level, $size);
                $url = '/static/upload/yqcode/'.$time_path . $filename;
		    }
        }
        $this->assign('url',$url);
        return view();
    }
    public function h5_reg()
    {
        $uid = '';
        $did = '';
        if(!empty($_GET['uid'])){
            $uid = $_GET['uid'];
        }
        if(!empty($_GET['did'])){
            $did = $_GET['did'];
        }
        if($_POST){
            $sms = new \sms\Sms;
            $data = $_POST;
            if($sms->checksms($_POST['verifycode'],$_POST['mobile'])){
                if($_POST['type'] == 1){     // 注册用户
                    $user = model('Users');
                    $validate = validate('Users');
                    if($validate->check($data)){
                        if($user->allowField(true)->save($data)){
                            $res = array('code' => 1, 'msg' => '注册成功');
                        }else{
                            $res = array('code' => 2 , 'msg' => '失败');
                        }
                    }else{
                        $res = array('code' => 2,'msg' => $validate->getError());
                    }
                }else{        // 注册司机
                    $driver = model('Driver');
                    $validate = validate('Driver');
                    if($validate->check($data)){
                        if($driver->allowField(true)->save($data)){
                            $res = array('code' => 1,  'msg' => '注册成功');
                        }else{
                            $res = array('code' => 2 , 'msg' => '失败');
                        }
                    }
                }
            }else{
                $res = array('code' => 2, 'msg' => '短信验证码不正确');
            }
            return $res;
        }
        return view();
    }
    /**
     * 个人信息
     */
    public function h5_homepage()
    {
        if(!empty($_GET['did'])){
            $driver = model('Driver');
            $did = $_GET['did'];
            $list = $driver->order('`integer` desc')->select();
            $order = model('Orders');
            $fuwu = $order->where('did ='.$did.' and status > 6 and status != 101')->select();
            // index
            $paiming = 0;
            foreach($list as $key => $val){
                if($val['did'] == $did){
                    $paiming = $key+1;
                    break;
                }
            }
            $app = model('AppraiseScore');
            $applist = $app->all();
            $a = 0;
            $pingjia = [];
            foreach($applist as $key => $val){
                if($key % 2 == 0){
                    $a++;
                }
                $pingjia[$a][] = $val->toArray();
            }
            $this->assign('did',$did);
            $this->assign('applist',$pingjia);
            $this->assign('fuwu',count($fuwu));
            $this->assign('paiming',$paiming);
            return view();
        }
    }
}

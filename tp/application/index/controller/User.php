<?php
/**
 *
 */
namespace app\index\controller;
use think\Request;
class User extends Index
{
    /**
     * 登录
     */
    public function login()
    {
        $arr = $this->arr;
        $res = array('code' => 1001,'msg' => '缺少参数');
        if(!empty($arr)){
            if(!empty($arr['mobile']) && !empty($arr['password'])){
                $user = model('Users','model');
                $where['mobile'] = $arr['mobile'];
                $where['password'] = strtolower($arr['password']);
                $info = $user->where($where)->find();
                if($info){
                    $res = array('code' => 1000,'msg' => '登录成功' ,'uid' => $info);
                }else{
                    $res = array('code' => 1002,'msg' => '用户名或者密码错误');
                }
            }
        }
        return json($res);
    }
    /**
     * 注册
     */
    public function reg()
    {
        $arr = $this->arr;
        $res = array('code' => 1001,'msg' => '缺少参数');
        if(!empty($arr)){
            $sms = new \sms\Sms;
            // 判断短信验证码
            if($sms->checksms($arr['verifycode'],$arr['mobile'])){
                unset($arr['verifycode']);
                $user = model('Users','model');
                $driver = model("Driver",'model');
                $arr['add_time'] = time();
                $arr['unique_id'] = date('ymdhis').rand('10','99').rand('10','99');
                $arr['password'] = strtolower($arr['password']);
                if($arr['type'] == 1){
                    $validate = validate('Users');
                    if($validate->check($arr)){
                        if($user->allowField(true)->save($arr)){
                            $uid = $user->getLastInsID();
                            $param = [
                                'userId'  =>   $arr['unique_id'],
                                'name'    =>   $arr['mobile'],
                                'portraitUri'  => config('server_url').'/static/user/default_head.png'
                            ];
                            import('request.SendRequest');
                            $account = model('Account','model');
                            $apkey = $account->getAccount('rongcloud');
                            $send = new \SendRequest($apkey['account'],$apkey['secret']);
                            $token = $send->curl('/user/getToken.json',$param);
                            $jgtoken = json_decode($token,true)['token'];
                            $user->save(['user_token' => $jgtoken],['uid' => $uid]);
                            $res = array('code' => 1000,'msg' => '注册成功');
                        }
                    }else{
                        $res = array('code' => 1004,'msg' => $validate->getError());
                    }
                }else{
                    $arr['status'] = 3;
                    $validate = validate('Driver');
                    if($validate->check($arr)){
                        if($driver->allowField(true)->save($arr)){
                            $did = $driver->getLastInsID();
                            $param = [
                                'userId'  =>   $arr['unique_id'],
                                'name'    =>   $arr['mobile'],
                                'portraitUri'  => config('server_url').'/static/user/default_head.png'
                            ];
                            import('request.SendRequest');
                            $account = model('Account','model');
                            $apkey = $account->getAccount('rongcloud');
                            $send = new \SendRequest($apkey['account'],$apkey['secret']);
                            $token = $send->curl('/user/getToken.json',$param);
                            $jgtoken = json_decode($token,true)['token'];
                            $driver->save(['driver_token' => $jgtoken],['did' => $did]);
                            $res = array('code' => 1000,'msg' => '注册成功');
                        }
                    }else{
                        $res = array('code' => 1004,'msg' => $validate->getError());
                    }
                }
            }else{
                $res = array('code' => 1003,'msg' => "验证码不正确");
            }
        }
        return json($res);
    }
    /**
     * 用户修改资料
     */
    public function ueditdata()
    {
        if(!empty($_POST['jsondata'])){
            $pt = $_POST['jsondata'];
            $arr = json_decode($pt,true);
        }
        $header_img = request()->file('user_img');      // 头像
        if(!empty($header_img)){
            $info = $header_img->validate(['ext' => 'jpg,jpeg,gif,png'])->move(ROOT_PATH.'public/static'.DS.'upload/driver/');
            if($info){
                $arr['header_img'] = '/static/upload/driver/'.$info->getSaveName();
                $res['msg'] = '成功';
            }else{
                $res['top'] = '头像未上传';
            }
        }
        $res = array('code' => 1001,'msg' => '缺少参数');
        if(!empty($arr)){
            if(!empty($arr['uid'])){
                $where['uid'] = $arr['uid'];
                $uid = $arr['uid'];
                unset($arr['uid']);
                $data = $arr;
                $user = model('Users','model');
                if($user->allowField(true)->save($data,$where)){
                    $param = [
                        'userId'          => $user->get($uid)->unique_id,
                        'name'            => $user->get($uid)->nick_name,
                    ];
                    if(!empty($data['header_img'])){
                        $data['header_img'] = config('server_url').$data['header_img'];
                        $param['portraitUri'] = $data['header_img'];
                    }
                    import('request.SendRequest');
                    $account = model('Account','model');
                    $apkey = $account->getAccount('rongcloud');
                    $send = new \SendRequest($apkey['account'],$apkey['secret']);
                    $send->curl('/user/refresh.json',$param);
                    $res = array('code' => 1000 ,'msg' => '修改成功','data' => $data);
                }else{
                    $res = array('code' => 1002 ,'msg' => '失败');
                }
            }
        }
        return json($res);
    }
    public function ueditdata2()
    {
        $arr = $this->arr;
        $res = array('code' => 1001,'msg' => '缺少参数');
        if(!empty($arr)){
            if(!empty($arr['uid'])){
                if(!empty($arr['user_img'])){
                    $up_dir = ROOT_PATH . 'public/static' . DS . 'upload/user/';
                    $base = base_upload($up_dir,$arr['user_img']);
                    if($base['code'] == 1){
                        $arr['header_img'] = $base['url'];
                    }
                }
                $where['uid'] = $arr['uid'];
                $uid = $arr['uid'];
                unset($arr['uid']);
                unset($arr['user_img']);
                $data = $arr;
                $user = model('Users','model');
                if($user->allowField(true)->save($data,$where)){
                    $param = [
                        'userId'          => $user->get($uid)->unique_id,
                        'name'            => $user->get($uid)->nick_name,
                    ];
                    if(!empty($data['header_img'])){
                        $data['header_img'] = config('server_url').$data['header_img'];
                        $param['portraitUri'] = $data['header_img'];
                    }
                    import('request.SendRequest');
                    $account = model('Account','model');
                    $apkey = $account->getAccount('rongcloud');
                    $send = new \SendRequest($apkey['account'],$apkey['secret']);
                    $send->curl('/user/refresh.json',$param);
                    $res = array('code' => 1000 ,'msg' => '修改成功','data' => $data);
                }else{
                    $res = array('code' => 1002 ,'msg' => '失败');
                }
            }
        }
        $res['input'] = $arr;
        return json($res);
    }
    /**
     * 获取用户资料
     */
    public function udata()
    {
        $arr = $this->arr;
        $res = array('code' => 1001,'msg' => '缺少参数');
        if(!empty($arr)){
            if(!empty($arr['uid'])){
                $user = model('Users','model');
                $info = $user->get($arr['uid']);
                if(!empty($info)){
                    $res = array('code' => 1000 ,'data' => $info);
                }else{
                    $res = array('code' => 1002 ,'msg' => '用户不存在');
                }
            }
        }
        return json($res);
    }
    /**
     * 用户更换手机号码
     */
    public function ueditmobile(){
        $arr = $this->arr;
        $res = array('code' => 1001 , 'msg' => '缺少参数');
        if(!empty($arr)){
            if(!empty($arr['newmobile']) && !empty($arr['verifycode']) && !empty($arr['uid'])){
                $user = model('Users','model');
                $sms = new \sms\Sms;
                if($sms->checksms($arr['verifycode'],$arr['newmobile'])){
                    $uinfo = $user->where('mobile = '.$arr['newmobile'])->find();
                    if(empty($uinfo)){
                        $where['uid'] = $arr['uid'];
                        $data['mobile'] = $arr['newmobile'];
                        if($user->save($data,$where)){
                            $res = array('code' => 1000 ,'msg' => '修改成功','data' => $data);
                        }else{
                            $res = array('code' => 1002 ,'msg' => '失败');
                        }
                    }
                }else{
                    $res = array('code' => 1003 ,'msg' => '验证码不正确');
                }
            }
        }
        return json($res);
    }
    /**
     * 司机更换手机号码
     */
    public function deditmobile(){
        $arr = $this->arr;
        $res = array('code' => 1001 , 'msg' => '缺少参数');
        if(!empty($arr)){
            if(!empty($arr['newmobile']) && !empty($arr['verifycode']) && !empty($arr['did'])){
                $driver = model('Driver','model');
                $sms = new \sms\Sms;
                if($sms->checksms($arr['verifycode'],$arr['newmobile'])){
                    $dinfo = $driver->where('mobile = '.$arr['newmobile'])->find();
                    if(empty($dinfo)){
                        $where['did'] = $arr['did'];
                        $data['mobile'] = $arr['newmobile'];
                        if($driver->allowField(true)->save($data,$where)){
                            $res = array('code' => 1000 ,'msg' => '修改成功','data' => $data);
                        }else{
                            $res = array('code' => 1002 ,'msg' => '失败');
                        }
                    }
                }else{
                    $res = array('code' => 1003 ,'msg' => '验证码不正确');
                }
            }
        }
        return json($res);
    }
    /**
     * 忘记密码
     */
    public function uforget() {
        $arr = $this->arr;
        $res = array('code' => 1001,'msg' => '缺少参数');
        if(!empty($arr)){
            if(!empty($arr['mobile']) && !empty($arr['verifycode'])){ // && !empty($arr['newpass']) &&
                $user = model('Users','model');
                $sms = new \sms\Sms;
                if($sms->checksms($arr['verifycode'],$arr['mobile'])){
                    $uinfo = $user->where('mobile ='.$arr['mobile'])->find();
                    if(!empty($uinfo)){
//                        $data['password'] = $arr['newpass'];
//                        $where['uid'] = $uinfo->uid;
//                        if($user->save($data,$where)){
//                            $res = array('code' => 1000 ,'msg' => '修改成功');
//                        }else{
//                            $res = array('code' => 1002 , 'msg' => '失败');
//                        }
                        $res = array('code' => 1000 , 'uid' => $uinfo->uid);
                    }else{
                        $res = array('code' => 1003 ,'msg' => '手机号不存在');
                    }
                }else{
                    $res = array('code' => 1004,'msg' => '验证码不正确');
                }
            }
        }
        return json($res);
    }
    /**
     * 忘记密码2
     */
    public function uforget2()
    {
        $arr = $this->arr;
        $res = array('code' => 1001,'msg' => '缺少参数');
        if(!empty($arr)) {
            if (!empty($arr['uid']) && !empty($arr['newpass'])) { // && !empty($arr['newpass']) &&
                $user = model('Users', 'model');
//                $sms = new \sms\Sms;
//                if($sms->checksms($arr['verifycode'],$arr['mobile'])){
//                $uinfo = $user->where('mobile ='.$arr['mobile'])->find();
//                if(!empty($uinfo)){
                $data['password'] = $arr['newpass'];
                $where['uid'] = $arr['uid'];
                if ($user->save($data, $where)) {
                    $res = array('code' => 1000, 'msg' => '修改成功');
                } else {
                    $res = array('code' => 1002, 'msg' => '失败');
                }
//                }else{
//                    $res = array('code' => 1003 ,'msg' => '手机号不存在');
//                }
//                }else{
//                    $res = array('code' => 1004,'msg' => '验证码不正确');
//                }
            }
        }
        return json($res);
    }
    /**
     * 修改密码
     */
    public function editpass()
    {
        $arr = $this->arr;
        $res = array('code' => 1001,'msg' => '缺少参数');
        if(!empty($arr)){
            if(!empty($arr['oldpass']) && !empty($arr['newpass']) && !empty($arr['uid'])){
                $user = model('Users','model');
                $info = $user->where('uid = '.$arr['uid'].' and password = \''.$arr['oldpass'].'\'')->find();
                if(!empty($info)){
                    $data['password'] = $arr['newpass'];
                    $where['uid'] = $arr['uid'];
                    if($user->save($data,$where)){
                        $res = array('code' => 1000,'msg' => '修改成功','data' => $data);
                    }
                }else{
                    $res = array('code' => 1002,'msg' => '原密码不正确');
                }
            }
        }
        return json($res);
    }
    /**
     * 绑定邮箱
     */
    public function bindemail()
    {
        $arr = $this->arr;
        $res = array('code' => 1001,'msg' => '缺少参数');
        if(!empty($arr)){
            if(!empty($arr['email']) && !empty($arr['uid'])){     //&& !empty($arr['verifycode'])
//                if($arr['verifycode'] == Session('emailcode')){
                    $user = model("Users",'model');
                    $data['email'] = $arr['email'];
                    $where['uid'] = $arr['uid'];
                    if($user->save($data,$where)){
                        $res = array('code' => 1000,'msg' => '绑定成功','data' => $data);
                    }else{
                        $res = array('code' => 1002,'msg' => '未做任何修改');
                    }
//                }
            }
        }
        return json($res);
    }
    /**
     * 发送邮箱验证码
     */
    public function sendemail()
    {
        $arr = $this->arr;
        $res = array('code' => 1001,'msg' => '缺少参数');
        if(!empty($arr)){
            if(!empty($arr['email'])){
                if(preg_match('/^[A-Za-z0-9]+([-_.][A-Za-z0-9]+)*@([A-Za-z0-9]+[-.])+[A-Za-z0-9]{2,4}$/',$arr['email'])){
                    $code = rand(1000,9999);
                    Session('emailcode',$code);
                    $content = '你的验证码为：'.$code."\n 请在五分钟内输入。否则将失效。";
                    if(parent::sendMail($arr['email'],'验证码',$content)){
                        $res = array('code' => 1000,'msg' => '发送成功');
                    }else{
                        $res = array('code' => 1003,'msg' => '发送失败');
                    }
                }else{
                    $res = array('code' => 1002,'msg' => '邮箱格式不正确');
                }
            }
        }
        return json($res);
    }
    /**
     * 优惠券
     */
    public function usercoupon()
    {
        $arr = $this->arr;
        $res = array('code' => 1001 ,'msg' =>  '缺少参数');
        if(!empty($arr)){
            if(!empty($arr['uid'])){
                $user = model('Users','model');
                $list = $user->getCoupon($arr['uid']);
//                if(!empty($list)){
                    foreach ($list as $key => $val){
                        $val['name'] = '满'.$val['m_price'].'减'.$val['d_price'];
                        $val['date'] = '有效期至'.date('Y-m-d',$val['max_time']);
                        unset($list[$key]['m_price']);
                        unset($list[$key]['d_price']);
                        unset($list[$key]['max_time']);
                        unset($list[$key]['start_time']);
                        unset($list[$key]['end_time']);
                    }
                    $res = array('code' => 1000 ,'data' => $list);
//                }else{
//                    $res = array('code' => 1002 ,'msg' => '暂无数据');
//                }
            }
        }
        return json($res);
    }
    /**
     * 更改极光用户ID
     */
    public function editjguid()
    {
        $arr = $this->arr;
        $res = array('code' => 1001 ,'msg' => '缺少参数');
        if(!empty($arr)){
            if(!empty($arr['uid']) && !empty($arr['registrationid']) && !empty($arr['role'])){
                $data['registrationid'] = $arr['registrationid'];
                if($arr['role'] == 1){
                    $where['uid'] = $arr['uid'];
                    $user = model('Users','model');
                }else{
                    $where['did'] = $arr['uid'];
                    $user = model('Driver','model');
                }
                if($user->allowField(true)->save($data,$where)){
                    $res = array('code' => 1000 , 'msg' => '修改成功');
                }else{
                    $res = array('code' => 1002 , 'msg' => '未做任何修改');
                }
            }
        }
        return json($res);
    }
    /**
     * =====================================================================================================================
     */
    /**
     * 司机登录
     */
    public function driverlogin()
    {
        $arr = $this->arr;
        $res = array('code' => 1001,'msg' => '缺少参数');
        if(!empty($arr)){
            // 司机登录
            if(!empty($arr['mobile']) && !empty($arr['password'])){
                $driver = model('Driver','model');
                $where['mobile'] = $arr['mobile'];
                $where['password'] = strtolower($arr['password']);
                $info = $driver->where($where)->find();
                if(!empty($info)){
                    $res = array('code' => 1000 ,'msg' => '登录成功','did' => $info);
                }else{
                    $res = array('code' => 1002 ,'msg' => '用户名或者密码错误');
                }
            }
        }
        return json($res);
    }
    /**
     * 司机忘记密码
     */
    public function dforget()
    {
        $arr = $this->arr;
        $res = array('code' => 1001,'msg' => '缺少参数');
        if(!empty($arr)){
            if(!empty($arr['mobile']) && !empty($arr['verifycode']) && !empty($arr['newpass'])){ //  &&
                $user = model('Driver','model');
                $sms = new \sms\Sms;
                if($sms->checksms($arr['verifycode'],$arr['mobile'])){
                $uinfo = $user->where('mobile ='.$arr['mobile'])->find();
                if(!empty($uinfo)){
                        $data['password'] = $arr['newpass'];
                        $where['uid'] = $uinfo->uid;
                        if($user->save($data,$where)){
                            $res = array('code' => 1000 ,'msg' => '修改成功');
                        }else{
                            $res = array('code' => 1002 , 'msg' => '失败');
                        }
                    $res = array('code' => 1000 , 'uid' => $uinfo->uid);
                }else{
                    $res = array('code' => 1003 ,'msg' => '手机号不存在');
                }
                }else{
                    $res = array('code' => 1004,'msg' => '验证码不正确');
                }
            }
        }
        return json($res);
    }
    /**
     * 司机修改密码
     */
    public function deditpass()
    {
        $arr = $this->arr;
        $res = array('code' => 1001,'msg' => '缺少参数');
        if(!empty($arr)){
            if(!empty($arr['oldpass']) && !empty($arr['newpass']) && !empty($arr['did'])){
                $driver = model('Driver','model');
                $info = $driver->where('did = '.$arr['did'].' and password = \''.$arr['oldpass'].'\'')->find();
                if(!empty($info)){
                    $data['password'] = $arr['newpass'];
                    $where['did'] = $arr['did'];
                    if($driver->allowField(true)->save($data,$where)){
                        $res = array('code' => 1000,'msg' => '修改成功');
                    }else{
                        $res = array('code' => 1003,'msg' => '修改失败');
                    }
                }else{
                    $res = array('code' => 1002,'msg' => '原密码不正确');
                }
            }
        }
        return json($res);
    }
    /**
    * 司机银行卡列表
    */
    public function dbanklist()
    {
        $arr = $this->arr;
        $res = array('code' => 1001 ,'msg' => '缺少参数');
        if(!empty($arr)){
            if(!empty($arr['did'])){
                $bank = model('DriverBank','model');
                $list = $bank->where('did ='.$arr['did'])->select();
                foreach ($list as $key => $val){
                    $list[$key]['bank_num'] = (int)mb_substr($val['bank_num'],strlen($val['bank_num'])-4);
                }
//                if(!empty($list)){
                    $res = array('code' => 1000 ,'data' => $list);
//                }else{
//                    $res = array('code' => 1002 , 'msg' => '暂无数据');
//                }
            }
        }
        return json($res);
    }
    /**
    * 添加银行卡
    */
    public function addbank()
    {
        $arr = $this->arr;
        $res = array('code' => 1001 ,'msg' => '缺少参数');
        if(!empty($arr)){
            if(!empty($arr['did']) && !empty($arr['bank_name']) && !empty($arr['bank_num'])){
                $data = $arr;
                $bank = model('DriverBank','model');
                if($bank->allowField(true)->save($data)){
                    $res = array('code' => 1000,'msg' => '添加成功');
                }else{
                    $res = array('code' => 1002,'msg' => '失败');
                }
            }
        }
        return json($res);
    }
    /**
    * 更换银行卡
    */
    public function editbank()
    {
        $arr = $this->arr;
        $res = array('code' => 1001 ,'msg' => '缺少参数');
        if(!empty($arr)){
            if(!empty($arr['banid']) && !empty($arr['bank_name']) && !empty($arr['bank_num'])){
                $where['banid'] = $arr['banid'];
                unset($arr['banid']);
                $data = $arr;
                $bank = model('DriverBank','model');
                if($bank->allowField(true)->save($data,$where)){
                    $res = array('code' => 1000,'msg' => '修改成功');
                }else{
                    $res = array('code' => 1002,'msg' => '失败');
                }
            }
        }
        return json($res);
    }
    /**
    * 删除银行卡
    */
    public function delbank()
    {
        $arr = $this->arr;
        $res = array('code' => 1001 ,'msg' => '缺少参数');
        if(!empty($arr)){
            if(!empty($arr['banid'])){
                $banid = $arr['banid'];
                $bank = model('DriverBank','model');
                if($bank->where('banid ='.$banid)->delete()){
                    $res = array('code' => 1000,'msg' => '删除成功');
                }else{
                    $res = array('code' => 1002,'msg' => '失败');
                }
            }
        }
        return json($res);
    }
    /**
     * 返回司机个人信息
     */
    public function getdriverinfo()
    {
        $arr = $this->arr;
        $res = array('code' => 1001 ,'msg' => '缺少参数');
        if(!empty($arr)){
            if(!empty($arr['did'])){
                $did = $arr['did'];
                $driver = model('Driver','model');
                $bank = model('DriverBank','model');
                $info = $driver->get($did);
                $binfo = $bank->where('did = '.$did)->find();
                $info->bank_num = (int)mb_substr($binfo->bank_num,strlen($binfo->bank_num)-4);
                $info->bank_name = $binfo->bank_name;
                if(!empty($info)){
                    $res = array('code' => 1000,'data' => $info);
                }else{
                    $res = array('code' => 1002,'msg' => '暂无数据');
                }
            }
        }
        return json($res);
    }
    /**
     * 司机修改资料
     */
    public function deditdata()
    {
        if(!empty($_POST['jsondata'])){
            $pt = $_POST['jsondata'];
            $arr = json_decode($pt,true);
        }
        $header_img = request()->file('driver_img');      // 头像
        if(!empty($header_img)){
            $info = $header_img->validate(['ext' => 'jpg,jpeg,gif,png'])->move(ROOT_PATH.'public/static'.DS.'upload/driver/');
            if($info){
                $arr['header_img'] = '/static/upload/driver/'.$info->getSaveName();
                $res['msg'] = '成功';
            }else{
                $res['top'] = '头像未上传';
            }
        }
        $res = array('code' => 1001,'msg' => '缺少参数');
        if(!empty($arr)){
            if(!empty($arr['did'])){
                $where['did'] = $arr['did'];
                $did = $arr['did'];
                unset($arr['did']);
                $data = $arr;
                $user = model('Driver','model');
                if($user->allowField(true)->save($data,$where)){
                    $param = [
                        'userId'          => $user->get($did)->unique_id,
                        'name'            => $user->get($did)->rela_name,
                    ];
                    if(!empty($data['header_img'])){
                        $data['header_img'] = config('server_url').$data['header_img'];
                        $param['portraitUri'] = $data['header_img'];
                    }
                    import('request.SendRequest');
                    $account = model('Account','model');
                    $apkey = $account->getAccount('rongcloud');
                    $send = new \SendRequest($apkey['account'],$apkey['secret']);
                    $send->curl('/user/refresh.json',$param);
                    $res = array('code' => 1000 ,'msg' => '修改成功','data' => $data);
                }else{
                    $res = array('code' => 1002 ,'msg' => '未做任何修改');
                }
            }
        }
        return json($res);
    }
    /**
     * 用户消费记录
     */
    public function gettranlog()
    {
        $arr = $this->arr;
        $res = array('code' => 1001 ,'msg' => '缺少参数');
        if(!empty($arr)){
            if(!empty($arr['uid'])){
                $where['uid'] = $arr['uid'];
                $pl = model('PriceLog','model');
                $list = $pl->where($where)->order('tran_time desc')->select();
                if(!empty($list)){
                    foreach($list as $key => $val){
                        if($val['type'] == 1){
                            $list[$key]['price'] = "+".$val['price'];
                        }else{
                            $list[$key]['price'] = "-".$val['price'];
                        }
                    }
                }
                $res = array('code' => 1000,'data' => $list);
            }
        }
        return json($res);
    }
    /**
     * 司机消费记录
     */
    public function getdrtranlog()
    {
        $arr = $this->arr;
        $res = array('code' => 1001 ,'msg' => '缺少参数');
        if(!empty($arr)){
            if(!empty($arr['did'])){
                $where['did'] = $arr['did'];
                $pl = model('DriverLog','model');
                $driver = model('Driver','model');
                $bank = model('DriverBank','model');
                $info = $driver->get($arr['did']);
                $blist = $bank->where('did ='.$arr['did'])->select();
                $list = $pl->where($where)->order('save_time desc')->select();
                if(!empty($list)){
                    foreach($list as $key => $val){
                        if($val['type'] == 1){
                            $list[$key]['price'] = "+".$val['price'];
                        }else{
                            $list[$key]['price'] = "-".$val['price'];
                        }
                    }
                }
                foreach ($blist as $key => $val) {
                    $blist[$key]['bank_num'] = (int)mb_substr($val['bank_num'],strlen($val['bank_num'])-4);
                }
                $res = array('code' => 1000,'data' => $list ,'blance' => $info['blance'] ,'bank' => $blist ,'pay_pass' => !empty($info->pay_pass)?1:2);
            }
        }
        return json($res);
    }
    public function region()
    {
        $list = [];
        $list = db('region')->where('pid = 1')->select();
        foreach ($list as $key => $val){
            $list[$key]['child'][] = db('region')->where('pid ='.$val['id'])->select();
        }
        return json($list);
    }
    /**
     *  提现
     */
    public function drawmoney()
    {
        $arr = $this->arr;
        $res = array('code' => 1001 ,'msg' => '缺少参数');
        if(!empty($arr)){
            if(!empty($arr['did']) && !empty($arr['pay_pass']) && !empty($arr['money']) && !empty($arr['dbankid'])){
                $driver = model('Driver','model');
                $info = $driver->get($arr['did']);
                if(!empty($info)){
                    if($info->pay_pass == $arr['pay_pass']){
                        $blance = $info->blance;
                        if($blance > $arr['money']){
                            $txlog = model('Txlog','model');
                            $driverbank = model('DriverBank','model');
                            $arr['add_time'] = time();
                            if($txlog->allowField(true)->save($arr)){
                                $driver->where('did = '.$info->did)->dec('blance',$arr['money'])->update();
                                $data['binfo'] = $driverbank->get($arr['dbankid']);
                                $data['yjtime'] = date("Y-n-d G:00",strtotime('+1 day',time()));
                                $data['money'] = $arr['money'];
                                $dlog = model('DriverLog','model');
                                $ddata['did'] = $arr['did'];
                                $ddata['desc'] = '提现';
                                $ddata['price'] = $arr['money'];
                                $ddata['type'] = 2;
                                $ddata['blance'] = $driver->get($arr['did'])->blance;
                                $ddata['save_time'] = time();
                                $dlog->save($ddata);
                                $res = array('code' => 1000 ,'msg' =>   '提现申请中，请耐心等待' ,'data' => $data );
                            }
                        }else{
                            $res = array('code' => 1004 , 'msg' => '余额不足');
                        }
                    }else{
                        $res = array('code' => 1005,'msg' => '支付密码不正确');
                    }
                }else{
                    $res = array('code' => 1003 , 'msg' => '司机不存在');
                }
            }
            if(empty($arr['dbankid'])){
                $res = array('code' => 1002 , 'msg' =>  '请添加银行卡');
            }
        }
        return json($res);
    }
    /**
     * 修改支付密码
     */
    public function editpaypass()
    {
        $arr = $this->arr;
        $res = array('code' => 1001 ,'msg' => '缺少参数');
        if(!empty($arr)){
            if(!empty($arr['did']) && !empty($arr['newpass'])){
                $driver = model('Driver');
                $info = $driver->get($arr['did']);
                if(!empty($info->pay_pass)){
                    if($info->pay_pass == $arr['oldpass']){
                        if($driver->allowField(true)->save(['pay_pass' => $arr['newpass']],['did' => $arr['did']])){
                            $res = array('code' => 1000 ,'msg' => '修改成功');
                        }else{
                            $res = array('code' => 1003 ,'msg' => '新密码不能和以前的密码一致');
                        }
                    }else{
                        $res = array('code' => 1002 ,'msg' => '旧密码输入不正确，请重新输入');
                    }
                }else{
                    if($driver->allowField(true)->save(['pay_pass' => $arr['newpass']],['did' => $arr['did']])){
                        $res = array('code' => 1000 ,'msg' => '修改成功');
                    }else{
                        $res = array('code' => 1003 ,'msg' => '新密码不能和以前的密码一致');
                    }
                }
            }
        }
        return json($res);
    }
    /**
     * 忘记支付密码
     */
    public function forgetpaypass()
    {
        $arr = $this->arr;
        $res = array('code' => 1001 ,'msg' => '缺少参数');
        if(!empty($arr)){
            if(!empty($arr['smscode']) && !empty($arr['did']) && !empty($arr['mobile']) && !empty($arr['newpass'])){
                $sms = new \sms\Sms('C35588802','424b2e67fc7049c7bc6a99fd90aeced1');
                if($sms->checksms($arr['smscode'],$arr['mobile'])){
                    $driver = model('Driver');
                    $info = $driver->get($arr['did']);
                    if(!empty($info)){
                        if($driver->allowField(true)->save(['pay_pass' => $arr['newpass']],['did' => $arr['did']])){
                            $res = array('code' => 1000 ,'msg' => '修改成功');
                        }else{
                            $res = array('code' => 1003 , 'msg' => '新密码不能和以前的密码相同');
                        }
                    }
                }else{
                    $res = array('code' => 1002 ,'msg' => '验证码不正确');
                }
            }
        }
        return json($res);
    }
    /**
     * 二维码
     */
    public function qrcode()
    {
    	$arr = $this->arr;
    	$res = array('code' => 1001 ,'msg' => '缺少参数');
    	if(!empty($arr)){
    		if(!empty($arr['uid'])){
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
			    $url_data = $config['home_link'].'/h5_reg.html?uid='.$arr['uid'];
			    $qr_code = new \QRcode();
			    $qr_code::png($url_data, $file, $level, $size);
			    $res = array('code' => 1000 ,'img' => config('server_url').'/static/upload/yqcode/'.$time_path . $filename);
		    }
	    }
	    return json($res);
    }
    /**
     * 设置出车收车
     */
    public function out_car()
    {
        $arr = $this->arr;
        $res = array('code' => 1001 ,'msg' => '缺少参数');
        if(!empty($arr)){
            $validate = validate('DriverOut');
            if($validate->check($arr)){
                $driverout = model('DriverOut');
                $info = $driverout->where('did ='.$arr['did'])->find();
                $arr['save_time'] = time();
                if(!empty($info->save_time)){
                    if(strtotime('+1 day',$info->save_time) < time()){
                        if(!empty($info)){
                            $flag = $driverout->allowField(true)->where('did ='.$info->did)->update($arr);
                        }else{
                            $flag = $driverout->allowField(true)->save($arr);
                        }
                        if($flag){
                            $res = array('code' => 1000 ,'msg' => '设置成功');
                        }else{
                            $res = array('code' => 1002 ,'msg' => '失败');
                        }
                    }else{
                        $res = array('code' => 1003, 'msg' => '24小时只能设置一次。' );
                    }
                }else{
                    if(!empty($info)){
                        $flag = $driverout->allowField(true)->where('did ='.$info->did)->update($arr);
                    }else{
                        $flag = $driverout->allowField(true)->save($arr);
                    }
                    if($flag){
                        $res = array('code' => 1000 ,'msg' => '设置成功');
                    }else{
                        $res = array('code' => 1002 ,'msg' => '失败');
                    }
                }
            }else{
                $res = array('code' => 1002 ,'msg' => $validate->getError());
            }
        }
        return json($res);
    }

    /**
     * 查看出车收车
     */
    public function out_info()
    {
        $arr = $this->arr;
        $res = array('code' => 1001 ,'msg' => '缺少参数');
        if(!empty($arr)){
            $driverout = model('DriverOut');
            $info = $driverout->where('did ='.$arr['did'])->find();
            if(empty($info)){
                $info = [];
            }
                $res = array('code' => 1000 ,'data' => $info);
        }
        return json($res);
    }
}

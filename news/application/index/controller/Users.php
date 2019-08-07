<?php
namespace app\index\controller;

class Users extends Index
{
    function __construct(){
        parent::__construct();
        $this->tack();
        // $this->relogin();
    }
    private function tack()
    {
        $arr = $this->arr;
        if(!empty($arr['user_id'])){
            $id = $arr['user_id'];
            if(db('users')->where('user_id = '.$id)->find()){
                $tack_list = db('user_take')->where('user_id = '.$id)->select();
                if(count($tack_list) < 5){
                    $data['user_id'] = $id;
                    $col_list = db('ad_column')->limit(0,5)->select();
                    foreach($col_list as $key => $val){
                        $data['col_id'] = $val['col_id'];
                        if(!db('user_take')->where($data)->find()){
                            db('user_take')->insert($data);
                        }
                    }
                }
            }
        }
    }
    // private function relogin()
    // {
    //     $arr = $this->arr;
    //     $session_id = session_id();
    //     session_start();
    //     $arr['user_id'] = 1;
    //     if(!empty($arr['user_id'])){
    //         $userinfo = db('users')->where('user_id ='.$arr['user_id'])->find();
    //         if(!empty($userinfo)) {
    //             if($userinfo['is_login'] == 1){
    //                 $request = request();
    //                 if($userinfo['session_id'] != session_id()  &&  $request->action() != 'login'){
    //                     die('请重新登录');
    //                 }
    //             }
    //         }
    //     }
    // }
    /*
    *   收藏列表
    */
    public function like()
    {
        $arr = $this->arr;
        if(!empty($arr)){
            $flag = true;
            if(empty($arr['user_id'])){
                $flag = false;
            }
            if($flag){
                $user_id = $arr['user_id'];
                $page = 1;
                $page_size = 10;
                if(!empty($arr['page'])){
                    $page = $arr['page'];
                }
                $collect = db('users')
                        ->alias('a')
                        ->field('c.ad_id,c.title,c.ad_img,c.see_count,c.price,c.stock,c.add_time,d.lat,d.lng')
                        ->join('collect b','a.user_id = b.user_id')
                        ->join('ad c','b.ad_id = c.ad_id')
                        ->join('user_data d','c.user_id = d.user_id')
                        ->where('a.user_id = '.$user_id)
                        ->limit($page_size *($page-1),$page_size)
                        ->select();
                if(!empty($arr['lat']) && !empty($arr['lng'])){
                    foreach($collect as $key => $val){
                        $collect[$key]['km_num'] = sprintf('%.2f',calcDistance($val['lat'],$val['lng'],$arr['lat'],$arr['lng']));
                    }
                }
                foreach ($collect as $key => $val) {
                    $collect[$key]['ad_img'] = explode(',',$val['ad_img']);
                    $collect[$key]['add_time'] = date('Y-m-d H:i:s',$val['add_time']);
                    unset($collect[$key]['lat']);
                    unset($collect[$key]['lng']);
                }
                if(!empty($collect)){
                    $res = array('code' => 1, 'data' => $collect);
                }else{
                    $res = array('code' => 2, 'msg' => '暂无数据');
                }
            }else{
                $res = array('code' => 2, 'msg' => '参数有误');
            }
            return jsonReturn($res);
        }
    }
    /*
    *  收藏
    */
    public function add_like()
    {
        $arr = $this->arr;
        if(!empty($arr)){
            $flag = true;
            if(empty($arr['user_id']) && empty($arr['ad_id'])){
                $flag = false;
            }
            if($flag){
                $user_id = $arr['user_id'];
                $ad_id = $arr['ad_id'];
                $ha1 = db('users')->where('user_id ='.$user_id)->find();
                $ha2 = db('ad')->where('ad_id ='.$ad_id)->find();
                if(!empty($ha1) && !empty($ha2)){
                    $where['user_id'] = $user_id;
                    $where['ad_id'] = $ad_id;
                    $have = db('collect')->where($where)->find();
                    if(!empty($have)){
                        $msg = '取消成功';
                        $ret = db('collect')->where($where)->delete();
                    }else {
                        $msg = '收藏成功';
                        $ret = db('collect')->insert(['user_id' => $user_id , 'ad_id' => $ad_id ]);
                    }
                    if($ret){
                        $res = array('code' => 1,'msg' => $msg);
                    }else{
                        $res = array('code' => 2, 'msg' => '失败');
                    }
                }
            }else{
                $res = array('code' => 2, 'msg' => '参数有误');
            }
            return jsonReturn($res);
        }
    }
    /*
    *  行业类别
    */
    public function cloumn(){
        $data = db('ad_column')->field('col_id,col_name')->where('is_show = 1')->select();
        $res['data'] = $data;
        return jsonReturn($res);
    }
    /*
    *  反馈 申请
    */
    public function feedback()
    {
        $arr = $this->arr;
        if(!empty($arr)){
            $flag = true;
            if(empty($arr['type']) && empty($arr['content']) && empty($arr['contact'])){
                $flag = false;
            }
            if($flag){
                $data['type'] = $arr['type'];                                       #反馈类型
                $data['content'] = $arr['content'];                                 #反馈内容
                $data['contact'] = $arr['contact'];                                 #联系方式
                $data['add_time'] = time();
                $ret = db('feedback')->insert($data);
                if($ret){
                    $res = array('code' => 1,'msg' => '反馈成功');
                }else{
                    $res = array('code' => 2,'msg' => '失败');
                }
            }else{
                $res = array('code' => 1,'msg' => '缺少参数');
            }
            return jsonReturn($res);
        }
    }
    /*
    *  登录
    */
    public function login(){
        $arr = $this->arr;
        if(!empty($arr)){
            $flag = true;
            if(empty($arr['user_name']) && empty($arr['password'])){
                $flag = false;
            }
            if($flag){
                $user_name = $arr['user_name'];
                $password = sysmd5($arr['password']);
                $have = db('users')->where('user_name = \''.$user_name .'\' and password = \''.$password.'\'')->find();
                if(!empty($have)){
                    $data = [];
                    Session('user_id',$have['user_id']);
                    $data['session_id'] = session_id();
                    $data['is_login'] = 1;
                    $data['login_time'] = time();
                    db('users')->where('user_id ='.$have['user_id'])->update($data);
                    $res = array('code' => 1,'user_id' => $have['user_id']);
                }else{
                    $res = array('code' => 2,'msg' => '用户名或者密码错误');
                }
            }else{
                $res = array('code' => 2,'msg'  => '缺少参数');
            }
            return jsonReturn($res);
        }
    }
    /*
    *  注册
    */
    public function reg(){
        $pt = file_get_contents("php://input");
        $arr = json_decode($pt,true);
        if(!empty($arr)){
            $flag = true;
            if(empty($arr['mobile']) && empty($arr['code']) && empty($arr['password'])){
                $flag = false;
            }
            if($flag){
                $data['mobile'] = $arr['mobile'];                            #手机号
                $code = $arr['code'];                                        #短信验证码
                $data['password'] = sysmd5($arr['password']);                #密码
                // 判断验证码是否正确
                // if($code == Session('c'.$arr['mobile'])){
                    $data['user_name'] = $data['mobile'];
                    $data['nickname'] = $data['mobile'];
                    $data['reg_time'] = time();
                    $data['head_img'] = '/static/img/default.jpg';
                    //存在邀请码为广告主，根据邀请码判断身份
                    if(!empty($arr['invite_code'])){
                        $invite_code = $arr['invite_code'];                      #邀请码
                        $invite = db('invite')->where('invite_code = \''.$invite_code .'\' and mobile ='.$data['mobile'])->find();
                        if(!empty($invite)){
                            $data['iden'] = $invite['iden'];
                            // 判断手机号是否存在，不存在则添加
                            $have = db('users')->where('mobile = '.$data['mobile'])->find();
                            if($have){
                                $status = 3;
                                $msg = '手机号已经存在';
                                $ret = '';
                            }else{
                                //广告主添加完成后把邀请码删除
                                db('invite')->where('invite_code = \''.$invite_code.'\'')->delete();
                                $ret = db('users')->insert($data);
                            }
                        }else{
                            $ret = '';
                            $status = 4;
                            $msg = '邀请码不存在或手机号不正确';
                        }
                    }else{
                        $msg = '';
                        $data['iden'] = 1;
                        $have = db('users')->where('mobile = '.$data['mobile'])->find();
                        if($have){
                            $status = 3;
                            $msg = '手机号已经存在';
                            $ret = '';
                        }else{
                            $ret = db('users')->insert($data);
                        }
                    }

                    if($ret){
                        $res = array('code' => 1, 'msg' => '成功' ,'user_id' => db('users')->getLastInsID());
                        Session('c'.$data['mobile'],null);
                    }else{
                        $res = array('code' => $status, 'msg'  => $msg);
                    }
                // }else{
                    // $res = array('code' => 2,'msg' => '验证码错误');
                // }
            }else{
                $res = array('code' => -1,'msg' => '缺少参数');
            }
            return jsonReturn($res);
        }
    }
    /*
    * 广告主资料填写
    */
    public function adowner_data(){
        $arr = $this->arr;
        if(!empty($arr)){
            $flag = true;

            if(empty($arr['name']) && empty($arr['user_id']) && empty($arr['column_id']) && empty($arr['tel']) && empty($arr['mobile']) && empty($arr['com_img']) && empty($arr['license_img']) && empty($arr['lng']) && empty($arr['lat'])){
                $flag = false;
            }
            $iden = db('users')->where('user_id = '.$arr['user_id'])->find();
            if(empty($iden) || $iden['iden'] == 1){
                $flag = false;
            }
            if($flag){
                $data['name'] = $arr['name'];                               #公司名称
                $data['user_id'] = $arr['user_id'];                         #用户id
                $data['column_id'] = $arr['column_id'];                     #类别id
                $data['tel'] = $arr['tel'];                                 #公司电话
                $data['mobile'] = $arr['mobile'];                           #手机号
                $com_img = $arr['com_img'];                                 #base64 公司图片
                $license_img = $arr['license_img'];                         #base64 营业执照
                $data['province'] = $arr['province'];                       #省
                $data['city'] = $arr['city'];                               #市
                $data['area'] = $arr['area'];                               #区
                $data['add'] = $arr['add'];                                 #具体地址
                $data['lng'] = $arr['lng'];                                 #经度
                $data['lat'] = $arr['lat'];                                 #纬度
                $data['add_time'] = time();
                $data['expire_time'] = strtotime('+1 year',time());         #过期时间
                $upload_url = ROOT_PATH .'public/static'.DS.'uploads/compony/';
                $ret = base_upload($upload_url,$com_img);
                // 判断用户是否填入数据 如果有 为修改数据，删除掉以前的图片，放进新的图片
                $have = db('user_data')->where('user_id ='.$arr['user_id'])->find();
                if($ret['code'] == 1){
                    if(!empty($have)){
                        @unlink(ROOT_PATH.'public'.$have['com_img']);
                    }
                    $data['com_img'] = $ret['url'];
                }
                $ret1 = base_upload($upload_url,$license_img);
                if($ret1['code'] == 1){
                    if(!empty($have)){
                        @unlink(ROOT_PATH.'public'.$have['license_img']);
                    }
                    $data['license_img'] = $ret1['url'];
                }
                // 设置审核状态
                $data['aud_status'] = 0;
                if(empty($have)){
                    $status = db('user_data')->insert($data);
                }else{
                    if($have['aud_status'] == 1){
                        $data['aud_status'] = 1;
                    }
                    $status = db('user_data')->where('user_id ='.$have['user_id'])->update($data);
                }
                if($status){
                    $res = array('code' => 1,'msg' => '成功' );
                }else{
                    $res = array('code' => 2,'msg' => '失败' );
                }
            }else{
                $res = array('code' => 2,'msg' => '参数有误');
            }
            return jsonReturn($res);
        }
    }
    /*
    * 获取广告主填写资料信息
    */
    public function get_data()
    {
        $arr = $this->arr;
        if(!empty($arr)){
            $flag = true;
            if(empty($arr['user_id'])){
                $flag = false;
            }
            if($flag){
                $user_id = $arr['user_id'];
                $data_info = db('users')
                            ->alias('a')
                            ->field('a.user_id,b.column_id,c.col_name,b.name,b.tel,b.mobile,b.province,b.city,b.area,b.add,b.com_img,b.license_img')
                            ->join('user_data b','a.user_id = b.user_id','left')
                            ->join('ad_column c','b.column_id = c.col_id','left')
                            ->where('a.user_id = '.$user_id)
                            ->find();
                if(!empty($data_info)){
                    $res = array('code' => 1,'data'  => $data_info);
                }else{
                    $res = array('code' => 2, 'msg' => '暂无数据');
                }
            }else {
                $res = array('code' => 2,'msg' => '参数有误' );
            }
            return jsonReturn($res);
        }
    }
    /*
    *  用户个人信息
    */
    public function user_info()
    {
        $arr = $this->arr;
        if(!empty($arr)){
            $flag = true;
            if(empty($arr['user_id'])){
                $flag = false;
            }
            if($flag){
                $user_id = $arr['user_id'];
                $user_info = db('users')
                            ->alias('a')
                            ->field('a.user_id,a.head_img,a.mobile,a.nickname,b.iden_name')
                            ->join('iden b','a.iden = b.iden_id')
                            ->where('user_id = '.$user_id)
                            ->find();
                if(!empty($user_info)){
                    $res = array('code' => 1,'data' => $user_info);
                }else{
                    $res = array('code' => 2,'msg' => '暂无' );
                }
            }else{
                $res = array('code' => 2,'msg' => '参数有误');
            }
            return jsonReturn($res);
        }
    }
    /*
    *  编辑个人信息
    */
    public function edit_info ()
    {
        $arr = $this->arr;
        if(!empty($arr)){
            $flag = true;
            if(empty($arr['user_id'])){
                $flag = false;
            }
            if($flag){
                $user_id = $arr['user_id'];
                if(!empty($arr['nickname'])){
                    $data['nickname'] = $arr['nickname'];
                    $res['nickname'] = $data['nickname'];
                }
                if(!empty($arr['head_img'])){
                    $up_url = ROOT_PATH .'public/static'.DS.'uploads/compony/';
        			$ret = base_upload($up_url,$arr['head_img']);
                    if($ret['code'] == 1){
                        $url = db('users')->field('head_img')->where('user_id',$user_id)->find();
                        if($url['head_img'] != '/static/img/default.jpg'){
                            @unlink(str_replace(' ','',ROOT_PATH.'public'.$url['head_img']));
                        }
                    }else{
                        $msg = '失败';
                    }
                    $data['head_img'] = $ret['url'];
                    $res['head_img'] = $data['head_img'];
                }
                if(!empty($data)){
                    $status = db('users')->where('user_id ='.$user_id)->update($data);
                    if($status){
                        $res['code'] = 1;
                        $res['msg'] = '修改成功';
                    }else{
                        unset($res['nickname']);
                        unset($res['head_img']);
                        $res['code'] = 2;
                        $res['msg'] = '失败';
                    }
                }else{
                    $res = array('code' => 2,'msg' => '没有任何改动' );
                }
            }else{
                $res = array('code' => 1,'msg' => '缺少参数');
            }
            return jsonReturn($res);
        }
    }
    /*
    *  修改手机号
    */
    public function edit_mobile(){
        $arr = $this->arr;
        if(!empty($arr)){
            $flag = true;
            if(empty($arr['user_id']) && empty($arr['old_mobile']) && empty($arr['new_mobile']) && empty($arr['code'])){
                $flag = false;
            }
            if($flag){
                $old_mobile = $arr['old_mobile'];
                $code = $arr['code'];
                $new_mobile = $arr['new_mobile'];
                if($code == Session('c'.$new_mobile)){
                    $have = db('users')->where('mobile = '.$old_mobile)->find();
                    if(!empty($have)){
                        $ret = db('users')->where('user_id ='.$have['user_id'])->update(['mobile' => $new_mobile]);
                        if($ret){
                            $res = array('code' => 1,'msg' => '成功');
                            Session('c'.$new_mobile,null);
                        }else{
                            $res = array('code' => 2,'msg' => '失败');
                        }
                    }else{
                        $res = array('code' => 2,'msg' => '手机号不存在');
                    }
                }else{
                    $res = array('code' => 2,'msg' => '验证码有误' );
                }
            }else{
                $res = array('code' => 1,'msg' => '缺少参数');
            }
            return jsonReturn($res);
        }
    }
}

<?php
namespace app\admin\controller;
use think\ValidateCode;
class Users extends Index
{
    /*
    * 管理员登录
    */
    public function login(){
        if($_POST){
            $user_name = $_POST['username'];
            $code = $_POST['code'];
            if($code == Session('vc')){
                Session('vc',null);
                if(!empty($_POST['password'])){
                    $password = sysmd5($_POST['password']);
                }else{
                    $this->error('请填写密码');
                }
                $user_info = db('admin')->where('user_name = \''.$user_name.'\' and password = \''.$password.'\'')->find();
                if(!empty($user_info)){
                    Session('admin',$user_info);
    				$ldata['admin_id'] = $user_info['admin_id'];
    				$ldata['log_info'] = '登录';
    				$ldata['log_ip'] = $_SERVER['REMOTE_ADDR'];
    				$ldata['log_url'] = request()->url(true);
    				$ldata['log_time'] = time();
                    db('admin_log')->insert($ldata);
                    $this->success('登录成功',url('admin/index'));
                }else{
                    $this->error('用户名或密码错误');
                }
            }else{
                $this->error('验证码错误');
            }
        }
        return $this->fetch();
    }
    /*
    * 退出
    */
    public function cancel()
    {
        Session('admin',null);
        if(Session('admin')){
            $this->error('失败');
        }else{
            $this->error('退出成功');
        }
    }
    /*
    * 显示验证码
    */
    public function capt(){
        $Validatecode = new ValidateCode();
        $Validatecode->doimg();
        Session('vc',$Validatecode->getCode());
        exit;
    }
    /*
    * 会员管理
    */
    public function user_list()
    {
        $user_list = db('users')->where('iden = 1')->paginate(10);
        $page = $user_list->render();
        $this->assign('page',$page);
        $this->assign('user_list',$user_list);
        return $this->fetch();
    }
    /*
    * 添加编辑用户
    */
    public function addedit_user()
    {
        $title = '用户添加';
        $iden_list = db('iden')->select();
        if(!empty($_GET['id'])){
            $title = '用户编辑';
            $id = $_GET['id'];
            $user_info = db('users')->where('user_id ='.$id)->find();
            $this->assign('info',$user_info);
        }else{
            $id = '';
        }
        if($_POST){
            $data['user_name'] = $_POST['user_name'];
            $data['mobile'] = $_POST['mobile'];
            $data['nickname'] = $_POST['nickname'];
            $data['iden'] = $_POST['iden'];
            if(!empty($_POST['password']) && !empty($_POST['password2']) && ($_POST['password'] == $_POST['password2'])){
                $data['password'] = sysmd5($_POST['password']);
            }else{
                if($_POST['password'] != $_POST['password2']){
                    $this->error('两次密码输入不一致');
                }
            }
            $data['head_img'] = '/static/img/default.jpg';
            $file = request()->file('image1');
            if($file){
                $info = $file->validate(['size'=>4194304,'ext'=>'jpg,jpeg,png,gif'])->move(ROOT_PATH.'public/static'.DS.'uploads/head');
                if($info){
                    if($id){
                        @unlink(ROOT_PATH.'public'.$user_info['head_img']);
                    }
                    $data['head_img'] = '/static/uploads/head/'.$info->getSaveName();
                }else {
                    $this->error($file->getError());
                }
            }
            if($id){
                $msg = '修改成功';
                $res = db('users')->where('user_id = '.$id)->update($data);
            }else{
                $msg = '添加成功';
                $res = db('users')->insert($data);
            }
            if($res){
                $this->success($msg,'users/user_list');
            }else{
                $this->error('失败');
            }
        }
        $this->assign('iden',$iden_list);
        $this->assign('title',$title);
        return $this->fetch();
    }
    /*
    * 删除会员
    */
    public function del_user(){
        if($_POST){
            $id = $_POST['id'];
            if(is_array($id)){
                foreach ($id as $key => $val) {
                    $res[] = db('users')->where('user_id ='.$val)->delete();
                }
            }else{
                $res = db('users')->where('user_id ='.$id)->delete();
            }
            if($res){
                $res = array('code' => 1, 'msg' => '删除成功');
            }else{
                $res = array('code' => 2, 'msg' => '失败');
            }
            return jsonReturn($res);
        }
    }
    /*
    *  广告主列表
    */
    public function ader_list (){
        $where = '1 = 1 and a.iden > 1';
        if($_POST){
            if(!empty($_POST['user_name'])){
                $user_name = $_POST['user_name'];
                $where .= ' and a.user_name REGEXP \''.$user_name.'\'';
                $this->assign('user_name',$user_name);
            }
            if(!empty($_POST['mobile'])){
                $mobile = $_POST['mobile'];
                $where .= ' and a.mobile ='.$mobile;
                $this->assign('mobile',$mobile);
            }
            if(!empty($_POST['com_name'])){
                $com_name = $_POST['com_name'];
                $where .= ' and b.name REGEXP \''.$com_name.'\'';
                $this->assign('com_name',$com_name);
            }
        }
        $ader_list = db('users')
                    ->alias('a')
                    ->field('a.user_id,a.user_name,a.head_img,a.mobile,a.nickname,c.col_name,b.name,b.tel,b.mobile as mobile1,b.add,b.com_img,b.license_img,b.aud_status,a.reg_time,a.login_time')
                    ->join('user_data b','a.user_id = b.user_id','left')
                    ->join('ad_column c','b.column_id = c.col_id','left')
                    ->where($where)
                    ->paginate(10);
        $this->assign('page',$ader_list->render());
        $this->assign('ader_list',$ader_list);
        return $this->fetch();
    }

    /*
    *  添加编辑广告主
    */
    public function addedit_ader()
    {
        $iden_list = db('iden')->select();
        $col_list = db('ad_column')->select();
        $title = '添加广告主';
        if(!empty($_GET['id'])){
            $title = '编辑广告主';
            $id = $_GET['id'];
            $ader_info = db('users')
                        ->alias('a')
                        ->field('a.user_id,a.user_name,a.head_img,a.head_img,a.mobile,a.nickname,a.iden,b.column_id as col_id,b.name,b.tel,b.mobile as mobile1,b.province,b.city,b.area,b.add,b.com_img,b.license_img,b.aud_status')
                        ->join('user_data b','a.user_id = b.user_id','left')
                        ->join('ad_column c','b.column_id = c.col_id','left')
                        ->where('a.user_id = '.$id)
                        ->find();
            $this->assign('info',$ader_info);
        }else{
            $id = '';
        }
        if($_POST){
            $udata['user_name'] = $_POST['user_name'];
            $udata['mobile'] = $_POST['mobile'];
            $udata['nickname'] = $_POST['nickname'];
            $udata['iden'] = $_POST['iden'];
            $udata['reg_time'] = time();
            $data['name'] = $_POST['name'];
            $data['tel'] = $_POST['tel'];
            $data['mobile'] = $_POST['mobile1'];
            $data['add'] = $_POST['add'];
            $data['aud_status'] = $_POST['aud_status'];
            $data['column_id'] = $_POST['col_id'];
            $data['add_time'] = time();
            if(!empty($_POST['password']) && !empty($_POST['password2']) && ($_POST['password'] == $_POST['password2'])){
                $udata['password'] = sysmd5($_POST['password']);
            }else{
                if($_POST['password'] != $_POST['password2']){
                    $this->error('两次密码输入不一致');
                }
            }
            $file1 = request()->file('image1');
            $file2 = request()->file('image2');
            $file3 = request()->file('image3');
            if($file1){
                $info = $file1->validate(['size'=>4194304,'ext'=>'jpg,jpeg,png,gif'])->move(ROOT_PATH.'public/static'.DS.'uploads/head');
                if($info){
                    if($id){
                        @unlink(ROOT_PATH.'public'.$ader_info['head_img']);
                    }
                    $udata['head_img'] = '/static/uploads/head/'.$info->getSaveName();
                }
            }
            if($file2){
                $info = $file2->validate(['size'=>4194304,'ext'=>'jpg,jpeg,png,gif'])->move(ROOT_PATH.'public/static'.DS.'uploads/compony');
                if($info){
                    if($id){
                        @unlink(ROOT_PATH.'public'.$ader_info['com_img']);
                    }
                    $data['com_img'] = '/static/uploads/compony/'.$info->getSaveName();
                }
            }
            if($file3){
                $info = $file3->validate(['size'=>4194304,'ext'=>'jpg,jpeg,png,gif'])->move(ROOT_PATH.'public/static'.DS.'uploads/compony');
                if($info){
                    if($id){
                        @unlink(ROOT_PATH.'public'.$ader_info['license_img']);
                    }
                    $data['license_img'] = '/static/uploads/compony/'.$info->getSaveName();
                }
            }
            if($id){
                $data_info = db('user_data')->where('user_id ='.$id)->find();
                $data['user_id'] = $id;
                if(!empty($data_info)){
                    if($data_info['aud_status'] == 3){
                        $data['expire_time'] = strtotime('+1 year',time());
                    }
                    $res[] = db('users')->where('user_id ='.$id)->update($udata);
                    $res[] = db('user_data')->where('user_id ='.$id)->update($data);
                }else{
                    $res[] = db('user_data')->insert($data);
                }
            }else{
                $res[] = db('users')->insert($udata);
                $data['user_id'] = db('users')->getLastInsId();
                $res[] = db('user_data')->insert($data);
            }
            if(!empty($res)){
                $this->success('成功','users/ader_list');
            }else{
                $this->error('失败');
            }
        }
        $aud_status = GetAudStatus2();
        $this->assign('aud_status',$aud_status);
        $this->assign('col_list',$col_list);
        $this->assign('iden',$iden_list);
        $this->assign('title',$title);
        return $this->fetch();
    }
    /*
    * 删除广告主
    */
    public function del_ader(){
        if($_POST){
            $id = $_POST['id'];
            if(is_array($id)){
                foreach ($id as $key => $val) {
                    $res[] = db('users')->where('user_id ='.$val)->delete();
                    db('user_data')->where('user_id ='.$val)->delete();
                }
            }else{
                $res = db('users')->where('user_id ='.$id)->delete();
                db('user_data')->where('user_id ='.$id)->delete();
            }
            if($res){
                $res = array('code' => 1, 'msg' => '删除成功');
            }else{
                $res = array('code' => 2, 'msg' => '失败');
            }
            return jsonReturn($res);
        }
    }
    /*
    *  身份列表
    */
    public function iden_list()
    {
        $iden_list = db('iden')->paginate(10);
        $this->assign('page',$iden_list->render());
        $this->assign('iden_list',$iden_list);
        return $this->fetch();
    }
    /*
    *  添加编辑身份
    */
    public function addedit_iden()
    {
        $title = '添加身份';
        if(!empty($_GET['id'])){
            $id = $_GET['id'];
            $title = '编辑身份';
            $iden_info = db('iden')->where('iden_id = '.$id)->find();
            $this->assign('info',$iden_info);
        }else{
            $id = '';
        }
        if($_POST){
            $data['iden_name'] = $_POST['iden_name'];
            $data['iden_power'] = $_POST['iden_power'];
            $data['position'] = $_POST['position'];
            if ($id) {
                $res = db('iden')->where('iden_id ='.$id)->update($data);
            }else {
                $res = db('iden')->insert($data);
            }
            if($res){
                $this->success('添加/修改成功','users/iden_list');
            }else{
                $this->error('失败');
            }
        }
        $this->assign('title',$title);
        return $this->fetch();
    }

}

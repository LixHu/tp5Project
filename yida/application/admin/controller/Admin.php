<?php
namespace app\admin\controller;
class Admin extends Index
{
    public function admin()
    {

        return $this->fetch();
    }
    /*
    * 权限列表
    */
    public function role_list()
    {
        $role_list = db('role')->select();
        return $role_list;
    }
    /*
    *  主页返回列表
    */
    public function index()
    {
        $admin_id = Session('admin')['admin_id'];
        $menu_list = db('admin_menu')
                    ->alias('a')
                    ->join('role_menu b','a.menu_id = b.menu_id')
                    ->join('role c','b.role_id = c.role_id')
                    ->join('admin d','c.role_id = d.role_id')
                    ->where('d.admin_id ='.$admin_id.' and a.pid = 0')
                    ->select();
        foreach ($menu_list as $key => $val) {
            $menu_list[$key]['child'] = db('admin_menu')
                            ->alias('a')
                            ->join('role_menu b','a.menu_id = b.menu_id')
                            ->join('role c','b.role_id = c.role_id')
                            ->join('admin d','c.role_id = d.role_id')
                            ->where('d.admin_id ='.$admin_id.' and a.pid = '.$val['menu_id'])
                            ->select();
         }
         // dump($menu_list);
        $this->assign('menu_list',$menu_list);
        return view();
    }
    /*
    *  退出登录
    */
    public function re_login()
    {
        Session('admin',null);
        if (empty(Session('admin'))) {
            $this->success('退出成功',url('admin/login'));
        }
    }
    /*
    * 登录
    */
    public function login()
    {
        if ($_POST) {
            if(empty($_POST['user_name']) && empty($_POST['password'])){
                $this->error('请填写用户名密码');
            }else{
                $user_name = $_POST['user_name'];
                $password = $_POST['password'];
                $where = 'user_name =\''.$user_name.'\' and password =\''.sysmd5($password).'\'';
                $admin_info = db('admin')->where($where)->find();
                if(!empty($admin_info)) {
                    $data['login_time'] = time();
                    Session('admin',$admin_info);
                    db('admin')->where('admin_id = '.$admin_info['admin_id'])->update($data);
                    $this->success('登录成功',url('admin/index'));
                }else{
                    $this->error('用户名或者密码错误');
                }
            }
        }
        return $this->fetch();
    }
    /*
    *  管理员列表
    */
    public function admin_list()
    {
        if ($_POST) {
            $page = 1;
            $pagesize = 10;
            if (!empty($_POST['page'])) {
                $page = $_POST['page'];
            }
            $ad_list['data'] = db('admin')->alias('a')->join('role b','a.role_id = b.role_id')->limit($pagesize*($page -1).','.$pagesize)->select();
            foreach ($ad_list['data'] as $key => $value) {
                if (!empty($value['login_time'])) {
                    $ad_list['data'][$key]['login_time'] = date("Y-m-d H:i:s",$value['login_time']);
                }
            }
            $ad_list['count'] = db('admin')->count();
            return $ad_list;
        }
        return $this->fetch();
    }
    /*
    *  管理员个人信息
    */
    public function admin_info()
    {
        if($_POST){
            if(!empty($_POST['id'])) {
                $id = $_POST['id'];
                $info = db('admin')->where('admin_id = '.$id)->find();
                return $info;
            }
        }
    }
    /*
    *  添加编辑管理员
    */
    public function addedit_admin()
    {
        if ($_POST) {
            $data = [];
            if(!empty($_POST['image'])) {
                $up_dir = ROOT_PATH . 'public\static' . DS . 'upload\admin\\';
                $base = $_POST['image'];
                $res = base_upload($up_dir,$base);
                if($res['code'] == 1){
                    $data['header_img'] = $res['url'];
                }
            }
            if(!empty($_POST['user_name'])){
                $data['user_name'] = $_POST['user_name'];
            }
            if(!empty($_POST['mobile'])) {
                $data['mobile'] = $_POST['mobile'];
            }
            if (!empty($_POST['email'])) {
                $data['email'] = $_POST['email'];
            }
            if (!empty($_POST['password'])) {
                $password = $_POST['password'];
                $password2 = $_POST['password2'];
                if ($password == $password2) {
                    $data['password']  = sysmd5($password);
                }else {
                    $ret = array('code' => 2, 'msg' => '两次输入密码不一致');
                    return $ret;
                }
            }
            $have = db('admin')->where('user_name = \''.$data['user_name'].'\'')->find();
            //用户名已经存在，不做更新和添加
                if(!empty($_POST['admin_id'])) {
                    $id = $_POST['admin_id'];
                    $msg = '';
                    $result = db('admin')->where('admin_id ='.$id)->update($data);
                }else {
                    // 头像为空，修改为默认头像
                    if(empty($data['header_img'] )) {
                        $data['header_img'] = '/static/img/default.png';
                    }
                    if(empty($data['password'])) {
                        $result = '';
                        $msg = '添加管理员请输入密码';
                    }else{
                        if(empty($have)) {
                            $result = db('admin')->insert($data);
                        }else{
                            $result = '';
                            $msg = '用户名已存在';
                        }
                    }
                }
                if ($result) {
                    $ret = array('code' => 1, 'msg' => '成功');
                }else{
                    $ret = array('code' => 2, 'msg' => $msg ? $msg:'失败');
                }
                return $ret;
        }
        return $this->fetch();
    }
    /*
    *  删除管理员
    */
    public function del_admin()
    {
        if ($_POST) {
            $id = $_POST['id'];
            $res = db('admin')->where('admin_id = '.$id)->delete();
            if ($res) {
                $ret = array('code' => 1, 'msg' => '删除成功');
            }else {
                $ret = array('code' => 2, 'msg' => '失败');
            }
            return $ret;
        }
    }


    /*
    * 角色添加
    */
    public function add_role(){
        $role = db('role')->select();
        $menu_list = db('admin_menu')->where('pid = 0 and is_show = 1')->select();
        foreach($menu_list as $key => $val){
            $children = db('admin_menu')->where('is_show = 1 and pid = '.$val['menu_id'])->select();
            if(!empty($children)){
                $menu_list[$key]['children'] =	$children;
            }
        }
        //添加角色，添加角色权限
        if($_POST){

            $id = db('role')->insert(array("role_name" => input('role_name'),'role_desc' => $_POST['desc']));
            $lastid = db('role')->getLastInsID();
            $data['role_id'] = $lastid;
            if(!empty($_POST['id'])){
                $id = $_POST['id'];
                foreach($id as $k => $v){
                    $data['menu_id'] = $v;
                    $have = db('role_menu')->where($data)->find();
                    if(empty($have) && $data['role_id'] != 0){
                        $resault = db('role_menu')->insert($data);
                    }
                }
                $resault = $id;
            }
            if($id){
                $this->success('角色添加成功',url('admin/role_list'));
            }
        }
        $this->assign('menu',$menu_list);
        $this->assign('role',$role);
        return $this->fetch();
    }
    /*
    * 权限管理
    */
    public function edit_role(){
        $role = db('admin_role')->select();
        $left_list = db('admin_menu')->where('pid = 0 and is_show = 1')->select();
        foreach($left_list as $key => $val){
            $children = db('admin_menu')->where('is_show = 1 and pid = '.$val['menu_id'])->select();
            if(!empty($children)){
                $left_list[$key]['children'] =	$children;
            }
        }
        if(!empty($_GET)){
            //根据id找到权限显示出来
            $role_name = db('admin_menu')
                ->alias('a')
                ->field('a.menu_id')
                ->join('role_menu b','b.menu_id = a.menu_id')
                ->join("admin_role c",'b.role_id = c.role_id')
                ->where('a.is_show = 1 and c.role_id = '.$_GET['id'])
                ->select();
            $role_id = db('admin_role')->find($_GET['id']);
            $this->assign('role_id',$role_id);
            $this->assign('role_name',$role_name);
        }
        // 提交表单
        if($_POST){
            $data['role_id'] = $_POST['role_id'];
            db('admin_role')->where('role_id =' .$data['role_id'])->update(['role_desc' => $_POST['desc'] ]);
            if(!empty($_POST['id'])){
                $id = $_POST['id'];
                db('role_menu')->where($data)->delete();
                foreach($id as $k => $v){
                    $data['menu_id'] = $v;
                    $have = '';
                    if(empty($have) && $data['role_id'] != 0){
                        $resault = db('role_menu')->insert($data);
                    }
                }
            }else{
                $resault = '';
            }

            if($resault){
                $this->success('修改成功');
            }
        }
        $this->assign('menu',$left_list);
        $this->assign('role',$role);
        return $this->fetch();
    }
    /*
    * 网站设置
    */
    public function setwebconf()
    {
        $com_info = db('company')->find();
        if ($_POST) {
            $data = [];
            // logo qrcode
            $logo = request()->file('logo');
            if ($logo) {
                $info = $logo->validate(['size' => 412000,'ext' => 'jpg,png,gif,jpeg'])->move(ROOT_PATH . 'public/static' . DS . 'upload/company');
                if ($info) {
                    @unlink(OOT_PATH . 'public/'.$com_info['logo']);
                    $data['logo'] = '/static/upload/company/'.$info->getSaveName();
                }else {
                    $this->error($logo->getError());
                }
            }
            $qrcode = request()->file('qrcode');
            if ($qrcode) {
                $info = $qrcode->validate(['size' => 412000,'ext' => 'jpg,png,gif,jpeg'])->move(ROOT_PATH . 'public/static' . DS . 'upload/company');
                if ($info) {
                    @unlink(OOT_PATH . 'public/'.$com_info['qrcode']);
                    $data['qrcode'] = '/static/upload/company/'.$info->getSaveName();
                }else {
                    $this->error($qrcode->getError());
                }
            }
            $com_img = request()->file('com_img');
            if ($com_img) {
                $info = $com_img->validate(['size' => 412000,'ext' => 'jpg,png,gif,jpeg'])->move(ROOT_PATH . 'public/static' . DS . 'upload/company');
                if ($info) {
                    @unlink(OOT_PATH . 'public/'.$com_info['com_img']);
                    $data['com_img'] = '/static/upload/company/'.$info->getSaveName();
                }else {
                    $this->error($com_img->getError());
                }
            }
            $data['title'] = $_POST['title'];
            $data['com_name'] = $_POST['com_name'];
            $data['com_phone'] = $_POST['com_phone'];
            $data['com_email'] = $_POST['com_email'];
            $data['sale_phone'] = $_POST['sale_phone'];
            $data['server_phone'] = $_POST['server_phone'];
            $data['free_server_phone'] = $_POST['free_server_phone'];
            $data['control_phone'] = $_POST['control_phone'];
            $data['free'] = $_POST['free'];
            $data['summary'] = htmlspecialchars($_POST['summary']);
            $data['update_time'] = time();
            $res = db('company')->where('com_id = 1')->update($data);
            // dump($data);
            if ($res) {
                $this->success('修改成功');
            }else {
                $this->error('失败');
            }
        }
        $com_info['summary'] = htmlspecialchars_decode($com_info['summary']);
        $this->assign('info',$com_info);
        return $this->fetch();
    }
    /*
    * 企业之家
    */
    public function under_com()
    {
        $under_list = db('under_com')->paginate(10);
        $this->assign('list',$under_list);
        $this->assign('page',$under_list->render());
        return  view();
    }
    /*
     *  添加编辑 公司
    */
    public function addedit_under()
    {
        $title = '添加企业';
        $id = '';
        if (!empty($_GET['id'])) {
            $id = $_GET['id'];
            $title = '编辑企业';
            $under_info = db('under_com')->where('under_com_id = '.$id)->find();
            $this->assign('info',$under_info);
        }
        if ($_POST) {
            if (!empty($_POST['com_name']) && !empty($_POST['com_desc']) && !empty($_POST['com_content'])) {
                $data['com_name'] = $_POST['com_name'];
                $data['com_desc'] = $_POST['com_desc'];
                $data['com_content'] = htmlspecialchars($_POST['com_content']);
                $file = request()->file('img');
                if ($file) {
                     $info = $file->validate(['size'=>412000,'ext'=>'jpg,jpeg,png,gif'])->move(ROOT_PATH . 'public/static' . DS . 'upload/under');
                     if($info) {
                         if ($id) {
                             @unlink(ROOT_PATH.'public'.$case_info['com_img']);
                         }
                         $data['com_img'] = '/static/upload/under/'.$info->getSaveName();
                     }else {
                         $this->error($file->getError());
                     }
                }
                if ($id) {
                    $ret = db('under_com')->where('under_com_id ='.$id)->update($data);
                }else{
                    $data['is_show'] = 1;
                    $data['add_time'] = time();
                    $ret = db('under_com')->insert($data);
                }
                if ($ret) {
                    $this->success('成功',url('admin/under_com'));
                }else {
                    $this->error('失败');
                }
            }else {
                $this->error('缺少参数');
            }
        }
        $this->assign('title',$title);
        return view();
    }
    /*
    * 更改状态
    */
    public function up_status(){
        if($_POST){
            if(!empty($_POST['type']) && !empty($_POST['status']) && !empty($_POST['under_com_id'])) {
                $type = $_POST['type'];
                $status = $_POST['status'];
                if($status == 1){
                    $status = 2;
                }else {
                    $status = 1;
                }
                $data[$type] = $status;
                $where['under_com_id'] = $_POST['under_com_id'];
                $ret = db('under_com')->where($where)->update($data);
                if ($ret) {
                    $res = array('code' => 1, 'msg' => '修改成功');
                }else {
                    $res = array('code' => 2, 'msg' => '失败');
                }
            }else {
                $res = array('code' => 2,'msg' => '缺少参数');
            }
            return $res;
        }
    }

    /*
    * 删除公司
    */
    public function del_under(){
        if($_POST){
            $id = $_POST['id'];
            if(is_array($id)){
                foreach ($id as $key => $val) {
                    $res[] = db('under_com')->where('under_com_id ='.$val)->delete();
                }
            }else{
                $res = db('under_com')->where('under_com_id ='.$id)->delete();
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
    * 易大实景
    */
    public function edit_yida()
    {

        return view();
    }
    /*
    *   易大实景图片列表
    */
    public function img_list()
    {
        $list = db('real')->select();
        $arr = [];
        if (!empty($list)) {
            foreach ($list as $key => $val) {
                $arr[$key]['file']['name'] = $val['img_url'];
                $arr[$key]['file']['src'] = base64EncodeImage(ROOT_PATH.'public'.DS.$val['img_url']);
            }
        }
        return $arr;
    }
    /*
    * 上传易大实景
    */
    public function uploadsj()
    {
        if ($_POST) {
            $flag = true;
            $dir = ROOT_PATH . 'public/static' . DS . 'upload/company/';
            $img_list = db('real')->select();
            foreach ($img_list as $key => $val) {
                @unlink(ROOT_PATH.'public'.$val['img_url']);
            }
            db('real')->where('1=1')->delete();
            foreach ($_POST['data'] as $key => $val) {
                $arr = json_decode($val,true);
                $res = base_upload($dir,$arr['src']);
                if ($res['code'] == 1) {
                    // 存入数据库 地址信息
                    $data['img_url'] = $res['url'];
                    db('real')->insert($data);
                }else {
                    // 上传失败
                    $index = $key;
                    $flag = false;
                }
            }
            if ($flag) {
                $ret = array('code' => 1, 'msg' => '上传成功');
            }else {
                $ret = array('code' => 2 , 'msg' => '第'. $index+1  .'图片上传未成功');
            }
            return $ret;
        }
    }
    /*
    * 深耕行业
    */
    public function edit_shen()
    {
        $id = '';
        if(!empty($_GET['id'])) {
            $id = $_GET['id'];
            $shen_info = db('sheng')->where('s_id = '.$id)->find();
            $this->assign('info',$shen_info);
        }
        if ($_POST) {
            if (!empty($_POST['pid']) && !empty($_POST['s_content'])) {
                $data['pid'] = $_POST['pid'];
                $data['s_content'] = $_POST['s_content'];
                if ($id) {
                    $res = db('sheng')->where('s_id ='.$id)->update($data);
                }else {

                    if ($data['pid']) {
                        $have = db('sheng')->where('pid ='.$data['pid'])->find();
                        if (!empty($have)) {
                            $res = db('sheng')->where('pid = '.$data['pid'])->update($data);
                        }else {
                            $res = db('sheng')->insert($data);
                        }
                    }else {
                        $count = db('sheng')->where('pid ='.$data['pid'])->count();
                        if ($count) {
                            $res = '';
                            $msg = '每个分类添加一条描述';
                        }else {
                            $res = db('sheng')->insert($data);
                        }
                    }
                }
                if ($res) {
                    $this->success('添加/修改成功',url('admin/shen_list'));
                }else {
                    $this->error(!empty($msg)?$msg:'失败');
                }
            }
        }
        return view();
    }
    /*
    *  深耕行业列表
    */
    public function shen_list()
    {
        $shen_list = db('sheng')->paginate(10);
        $this->assign('page',$shen_list->render());
        $this->assign('list',$shen_list);
        return view();
    }
}

<?php
namespace app\admin\controller;
use app\admin\model\Event;
use app\admin\model\Contact;
use app\admin\model\Admins;
use app\admin\model\Role;
use app\admin\model\Email;
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
                    ->join('admins d','c.role_id = d.role_id')
                    ->where('d.admin_id ='.$admin_id.' and a.pid = 0')
                    ->select();
        foreach ($menu_list as $key => $val) {
            $menu_list[$key]['child'] = db('admin_menu')
                            ->alias('a')
                            ->join('role_menu b','a.menu_id = b.menu_id')
                            ->join('role c','b.role_id = c.role_id')
                            ->join('admins d','c.role_id = d.role_id')
                            ->where('d.admin_id ='.$admin_id.' and a.pid = '.$val['menu_id'])
                            ->select();
         }
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
                $admin_info = db('admins')->where($where)->find();
                if(!empty($admin_info)) {
                    $data['login_time'] = time();
                    Session('admin',$admin_info);
                    db('admins')->where('admin_id = '.$admin_info['admin_id'])->update($data);
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
        $list = Admins::alias('a')->join('role b','a.role_id = b.role_id')->paginate(10);
        $this->assign('page',$list->render());
        $this->assign('list',$list);
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
        $title = '添加管理员';
        $id = '';
        $role = Role::all();
        if (!empty($_GET['id'])) {
            $id = $_GET['id'];
            $title = '编辑管理员';
            $admin_info = Admins::get($id);
            $this->assign('info',$admin_info);
        }
        if ($_POST) {
            $admin = new Admins;
            $data = [];
            $data = $_POST;
            $file = request()->file('header_img');
            if ($file) {
                $info = $file->validate(['size' => 4194304,'ext' => 'jpg,jpeg,gif,png'])->move(ROOT_PATH.'public/static'.DS.'upload/admin');
                if ($info) {
                    if ($id) {
                        @unlink(ROOT_PATH.'public'.$admin_info['header_img']);
                    }
                    $data['header_img'] = '/static/upload/admin/'.$info->getSaveName();
                }else {
                    $this->error($file->getError());
                }
            }
            if ($data['password'] != $_POST['password2']) {
                $this->error('两次密码输入不一致');
            }
            if (empty($data['password'])) {
                unset($data['password']);
            }else {
                $data['password'] = sysmd5($data['password']);
            }
            if ($id) {
                $ret = $admin->allowField(true)->save($data,['admin_id' => $id]);
            }else {
                $ret = $admin->allowField(true)->save($data);
            }
            if ($ret) {
                $this->success('成功',url('admin/admin_list'));
            }else {
                $this->error('失败');
            }
        }
        $this->assign('role',$role);
        $this->assign('title',$title);
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
                $info = $logo->validate(['size' => 4194304,'ext' => 'jpg,png,gif,jpeg'])->move(ROOT_PATH . 'public/static' . DS . 'upload/company');
                if ($info) {
                    @unlink(OOT_PATH . 'public/'.$com_info['logo']);
                    $data['logo'] = '/static/upload/company/'.$info->getSaveName();
                }else {
                    $this->error($logo->getError());
                }
            }
            $qrcode = request()->file('qrcode');
            if ($qrcode) {
                $info = $qrcode->validate(['size' => 4194304,'ext' => 'jpg,png,gif,jpeg'])->move(ROOT_PATH . 'public/static' . DS . 'upload/company');
                if ($info) {
                    @unlink(OOT_PATH . 'public/'.$com_info['qrcode']);
                    $data['qrcode'] = '/static/upload/company/'.$info->getSaveName();
                }else {
                    $this->error($qrcode->getError());
                }
            }
            $com_img = request()->file('com_img');
            if ($com_img) {
                $info = $com_img->validate(['size' => 4194304,'ext' => 'jpg,png,gif,jpeg'])->move(ROOT_PATH . 'public/static' . DS . 'upload/company');
                if ($info) {
                    @unlink(OOT_PATH . 'public/'.$com_info['com_img']);
                    $data['com_img'] = '/static/upload/company/'.$info->getSaveName();
                }else {
                    $this->error($com_img->getError());
                }
            }
            $data['title'] = $_POST['title'];
            // $data['com_name'] = $_POST['com_name'];
            $data['keywo'] = $_POST['keywo'];
            $data['address'] = htmlspecialchars($_POST['address']);
//            $data['indexdesc'] = $_POST['indexdesc'];
            $data['com_email'] = $_POST['com_email'];
            $data['sale_phone'] = $_POST['sale_phone'];
            $data['address1'] = htmlspecialchars($_POST['address1']);
            // $data['server_phone'] = $_POST['server_phone'];
            $data['fax'] = $_POST['fax'];
            $data['website'] = $_POST['website'];
            // $data['free'] = $_POST['free'];
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
    * event
    */
    public function event()
    {
        $list = Event::paginate(10);
        $this->assign('page',$list->render());
        $this->assign('list',$list);
        return view();
    }
    /*
    * addedit_event
    */
    public function addedit_event()
    {
        $title = '添加事件';
        $id = '';
        if (!empty($_GET['id'])) {
            $title = '编辑事件';
            $id = $_GET['id'];
            $einfo = Event::get($id);
            $this->assign('info',$einfo);
        }
        if ($_POST) {
            $event = new Event;
            $data = $_POST;
            $data['etime'] = strtotime($_POST['etime']);
            $file = request()->file('eimg');
            if($file) {
                $info = $file->validate(['size' => 4194304 ,'ext'=>'jpg,jpeg,png,gif'])->move(ROOT_PATH . 'public/static' . DS . 'upload/event/');
                if ($info) {
                    if ($id) {
                        @unlink(ROOT_PATH . 'public'.$einfo['eimg']);
                    }
                    $data['eimg'] = '/static/upload/event/'.$info->getSaveName();
                }else {
                    $this->error($file->getError());
                }
            }
            if ($id) {
                $ret = $event->allowField(true)->save($data,['eid' => $id]);
            }else {
                $data['is_show'] = 2;
                $ret = $event->allowField(true)->save($data);
            }
            if ($ret) {
                $this->success('成功',url('admin/event'));
            }else {
                $this->error('失败');
            }
        }
        $this->assign('title',$title);
        return view();
    }
    /*
    * contact_us
    */
    public function message()
    {
        $list = Contact::paginate(10);
        $this->assign('page',$list->render());
        $this->assign('list',$list);
        return view();
    }
    /*
    * email
    */
    public function email()
    {
        $list = Email::paginate(10);
        $this->assign('page',$list->render());
        $this->assign('list',$list);
        return view();
    }
    /*
    * edit_about
    */
    public function edit_about()
    {

        return view();
    }

    public function img_list()
    {
        $list = db('real')->select();
        $arr = [];
        if (!empty($list)) {
            foreach ($list as $key => $val) {
                $arr[$key]['file']['name'] = $val['img_url'];
                $arr[$key]['file']['src'] = base64EncodeImage(ROOT_PATH.'public'.$val['img_url']);
            }
        }
        return $arr;
    }
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
}

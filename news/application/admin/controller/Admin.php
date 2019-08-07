<?php
namespace app\admin\controller;

class Admin extends Index
{
    public function index()
    {
        return $this->fetch();
    }
    /*
    * 管理员列表
    */
    public function admin_list()
    {
        $where = '1=1';
        if(!empty($_POST['keyword'])){
             $where .= ' and a.user_name REGEXP \''.$_POST['keyword'].'\' or a.mobile REGEXP \''.$_POST['keyword'].'\'';
             $this->assign('keyword',$_POST['keyword']);
        }
        $admin_list = db('admin')->alias('a')->join('admin_role b','a.role_id = b.role_id')->where($where)->paginate(10);
        $page = $admin_list->render();
        $this->assign('page',$page);
        $this->assign('admin_list',$admin_list);
        return $this->fetch();
    }
    /*
    * 添加、编辑管理员
    */
    public function addedit_admin()
    {
        if(!empty($_GET['id'])){
            $id = $_GET['id'];
            $admin_info = db('admin')->where('admin_id ='.$id)->find();
            $this->assign('info',$admin_info);
        }else{
            $id = '';
        }
        $role_list = db('admin_role')->select();
        if($_POST){
            $data['user_name'] = $_POST['user_name'];
            $data['mobile'] = $_POST['mobile'];
            $data['nickname'] = $_POST['nickname'];
            if(!empty($_POST['role_id'])){
                $data['role_id'] = $_POST['role_id'];
            }else{
                $this->error('请选择角色');
            }
            if(!empty($_POST['password']) && !empty($_POST['password2']) && ($_POST['password'] == $_POST['password2'])){
                $data['password'] = sysmd5($_POST['password']);
            }else{
                if($_POST['password'] != $_POST['password2']){
                    $this->error('两次密码输入不一致');
                }
            }
            $file = request()->file('image1');
            if($file){
                $info = $file->validate(['size'=>4194304,'ext'=>'jpg,jpeg,png,gif'])->move(ROOT_PATH .'public/static'.DS.'uploads/head');
                if($info){
                    if($id){
                        if($admin_info['head_img'] != '/static/img/default.jpg'){
                            @unlink(ROOT_PATH.'public'.DS.$admin_info['head_img']);
                        }
                    }
                    $data['head_img'] = '/static/uploads/head/'.$info->getSaveName();
                }else{
                    $this->error($file->getError());
                }
            }
            if($id){
                $res = db('admin')->where('admin_id ='.$id)->update($data);
            }else{
                $data['add_time'] = time();
                if(db('admin')->where('user_name = \''.$data['user_name'].'\'')->find()){
                    $this->error('用户名已经存在');
                }else{
                    $res = db('admin')->insert($data);
                }
            }
            if($res){
                $this->success('添加/修改成功','admin/admin_list');
            }else{
                $this->error('失败');
            }
        }
        $this->assign('role',$role_list);
        return $this->fetch();
    }
    /*
    * 删除管理员
    */
    public function del_admin(){
        if($_POST){
            $id = $_POST['id'];
            if(is_array($id)){
                foreach ($id as $key => $val) {
                    $res[] = db('admin')->where('admin_id ='.$val)->delete();
                }
            }else{
                $res = db('admin')->where('admin_id ='.$id)->delete();
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
    * 角色列表
    */
    public function role_list()
    {
        $role_list = db('admin_role')->where('is_show = 1')->paginate(10);
        $page = $role_list->render();
        $this->assign('page',$page);
        $this->assign('role_list',$role_list);
        return $this->fetch();
    }
    /*
    * 角色添加
    */
    public function add_role(){
        $role = db('admin_role')->select();
        $menu_list = db('admin_menu')->where('pid = 0 and is_show = 1')->select();
        foreach($menu_list as $key => $val){
            $children = db('admin_menu')->where('is_show = 1 and pid = '.$val['menu_id'])->select();
            if(!empty($children)){
                $menu_list[$key]['children'] =	$children;
            }
        }
        //添加角色，添加角色权限
        if($_POST){

            $id = db('admin_role')->insert(array("role_name" => input('role_name'),'role_desc' => $_POST['desc']));
            $lastid = db('admin_role')->getLastInsID();
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
            // dump(!empty($children));
            // if(!empty($children)){
                $left_list[$key]['children'] =	$children;
            // }
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
    * 删除角色及权限
    */
    public function del_role(){
        if($_POST){
            $id = $_POST['id'];
            if(is_array($id)){
                foreach ($id as $key => $val) {
                    $res[] = db('admin_role')->where('role_id ='.$val)->delete();
                    db('role_menu')->where('role_id ='.$val)->delete();
                }
            }else{
                $res = db('admin_role')->where('role_id ='.$id)->delete();
                db('role_menu')->where('role_id ='.$id)->delete();
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
    *  常见问题列表
    */
    public function problem_list()
    {
        $pro_list = db('problem')->paginate(10);
        $this->assign('page',$pro_list->render());
        $this->assign('pro_list',$pro_list);
        return $this->fetch();
    }
    /*
    *  添加、编辑问题
    */
    public function addedit_pro()
    {
        $title = '添加问题';
        $id = '';
        if(!empty($_GET['id'])){
            $title = '编辑问题';
            $id = $_GET['id'];
            $pro_info = db('problem')->where('pro_id = '.$id)->find();
            $this->assign('info',$pro_info);
        }
        if($_POST){
            $data['pro_name'] = $_POST['pro_name'];
            $data['pro_content'] = $_POST['pro_content'];
            if($id){
                $res = db('problem')->where('pro_id = '.$id)->update($data);
            }else{
                $data['add_time'] = time();
                $res = db('problem')->insert($data);
            }
            if($res){
                $this->success('添加/修改成功','admin/problem_list');
            }else{
                $this->error('失败');
            }
        }
        $this->assign('title',$title);
        return $this->fetch();
    }
    /*
    * 删除问题
    */
    public function del_problem(){
        if($_POST){
            $id = $_POST['id'];
            if(is_array($id)){
                foreach ($id as $key => $val) {
                    $res[] = db('problem')->where('pro_id ='.$val)->delete();
                }
            }else{
                $res = db('problem')->where('pro_id ='.$id)->delete();
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
    *  设置推荐时间
    */
    public function set_groom()
    {
        $gr_list = db('groom')->paginate(10);
        $this->assign('page',$gr_list->render());
        $this->assign('gr_list',$gr_list);
        return $this->fetch();
    }
    /*
    * 添加编辑、推荐时长
    */
    public function addedit_groom()
    {
        $title = '添加推荐时间';
        $id = '';
        $type_list = GetGroomType2();
        if(!empty($_GET['id'])){
            $title = '编辑推荐时间';
            $id = $_GET['id'];
            $g_info = db('groom')->where('t_id = '.$id)->find();
            $this->assign('info',$g_info);
        }
        if($_POST){
            $data['t_name'] = $_POST['t_name'];
            $data['t_time'] = $_POST['t_time'];
            $data['t_type'] = $_POST['t_type'];
            if ($id) {
                $res = db('groom')->where('t_id ='.$id)->update($data);
            }else{
                $res = db('groom')->insert($data);
            }
            if ($res) {
                $this->success('成功','admin/set_groom');
            }else{
                $this->error('失败');
            }
        }
        $this->assign('type_list',$type_list);
        $this->assign('title',$title);
        return $this->fetch();
    }
    /*
    * 删除推荐时间
    */
    public function del_groom(){
        if($_POST){
            $id = $_POST['id'];
            if(is_array($id)){
                foreach ($id as $key => $val) {
                    $res[] = db('groom')->where('t_id ='.$val)->delete();
                }
            }else{
                $res = db('groom')->where('t_id ='.$id)->delete();
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
    *  设置app 联系方式
    */
    public function setting()
    {
        $tel = db('websetting')->find();
        $this->assign('tel',$tel['tel']);
        if($_POST){
            $tel = $_POST['tel'];
            if(preg_match("/^((0\d{2,3}-\d{6,8})|(1[35784]\d{9}))$/",$tel))
            {
                if(db('websetting')->where('1=1')->update(['tel' => $tel])) {
                    $this->success('修改成功',url('admin/setting'));
                }else{
                    $this->error('未做任何修改');
                }
            }else{
                $this->error('格式有误');
            }
        }
        return $this->fetch();
    }
}

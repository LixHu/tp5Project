<?php
namespace app\boquan\controller;
use app\boquan\model\AdMessage;
use think\Request;
use think\Db;
use think\Session;

/**
 *  System 系统管理
 */
class System extends Index
{

    /**
     * 信息、公告列表
     */
    public function system_info()
    {
        // 实例化模型类
        $ad = new AdMessage();
        // 调用模型类里的方法
        $message_list = $ad->getMessageAll();
        $page = $message_list->render();
        $res = $message_list->isEmpty();//判断数据集
        $this->assign('res', $res);
        $this->assign('page', $page);
        $this->assign('message_list', $message_list);

        return view();
    }
    /**
     * 信息、公告详情
     */
    public function message_deta()
    {
        // 接受id
        $id = input('get.id');
        // 实例化模型类
        $md = new AdMessage();
        // 调用模型类方法
        $message_deta = $md->getmessage($id);

        $this->assign('message_deta', $message_deta);

        return view();
    }
    /**
     * [admessage 发布公告]
     */
    public function admessage()
    {
        // 判断是否是post提交数据
        if ($_POST) {
            $param = input('post.');
            $param['ad_time'] = time();
            $param['gid'] = json_decode(session('user')['gid']);//获取到当前操作用户的分类ID
            // 实例化模型类
            $message = new AdMessage();
            // 调用模型内的方法，并把返回的结果赋值给 $res
            $res = $message->addmessage($param);
            if ($res) {
                return $this->redirect('System/admessage');
            } else {
                return $this->error('发布失败,请刷新页面重新操作');
            }
        }
        return view();
    }
    /**
     * 编辑信息
     */
    public function edit_mes()
    {   

        // 判断是否有数据传递过来
        if ($_POST) {
            // 接收数据
            $param = input('post.');
            
            // 实例化模型
            $se = new AdMessage();
            $ep = $se->editmes($param);
            if (! empty($ep)) {
                $this->redirect('System/system_info');
            } else {
                $this->error('编辑失败');
            }
        }

        $id = input('param.id');
        
        // 实例化模型
        $ep = new AdMessage();
        $this->assign('se', $ep->getmessage($id));
        // dump($ep->getmessage($id));die();
        return view('admessage');
    }
    /**
     * 批量删除
     */
    public function delmes()
    {
        $data = input('param.id/a');
        $param = implode(",",$data);

        $am = new AdMessage;
        $res = $am->delmes($param);
            if ($res) {
                echo "1";
            } else {
                echo "0";
            }
        
    }
    /**
     * 更新已查看的信息状态
     */
    public function savestatus()
    {
        $id = input('param.id');
        if ($id) {
            Db::name('message')->where('id',$id)->update(['status'=>2]);
        }
    }
    /**
     * 管理账户
     */
    public function admin_list()
    {
        $rolelist = $this->getPower();
        $this->assign('rolelist',$rolelist);
        return view();
    }
    /**
     * 权限管理
     */
    public function system_power()
    {
        $info['list'] = $this->getList();
        $info['rolelist'] = $this->getPower();
        $this->assign('info',$info);
        return view();
    }
    /**
     * 用户审核
     */
    public function system_user()
    {
        return view();
    }
    /**
     * 获取当前组内角色列表
     */
    public function getPower()
    {
        $role = model('Role', 'model');
        $list = $role->getRoleList(Session('user')->gid);
        return $list;
    }
    /**
     * 获取当前角色的权限
     */
    public function getMenu()
    {
        if (!empty($_GET['rid'])) {
            $rid = $_GET['rid'];
            $role = model('Role', 'model');
            $list = $role->getRoleMenu($rid);
            return $list;
        }
    }
    /**
     * 设置权限
     */
    public function setPower()
    {
        $res = array('code' => 2,'msg' => '失败');
        if ($_POST){
            if (!empty($_POST['rid']) && !empty($_POST['mid'])){
                $data = [];
                $role = model('Role','model');
                $info = $role->get($_POST['rid']);
//                if($info->gid != 0){              // 是否为默认角色 ，不是则修改
                    $where['rid'] = $_POST['rid'];
                    $data['mid'] = $_POST['mid'];
                    if($role->save($data,$where)){
                        $res = array('code' => 1,'msg' => '成功');
                    }
//                }else{
//                    $res = array('code' => 2,'msg' => '默认角色不能设置权限');
//                }
            }
        }
        return $res;
    }
    /**
     * 删除当前角色
     */
    public function DelRole(){
        $res = array('code' => 2,'msg' => '失败');
        if (!empty($_GET['rid'])){
            $rid = $_GET['rid'];
            $role = model('Role','model');
            $info = $role->get($rid);
            if($info->gid != 0){
                if($role->destroy($rid)){
                    $res = array('code' => 1,'msg' => '成功');
                }
            }else{
                $res = array('code' => 2,'msg' => '默认角色不能删除');
            }
        }
        return $res;
    }
    /**
     * 新增角色
     */
    public function AddRole()
    {
        $res = array('code' => 2,'msg' => '失败');
        if ($_POST){
            $data['mid'] = implode(',',$_POST['rid']);
            $data['rname'] = $_POST['rname'];
            $data['gid'] = Session('user')->gid;
            $role = model('Role','model');
            if($role->save($data)){
                $res = array('code' =>1,'msg' => '成功');
            }
        }
        return $res;
    }
    /**
     * 获取当前组内所有权限列表
     */
    public function getList()
    {
        $menu = model('Menu', 'model');
        $list = $menu->all();
        $arr = [];
        foreach ($list as $key => $val) {
            if ($val['pid'] == 0) {
                $arr[] = $val->toArray();
            }
        }
        foreach ($list as $key => $val) {
            foreach ($arr as $k => $v) {
                if ($val['pid'] == $v['mid']) {
                    $arr[$k]['child'][] = $val->toArray();
                }
            }
        }
        return $arr;
    }
    public function getSearch()
    {
        //        if ($_POST){
        $where = [];
        if(!empty($_POST['mobile'])){
            $where['mobile'] = ['like','%'.$_POST['mobile'].'%'];
        }
        $user = model('Users','model');
        $list = $user->getGroupList(Session('user')->gid,$where);
        foreach ($list as $key => $val){
            $list[$key] = $val->toArray();
        }
        return $list;
        //        }
    }
    /**
     * 获取待审核的用户列表
     */
    public function getAudUser()
    {
        $res = array('code' => 2 ,'msg' => '暂无数据');
        if ($_POST){
            if (!empty($_POST['currentpage']) && !empty($_POST['pagesize'])){
                $currentpage = $_POST['currentpage'];
                $pagesize = $_POST['pagesize'];
                $user = model('users','model');
                $list = $user->getGroupAudData(Session('user')->gid);
                foreach ($list as $key => $val){
                    $list[$key] = $val->toArray();
                }
                if (!empty($list)){
                    $list = array_splice($list,$pagesize*($currentpage-1),$pagesize);
                    $res = array('code' => 1 ,'data' =>  $list ,'listcount' => count($list) , 'countpage' => ceil(count($list)/$pagesize));
                }
            }
        }
        return $res;
    }
    /**
     * 审核用户
     */
//    public function AudUser()
//    {
//        $res = array('code' => 2,'msg' => '失败');
//        if ($_POST){
//            if(!empty($_POST['aud_status']) && !empty($_POST['uid'])){
//                $user = model('Users','model');
//                $where['uid'] = $_POST['uid'];
//                $data['aud_status'] = $_POST['aud_status'];
//                if($user->save($data,$where)){
//                    $res = array('code' => 1,'msg' => '成功');
//                }
//            }
//        }
//        return $res;
//    }
    /**
     * 提交角色
     */
    public function SubRole()
    {
        $res = array('code' =>  2 ,'msg' => '失败');
        if ($_POST){
            $data = $_POST;
            $data['gid'] = Session('user')->gid;
            $user = model('Users','model');
            $ret = $user->saveRole($data);
            $res = $ret;
        }
        return $res;
    }
    /**
     * 获取用户详情
     */
    public function getInfo()
    {
        $res = array('code' => 2,'msg' => '失败');
        if ($_POST){
            $uid = $_POST['uid'];
            $user = model('Users','model');
            $userinfo = $user->getUserInfo($uid);
            if(!empty($userinfo)){
                $res = array('code' => 1 ,'data' =>  $userinfo);
            }
        }
        return $res;
    }
    /**
     * 删除用户
     */
    public function delUser()
    {
        $res = array('code' => 2 , 'msg' => '失败');
        if($_POST){
            if(!empty($_POST['uid'])){
                $user = model('Users','model');
                $data['gid'] = '';
                $data['job_num'] = '';
                $data['rid'] = '';
                if($user->allowField(true)->save($data,$_POST)){
                    $res = array('code' => 1,'msg' => '删除成功');
                }
                // if($user::destroy($_POST)){
                //     $res = array('code' => 1,'msg' => '删除成功');
                // }
            }else{
                $res = array('code' => 2 , 'msg' => '缺少用户ID');
            }
        }
        return $res;
    }
}

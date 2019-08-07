<?php
/**
 * 系统管理
 */

namespace app\jielv\controller;
use think\Db;

class Admin extends Index
{
    /**
     * 区域管理
     * setgroup
     */
    public function setgroup()
    {  
        $data = db('user_group')->select();
        // dump($data);die();
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
        $this->assign('arr',$arr);
        $this->assign('data',$data);
        $this->assign('gid',session('user')['gid']);
        return view();
    }

    public function getSearch()
    {
//        if ($_POST){
            $where = [];
            if (!empty($_POST)){
                $where = $_POST;
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
     *  用户组列表
     */
    public function getGroupList()
    {
        $res = array('code' => 2,'msg' => '失败');
        $group = model('UserGroup','logic');
        $list = $group->getGroupData($_POST);
        if(!empty($list)){
            $res = array('code' => 1,'data' => $list);
        }
        return $res;
    }

    /**
     * 新增区域
     */
    public function ad_group(){
        
        if ($_POST) {
            $data = input('post.');
            $data['mid'] = implode(',',$data['mid']);
            
            $ug = model('UserGroup','logic');
            $res = $ug->saveData($data);
            if ($res) {
                $this->redirect('Admin/setgroup');
            }else{
                $this->error($res);
            }
        }else{
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
            $this->assign('arr',$arr);
        }
        
        return view();
    }

    /**
     * 编辑区域信息和账户信息
     */
    public function edit_group(){
        
        $id = input('param.id');
        $uid = input('param.uid');
        if (!empty($id)) {
            $se = db('user_group')->where('gid',$id)->find();
            $mid = db('admin_user')->where('user_name',$se['chager'])->value('mid');
            $se['uid'] = db('admin_user')->where('user_name',$se['chager'])->value('uid');
            $se['mid'] = explode(",",$mid);
            
            $this->assign('se',$se);
        }else{
            $se = db('admin_user')->where('uid',$uid)->find();//获取权限
            $se['mid'] = explode(",",$se['mid']);
            $this->assign('se',$se);
        }
        if ($_POST) {
            $data = input('post.');
            $data['mid'] = implode(",",$data['mid']);
            $data['password'] = sysmd5($data['password']);

            if ($data['gname']) {//修改区域
                $se = model('UserGroup','logic');
                $esv = $se->editData($data);
                db('admin_user')->where('uid',$data['uid'])->update(['mid'=>$data['mid'],'password'=>$data['password'],'user_name'=>$data['chager']]);
                $this->redirect('Admin/setgroup');
                
            }else{//修改管理员
                $se = model('Users');
                $esv = $se->edituser($data);
                $this->redirect('System/admin_list');
            }
        }
        //权限
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
        $this->assign('arr',$arr);
        
        return view();
    }
    /**
     * 删除区域
     */
    public function del()
    {
        $id = input('param.id');
        if ($id == session('user')['gid']) {//管理员不可以删除自己
            return 3;
        }else{
            if (Db::name('user_group')->where('gid', $id)->delete()) {
                Db::name('admin_user')->where('gid',$id)->delete();
                    return 1;
                } else {
                    return 0;
                }
        }
        
    }


    /**
     * 更改状态
     */
    public function ChangeStatus()
    {
        $res = array('code' => 2,'msg' => '失败');
        $group = model('UserGroup','logic');
        if(!empty($_POST['gid'])){

            $status = $_POST['status'];
            if($status == false){
                $status = 2;
            }else{
                $status = 1;
            }
            $data['groupstatus'] = $status;
            $where['gid'] = $_POST['gid'];
            if($group->save($data,$where)){
                $res = array('code' => 1,'msg' => '成功');
            }
        }
        return $res;
    }
    /**
     * 获取用户组信息
     */
    public function getGroupInfo()
    {
        $res = array('code' => 2,'msg' => '暂无数据');
        if($_POST){
            $group = model('UserGroup','logic');
            $info = $group->getGroupInfo($_POST['gid']);
//            dump($info->toArray());
            if(!empty($info)){
                $res = array('code' => 1, 'data' => $info);
            }
        }
        return $res;
    }
    /**
     * 删除用户组
     */
    public function DelGroup()
    {
        $res = array('code' => 2,'msg' => '失败');
        if($_POST){
            if(!empty($_POST['gid'])){
                $group = model('UserGroup','logic');
                $ret = $group->where('gid = '.$_POST['gid'])->delete();
                if($ret){
                    $res = array('code' => 1,'msg' => '删除成功');
                }
            }
        }
        return $res;
    }
}

<?php
namespace app\jielv\controller;
use app\jielv\model\AdMessage;
use think\Request;
use think\Db;
use think\Session;

/**
 *  System 系统管理
 */
class System extends Index
{



    /**
     * 管理账户
     */
    public function admin_list()
    {   
        $gid = session('user')['gid'];
        $pid = session('user')['pid'];
        $user = model('Users');
        $data = $user->getlist($gid);
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
        $this->assign('pid',$pid);
        $this->assign('uid',session('user')['uid']);
        return view();
    }

    /**
     * 添加管理员
     */
    public function add_user(){
        
            $param = input('post.');
            $res = db('admin_user')->where('user_name',$param['user_name'])->find();//检查账户是否存在
            if ($res) {
                $this->error('管理员已存在',url('System/admin_list'));
            }else{
                $param['gid'] = session('user')['gid'];
                $param['add_time'] = time();
                $param['mid'] = implode(',',$param['mid']);
                $param['password'] = sysmd5($param['password']);
                $us = model('Users');
                $res = $us->adduser($param);
                if ($res) {
                    $this->redirect('System/admin_list');
                }else{
                    $this->error('添加失败');
                }
            } 
    }



    /**
     * 删除管理员
     */
    public function del()
    {
        $data = input('param.id/a');
        $param = implode(",",$data);

        $am = model('Users');
        $res = $am->del($param);
            if ($res) {
                return 1;
            } else {
                return 0;
            }
    }

   
}

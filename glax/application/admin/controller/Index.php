<?php
namespace app\admin\controller;
use think\Controller;
use think\Session;
use think\Loader;
use think\Cache;
class Index extends Controller
{
    function __construct()
    {
        parent::__construct();
        $method = request()->action();
        if($method != 'login' && $method!= 'capt'){
            if(empty(Session('admin'))){
                $this->redirect('/admin/admin/login');
            }
        }else{
            if(!empty(Session('admin'))){
                $this->redirect('/admin/admin/index');
            }
        }
    }
    /*
    *  右侧页面
    */
    public function right()
    {
        $stime = strtotime(date('Y-m-d'));
        $etime = time();
        $info = [];
        $info['count'] = db('visit')->where('v_id = 1')->find()['v_count'];
        $info['msg'] = db('contact')->order('add_time desc')->where('add_time between '.$stime.' and '.$etime)->count();
        $info['company'] = db('company')->find();
        // dump($info['com'])
        $info['php_ver'] = PHP_VERSION;
        $info['mysql_ver'] = db()->query('select VERSION() as version')[0]['version'];
        $info['max_upload'] = ini_get('file_uploads') ? ini_get('upload_max_filesize') : "Disabled";
        $info['ser'] = $_SERVER["SERVER_SOFTWARE"];
        $info['role'] = db('admins')->alias('a')->join('role b','a.role_id = b.role_id')->where('admin_id = 1')->find()['role_name'];
        $this->assign('info',$info);
        return $this->fetch();
    }
    /*
    *  根据传过来的表 主键 类型 状态修改
    */
    public function up_status()
    {
        if ($_POST) {
            if (!empty($_POST['db']) && !empty($_POST['type']) && !empty($_POST['status']) && !empty($_POST['id']) && !empty($_POST['pk'])) {
                if ($_POST['status'] == 1) {
                    $status = 2;
                }else {
                    $status = 1;
                }
                $msg = '';
                if ($_POST['db'] == 'category' && ($_POST['type'] == 'is_groom' || $_POST['type'] == 'is_btn1' || $_POST['type'] == 'is_btn2'|| $_POST['type'] == 'is_btn3'|| $_POST['type'] == 'is_btn4')){
                    if ($_POST['type'] == 'is_btn1') {
                        $btn1c = db($_POST['db'])->where('is_btn1 = 1')->count();
                        if ($btn1c >= 1 && $status == 1) {
                            $res = array('code' => 2, 'msg' => '按钮1不能超过一个');
                            return $res;
                        }
                    }
                    // if ($_POST['type'] == 'is_btn2') {
                    //     $btn2c = db($_POST['db'])->where('is_btn2 = 1')->count();
                    //     if ($btn2c >= 1 && $status == 1) {
                    //         $res = array('code' => 2, 'msg' => '按钮2不能超过一个');
                    //         return $res;
                    //     }
                    // }
                    if ($_POST['type'] == 'is_btn3') {
                        $btn3c = db($_POST['db'])->where('is_btn3 = 1')->count();
                        if ($btn3c >= 1 && $status == 1) {
                            $res = array('code' => 2, 'msg' => '按钮3不能超过一个');
                            return $res;
                        }
                    }
                    // if ($_POST['type'] == 'is_btn4') {
                    //     $btn2c = db($_POST['db'])->where('is_btn4 = 1')->count();
                    //     if ($btn2c >= 1 && $status == 1) {
                    //         $res = array('code' => 2, 'msg' => '按钮4不能超过一个');
                    //         return $res;
                    //     }
                    // }
                    $count = db($_POST['db'])->where($_POST['type'].' = 1')->count();
                    if ($count >=  4 && $status == 1) {
                        $res = array('code' => 2, 'msg' => '分类推荐不能大于四个');
                        return $res;
                    }
                    $ret = db($_POST['db'])->where($_POST['pk'] .'='. $_POST['id'])->update([$_POST['type'] => $status]);
                }else{
                    $ret = db($_POST['db'])->where($_POST['pk'] .'='. $_POST['id'])->update([$_POST['type'] => $status]);
                }
                if ($ret) {
                    $res = array('code' => 1, 'msg' => '修改成功');
                }
            }else {
                $res = array('code' => 2, 'msg' => '缺少参数');
            }
            return $res;
        }
    }
    /*
    *  公共删除方法
    */
    public function del()
    {
        if ($_POST) {
            if (!empty($_POST['db']) && !empty($_POST['id'])) {
                $info = db($_POST['db'])->query('SHOW INDEX FROM yw_'.$_POST['db']);
                if (is_array($_POST['id'])) {
                    foreach ($_POST['id'] as $key => $val) {
                        $ret = db($_POST['db'])->where($info[0]['Column_name'] .' = '.$val)->delete();
                    }
                }else {
                    $ret = db($_POST['db'])->where($info[0]['Column_name'] .' = '.$_POST['id'])->delete();
                }
                if ($ret) {
                    $res = array('code' => 1, 'msg' => '删除成功');
                }else {
                    $res = array('code' => 2, 'msg' => '失败');
                }
            }else {
                $res = array('code' => 2, 'msg' => '缺少参数');
            }
            return json_encode($res);
        }
    }
}

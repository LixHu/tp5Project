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
        $info['make'] = db('make')->where('add_time between '.$stime.' and '.$etime)->count();
        $info['company'] = db('company')->find();
        // dump($info['com'])
        $info['php_ver'] = PHP_VERSION;
        $info['mysql_ver'] = db()->query('select VERSION() as version')[0]['version'];
        $info['max_upload'] = ini_get('file_uploads') ? ini_get('upload_max_filesize') : "Disabled";
        $info['ser'] = $_SERVER["SERVER_SOFTWARE"];
        $info['role'] = db('admin')->alias('a')->join('role b','a.role_id = b.role_id')->where('admin_id = 1')->find()['role_name'];
        $this->assign('info',$info);
        return $this->fetch();
    }
}

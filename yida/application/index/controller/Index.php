<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Loader;
use think\Session;

class Index extends Controller
{
    function __construct(){
        // header('content-type: applicatiion/json; charset=utf-8');
        header('Access-Control-Allow-Origin:*');
        parent::__construct();
        $info['company'] = db('company')->find();
        $info['company']['summary'] = htmlspecialchars_decode($info['company']['summary']);
        $this->assign('info',$info);
        // $this->arr = $this->getRequest();
        $this->up_visit();
    }
    private function getRequest(){
        $pt = file_get_contents("php://input");
        $arr = json_decode($pt,true);
        return $arr;
    }
    private function up_visit()
    {
        $v_info = db('visit')->where('v_id = 1')->find();
        if($v_info['is_visit'] != 1) {
            db('visit')->where('v_id = 1')->update(['is_visit' => 1,'edit_time' => time()]);
        }else {
            $time = date('Y-m-d',strtotime('+1 day',$v_info['edit_time']));
            $etime = date('Y-m-d');
            if($time <= $etime) {
                db('visit')->where('v_id = 1')->update(['is_visit' => 0,'v_count' => 0]);
            }
        }
        db('visit')->where('v_id = 1')->setInc('v_count');

    }
    /*
    *   主页信息
    */
}

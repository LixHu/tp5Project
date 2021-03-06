<?php
namespace app\boquan\controller;
use think\Controller;
use think\Loader;
use think\Session;
use think\Request;
use think\Db;
use think\captcha\Captcha;
use app\boquan\model\Users;
use app\boquan\model\Menu;
/**
 *  Index
 */
class Index extends Controller
{
    function __construct()
    {
        parent::__construct();
        $this->checklog();
        $action = request()->action();
        $con = request()->controller();
        if (Request::instance()->isAjax() == false){
            if ($action != 'login' && $action != 'setgroup'  && $action != 'do_img' && $action != 'index' && $action != 'head' && $action != 'left' && $action != 'main' && $action != 'sign_out' && Session('user')['aid'] != 1 && $con == 'auditing') {
                $this->checkpow();
            }
        }
    }
    /**
    * 检查是否登录
    */
    private function checklog()
    {
        if (empty(Session('user'))) {
            if (request()->action() != 'login' && request()->action() != 'reg_server' && request()->action() != 'server_log' && request()->action() != 'reg' && request()->action() != 'reg_log' && request()->action() != 'send_sms' && request()->action() != 'do_img') {
                $this->redirect(url('user/login'));
            }
        }else {
            if (request()->action() == 'login') {
                $this->redirect(url('index/index'));
            }
        }
    }
    /**
    * 检查权限是否存在
    */
    public function checkpow()
    {
        $users = new Users;
        if (!empty(Session('user')['uid'])) {
            $data = $users->getMenu(Session('user')['uid']);
            $res = $this->powerAuthority(request()->controller(),request()->action(),$data);
            if ($res['responseCode'] != '101') {
                die('<font color="red">没有权限</font>');
            }
        }
    }
    /**
    * 查看有没有权限方法
    */
    private function powerAuthority($con,$method,$data)
    {
        $responseData = array('responseCode'=>'100', 'responseMessage'=>'没有权限');
        // 菜单按钮权限
        foreach ($data as $key => $vo) {
            if (strtolower($vo['con']) == strtolower($con) && strtolower($vo['method']) == strtolower($method)) {
                $responseData = array('responseCode'=>'101', 'responseMessage'=>'可以访问');
                return $responseData;
                break;
            }
        }
        return $responseData;
    }
    /**
    * 显示验证码
    */
    public function do_img()
    {
        $config = [
            'length'  =>  4,             #验证码长度
            // 'useZh'   =>  true,       #使用中文字符串
            'bg'      =>  [10, 255, 240] #背景颜色
        ];
        $captcha = new Captcha($config);
        return $captcha->entry();
    }
    /**
    *  检查验证码是否正确
    */
    public function check_code($code,$id = '')
    {
        $captcha = new Captcha();
        return $captcha->check($code,$id);
    }
    /**
    * 主页
    */
    public function index()
    {
        $menu = new Menu;
        $users = new Users;
        if (Session('user')['aid'] == 1) {
            $menu_list['mdata'] = $menu->where('type = 1')->order('`order` asc')->select();
        }else {
            $menu_list = $users->getShowMenu(Session('user')['uid']);
        }
        $newmenu = [];
        foreach ($menu_list['mdata'] as $key => $val) {
            if ($val['pid'] == 0) {
                $newmenu[] = $val->toArray();
            }
        }
        foreach ($newmenu as $key => $val) {
            foreach ($menu_list['mdata'] as $k => $value) {
                if ($value['pid'] == $val['mid']) {
                    $newmenu[$key]['child'][] = $value->toArray();
                }
            }
        }
        $gid = session('user')->gid; //获取到当前操作用户的分类ID
        $group = model('UserGroup');
        $ginfo = $group->get($gid);
        if($ginfo->groupstatus == 2){
            $url = url('index/notpower');
            $newmenu = [];
        }else{
            $url = url('index/main');
        }
        // dump($newmenu);
        $mes = db('message')->where(['gid'=>$gid,'status'=>1])->count();//获取未读消息数量
        $this->assign('mes', $mes);
        $this->assign('url',$url);
        $this->assign('menu',$newmenu);
        return view();
    }
    /**
     *  首页展示
     */
    public function main()
    {
        $stime = strtotime(date('Y-m-d'));
        $etime = time();
        $workorder = model('WorkOrders');
        $client = model('Client');
        $info['notcomple'] = $workorder->where('status < 5 and gid = '.Session('user')->gid)->count();    #未完成工单数量
        $info['todaycomple'] = $workorder
                            ->where('status > 5 and gid = '.Session('user')->gid.' and handle_time between '.$stime.' and '.$etime)
                            ->count();           #今日完成工单数量
        $stime = strtotime('-30 day',time());
        $dtime = strtotime(date('Y-m-d'));
        $etime = time();
        $info['satisfaction'] = $workorder->where('satisfaction < 3 and satisfaction != 0 and comple_time between '.$stime .' and '.$etime)->count();    #30天好评记录
        $info['all_work'] = $workorder->where('gid ='.Session::get('user')->gid)->count();
        $info['stay_zp'] = $workorder->where('status = 2 and gid ='.Session::get('user')->gid)->count();
        $info['already_zp'] = $workorder->where('status = 3 and gid ='.Session::get('user')->gid)->count();
        $info['already_js'] = $workorder->where('status = 4 and gid ='.Session::get('user')->gid)->count();
        $info['comple'] = $workorder->where('status >= 5 and gid ='.Session::get('user')->gid)->count();
        $info['custom'] = $client->where('gid ='.Session('user')->gid)->count();
        $funds = $workorder->alias('a')->join('funds b','a.wo_id = b.wo_id')->where('b.add_time between '.$dtime.' and '.$etime)->select();
        $price = 0;
        foreach ($funds as $key => $val){
            $price += $val['alea_bill_price'];
        }
        $info['price'] = $price;
        $this->assign('info',$info);
        return view();
    }
    /**
     * 获取最近工单状态
     */
    public function getworkstatus()
    {
        $list = [];
        $page_size = 5;
        if ($_POST){
            $worklog = model('WorkLog','logic');
            $list = $worklog->getList(Session('user')->gid,!empty($_POST['time'])?$_POST['time']:'');
            foreach ($list as $key => $val){
                $list[$key]->add_time = date('Y-m-d H:i:s',$val->add_time);
            }
            $list = array_splice($list,($_POST['currpage']-1)*$page_size,$page_size);

            if(!empty($list)){
                $res = array('code' => 1,'data' => $list);
            }else{
                $res = array('code' => 2,'msg' => '沒有了');
            }
            return $res;
        }
    }
    /**
     * 获取几天内的数据状态
     */
    public function getdaydate()
    {
        $workorder = model('WorkOrders','logic');
        if (!empty($_POST['param'])){
            $arr = explode(',',$_POST['param']);
            $data = [];
            foreach ($arr as $key => $val){
                $stime = strtotime($val);
                $etime = strtotime('+1 day', $stime);
                $data['categories'][] = $workorder->getCount('1',$stime,$etime);
                $data['series'][] = $workorder->getCount('2',$stime,$etime);
            }
        }else {
            $data['top'] = [
                $workorder->where('status = 3 and gid = '.Session::get('user')->gid)->count(),
                $workorder->where('status = 4 and gid = '.Session::get('user')->gid)->count(),
                $workorder->where('status = 4 and gid = '.Session::get('user')->gid)->count(),
                $workorder->where('status >= 5 and gid = '.Session::get('user')->gid)->count()
            ];
            $data['down']['data1'] = [1, 5, 6, 2];
            $data['down']['data2'] = [1, 5, 3, 8];
        }
        return $data;
    }
    /**
    * 退出登录
    */
    public function sign_out()
    {
        Session('user',null);
        if (empty(Session('user'))) {
            $this->redirect(url('user/login'));
        }
    }
    /**
     * 上传文件返会base64格式 多张用 ' - '分开
     * @return string
     */
    public function UploadBase(){
        $files = request()->file('file');
        $base64 = [];
        foreach($files as $file){
            $info = $file->move(ROOT_PATH . 'public/static' . DS . 'upload');
            if($info){
                $path = ROOT_PATH.'public/static'.DS.'upload/'.$info->getSaveName();
                $base64[] = base64EncodeImage($path);
                @unlink($path);
            }else{
                return $file->getError();
            }
        }
        $str = implode(' - ',$base64);
        return $str;
    }
    /**
     * 获取我的工单
     */
    public function getMyWork()
    {
        if ($_POST){
            $is_all = $_POST['is_all'];
            if ($is_all == 2){
                $limit = 10;
            }else{
                $limit = '';
            }
            $workorder = model('WorkOrders','logic');
            $list = $workorder->getMyOrder(Session('user')->uid,$limit);
            return $list;
        }
    }
    /**
     * 没有权限显示页面
     */
    public function notpower()
    {
        $group = model('UserGroup');
        $list = $group->where('pid = 1')->select();
        $this->assign('glist',$list);
        return view();
    }
    /**
     * 申请主机厂
     */
    public function apphost()
    {
        $res = array('code' => 2 , 'msg' => '缺少参数');
        if ($_POST) {
            if(!empty($_POST['gid'])){
                $gid = $_POST['gid'];
                $group = model('UserGroup');
                $where['gid'] = Session('user')->gid;
                // $data['pid'] = $gid;
                // $data['groupstatus'] = 1;
                // $group->allowField(true)->save($data,$where)
                $data['appid'] = $gid;
                $data['gid'] = Session('user')->gid;
                if(Db::name('group_apply')->insert($data)){
                    $res = array('code' => 1,'msg' => '成功');
                }else{
                    $res = array('code' => 2 , 'msg' => '失败');
                }
            }
        }
        return $res;
    }
}

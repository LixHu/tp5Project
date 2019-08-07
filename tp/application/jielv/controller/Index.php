<?php
namespace app\jielv\controller;
use think\Controller;
use think\Loader;
use think\Session;
use think\Request;
use think\captcha\Captcha;
use app\jielv\model\Users;
use app\jielv\model\Menu;
/**
 *  Index
 */
class Index extends Controller
{
    function __construct()
    {
        // dump(Session('user'));
        // exit;
        parent::__construct();
        $this->checklog();
        $action = request()->action();
        $con = request()->controller();
        if (Request::instance()->isAjax() == false){
            if ($action != 'login' && $action != 'setgroup' && $action != 'do_img' && $action != 'index' && $action != 'head' && $action != 'left' && $action != 'main' && $action != 'sign_out' && Session('user')['aid'] != 1 && $con == 'auditing') {
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
            if (request()->action() != 'login' && request()->action() != 'do_img') {
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
        
            $menu_list = $users->getShowMenu(Session('user')['uid']);
        
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
        $mes = db('message')->where(['gid'=>$gid,'status'=>1])->count();//获取未读消息数量
        $this->assign('mes', $mes);
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
        // $info['notcomple'] = $workorder->where('status < 5 and gid = '.Session('user')->gid)->count();    #未完成工单数量
        $info['todaycomple'] = $workorder
                            ->where('status > 7 and add_time between '.$stime.' and '.$etime)
                            ->count();           #今日完成工单数量
        // $stime = strtotime('-30 day',time());
        // $etime = time();
        // $info['satisfaction'] = $workorder->where('satisfaction < 3 and satisfaction != 0 and comple_time between '.$stime .' and '.$etime)->count();    #30天好评记录
        $info['aud_driver'] = db('driver')->where('aud_status',3)->count();//待审核司机
        $info['aud_order'] = db('orders')->where(['make_type'=>2,'cid'=>1])->count();//待指派订单
        $info['coupons'] = db('parts')->where('cateid',9)->count();//优惠券
        $info['huafei'] = db('parts')->where('cateid',8)->count();//话费充值
        // $info['comple'] = $workorder->where('status >= 5 and gid ='.Session::get('user')->gid)->count();
        $this->assign('info',$info);
        return view();
    }
    // /**
    //  * 獲取最近工單狀態
    //  */
    // public function getworkstatus()
    // {
    //     $list = [];
    //     $page_size = 5;
    //     if ($_POST){
    //         $worklog = model('WorkLog','logic');
    //         $list = $worklog->getList(Session('user')->gid,!empty($_POST['time'])?$_POST['time']:'');
    //         foreach ($list as $key => $val){
    //             $list[$key]->add_time = date('Y-m-d H:i:s',$val->add_time);
    //         }
    //         $list = array_splice($list,($_POST['currpage']-1)*$page_size,$page_size);

    //         if(!empty($list)){
    //             $res = array('code' => 1,'data' => $list);
    //         }else{
    //             $res = array('code' => 2,'msg' => '沒有了');
    //         }
    //         return $res;
    //     }
    // }
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
    // /**
    //  * 获取我的工单
    //  */
    // public function getMyWork()
    // {
    //     if ($_POST){
    //         $is_all = $_POST['is_all'];
    //         if ($is_all == 2){
    //             $limit = 10;
    //         }else{
    //             $limit = '';
    //         }
    //         $workorder = model('WorkOrders','logic');
    //         $list = $workorder->getMyOrder(Session('user')->uid,$limit);
    //         return $list;
    //     }
    // }
}

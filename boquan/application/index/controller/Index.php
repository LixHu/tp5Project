<?php
namespace app\index\controller;
use think\Loader;
use think\Controller;
use think\Session;
use think\Cache;
use think\Request;
class Index extends Controller
{
    function __construct()
    {
        parent::__construct();
        $this->checklog();
    }
    private function checklog()
    {
        if (empty(Session('driver')) && Request::instance()->isAjax() == false) {
            $action = request()->action();
            $bool = $action != 'login' &&  $action != 'accept' &&  $action != 'invite' && $action != 'do_img' && $action != 'forget' && $action != 'reg' && $action != 'setpwd';
            if ($bool) {
                $this->redirect(url('user/login'));
            }
        }else {
            if (request()->action() == 'login') {
                $this->redirect(Session('user_url'));
            }
        }
    }

    /**
     * 上传文件返会base64格式 多张用 ' - '分开
     * @return string
     */
    public function UploadBase(){
        $files = request()->file('file');
        $base64 = [];
        if($files){
            $info = $files->move(ROOT_PATH . 'public/static' . DS . 'upload');
            if($info){
                $path = ROOT_PATH.'public/static'.DS.'upload/'.$info->getSaveName();
                $base64[] = base64EncodeImage($path);
                @unlink($path);
            }else{
                return $files->getError();
            }
        }
        $str['url'] = implode(' - ',$base64);
        return jsonReturn($str);
    }
    /**
     * 邀请人是否同意页面
     */
    public function invite()
    {
        if(!empty($_GET['uid'])){        // 接受传递过来的手机号
            $user = model('Users');
            $group = model('UserGroup');
            $uinfo = $user->get($_GET['uid']);
            if(!empty($uinfo->jgid)){
                $ginfo = $group->get($uinfo->jgid);
                if(empty($ginfo)){
                    // $this->redirect('');
                }
                $this->assign('ginfo',$ginfo);
            }else{
                $this->redirect($_SERVER['HTTP_HOST']);
            }
            $this->assign('uinfo',$uinfo);
            return view();
        }
    }
    /**
     * 接受or拒绝邀请
     */
    public function accept()
    {
        $res = array('code' => 2, 'msg' => '缺少参数');
        if($_POST){
            $uid = $_POST['uid'];
            $user = model('Users');
            $uinfo = $user->get($uid);
            // 接受邀请
            if($_POST['type'] == 1){
                $data['gid'] = $uinfo->jgid;
                $data['rid'] = $uinfo->jrid;
                $data['jgid'] = 0;
                $data['jrid'] = 0;
            }else{
                // 拒绝邀请
                $data['gid'] = 0;
                $data['rid'] = 0;
                $data['jgid'] = 0;
                $data['jrid'] = 0;
            }
            if($user->allowField(true)->save($data,['uid' => $uid])){
                $res = array('code' => 1, 'msg' => '接受成功');
            }else{
                $res = array('code' => 2, 'msg' => '失败');
            }
        }
        return $res;
    }
}

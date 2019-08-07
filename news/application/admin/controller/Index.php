<?php

namespace app\admin\controller;

use think\Controller;
use think\Session;
use think\Loader;
use think\Cache;
use think\Request;
use think\ValidateCode;
class Index extends Controller{

    public function __construct(){
        parent::__construct();
		$method = request()->action();
        if($method != 'login' && $method!= 'capt'){
            if(empty(Session('admin'))){
                $this->redirect('/admin/users/login');
            }
        }else{
            if(!empty(Session('admin'))){
                $this->redirect('/admin/admin/index');
            }
        }
    }
    /*
    *  清除缓存
    */
    public function clear()
    {
        if(Cache::clear()){
            $this->success('清除成功','admin/index');
        }else{
            $this->error('失败');
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
        $info['today_user'] = db('users')->where('reg_time between '.$stime.' and '.$etime)->count();
        $info['ader_num'] = db('users')->where('iden > 1')->count();
        $info['aud_ader'] = db('users')->alias('a')->join('user_data b','a.user_id = b.user_id')->where('b.aud_status = 0')->count();
        $info['ad_count'] = db('ad')->count();
        $info['php_ver'] = PHP_VERSION;
        $info['mysql_ver'] = db()->query('select VERSION() as version')[0]['version'];
        $info['max_upload'] = ini_get('file_uploads') ? ini_get('upload_max_filesize') : "Disabled";
        $info['ser'] = $_SERVER["SERVER_SOFTWARE"];
        $info['role'] = db('admin')->alias('a')->join('admin_role b','a.role_id = b.role_id')->where('admin_id ='.Session('admin')['admin_id'])->find()['role_name'];
        $info['ad_list'] = db('ad')->alias('a')->join('users b','a.user_id = b.user_id')->where('add_time between '.$stime.' and '.$etime)->limit(0,10)->select();
        $info['ad_groom'] = db('ad')->where('groom_status = 3')->count();
        $this->assign('info',$info);
        return $this->fetch();
    }
    public function head()
    {
        return view();
    }
    public function left()
    {
        $admin_id = Session('admin')['admin_id'];
        $menu_list = db('admin_menu')
                    ->alias('a')
                    ->join('role_menu b','a.menu_id = b.menu_id')
                    ->join('admin_role c','b.role_id = c.role_id')
                    ->join('admin d','c.role_id = d.role_id')
                    ->where('a.is_show = 1 and d.admin_id ='.$admin_id.' and a.pid = 0')
                    ->select();
        foreach ($menu_list as $key => $val) {
            $menu_list[$key]['child'] = db('admin_menu')
                            ->alias('a')
                            ->join('role_menu b','a.menu_id = b.menu_id')
                            ->join('admin_role c','b.role_id = c.role_id')
                            ->join('admin d','c.role_id = d.role_id')
                            ->where('a.is_show = 1 and d.admin_id ='.$admin_id.' and a.pid = '.$val['menu_id'])
                            ->select();
         }
         $this->assign('menu_list',$menu_list);
         return $this->fetch();
    }
    /*
    * 分享邀请码
    */
    public function share()
    {
        $iden_list = db('iden')->where('iden_id <> 1')->select();
        if($_POST){
            $data['mobile'] = $_POST['mobile'];
            $data['iden'] = $_POST['iden'];
            // $code = sprintf('%x',crc32(microtime()));
            $code = rand(100000,999999);
            $data['invite_code'] = $code;
            $flag = true;
            if(preg_match('/^1[34578]\d{9}$/',$data['mobile'])){
                if (!empty(Session('send_param'.$data['mobile']))) {
                    $time = strtotime('+1 minute',Session('send_param'.$data['mobile'])['send_time']);
                    if ($time > time()) {
                        $flag = false;
                    }
                }
                if ($flag) {
                    $send = array('code' => $data['invite_code'],'send_time' => time());
                    Session('send_param'.$data['mobile'],$send);
                    $post_data = "account=C35588802&password=424b2e67fc7049c7bc6a99fd90aeced1&mobile=".$data['mobile']."&content=".rawurlencode("您的验证码是：".$send['code']."。请不要把验证码泄露给其他人。");
                    $target = "http://106.ihuyi.cn/webservice/sms.php?method=Submit";
                    $gets =  $this->xml_to_array($this->Post($post_data, $target));
                    if($gets['SubmitResult']['code'] == 2) {
                        $send1 = true;
                        $res = db('invite')->insert($data);
                        if($res){
                            $this->success('成功');
                        }
                    }else{
                        $send1 = false;
                        $this->error($gets['SubmitResult']['msg']);
                    }
                }else {
                    $send1 = false;
                    $this->error('发送失败(请等待一分钟之后再发送)');
                }
            }
        }
        $this->assign('iden_list',$iden_list);
        return $this->fetch();
    }

     private function Post($curlPost,$url){
    		$curl = curl_init();
    		curl_setopt($curl, CURLOPT_URL, $url);
    		curl_setopt($curl, CURLOPT_HEADER, false);
    		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    		curl_setopt($curl, CURLOPT_NOBODY, true);
    		curl_setopt($curl, CURLOPT_POST, true);
    		curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
    		$return_str = curl_exec($curl);
    		curl_close($curl);
    		return $return_str;
    }
    //将 xml数据转换为数组格式。
    private function xml_to_array($xml){
    	$reg = "/<(\w+)[^>]*>([\\x00-\\xFF]*)<\\/\\1>/";
    	if(preg_match_all($reg, $xml, $matches)){
    		$count = count($matches[0]);
    		for($i = 0; $i < $count; $i++){
    		$subxml= $matches[2][$i];
    		$key = $matches[1][$i];
    			if(preg_match( $reg, $subxml )){
    				$arr[$key] = $this->xml_to_array( $subxml );
    			}else{
    				$arr[$key] = $subxml;
    			}
    		}
    	}
    	return $arr;
    }
}

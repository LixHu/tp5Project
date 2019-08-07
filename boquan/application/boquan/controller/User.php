<?php
namespace app\boquan\controller;

use app\boquan\model\Users;
/**
*  User
*/
class User extends Index
{
	/**
	 * 登录
	 */
    public function login()
    {
        if ($_POST) {
            $user = new Users;
            if(!empty($_POST['mobile']) && !empty($_POST['password'])){
                // if ($this->check_code($data['capt'])) {
                $data['a.mobile'] = $_POST['mobile'];
                $data['password'] = sysmd5($_POST['password']);
                $info = $user->getInfo($data);
                if ($info) {
                    Session('user',$info);
                    $this->redirect(url('index/index'));
                }else {
					$user = model('Users','model');
                    $msg = '用户名或密码错误';
					if($user->where('mobile =\''.$_POST['mobile'].'\'')->find()){
						$msg = '您没有进入后台的权限，请联系管理员';
					}
                }
                // }else {
                // $msg = '验证码有误';
                // }
            }else{
                $msg = '用户名和密码不能为空';
			}
            echo '<script>alert("'.$msg.'")</script>';
        }
        return view();
    }
	/**
	 * 注册页面
	 */
	public function reg() {
		return view();
	}
    /**
     * 注册
     */
    public function reg_log()
    {
    	$res = array('code' => 2 ,'msg' => '缺少参数');
    	if($_POST){
    		$user = model('Users');
    		if(!empty($_POST['mobile'])){
    			$sms = new \sms\Sms;
			    $mobile = $_POST['mobile'];
			    if($_POST['password'] == $_POST['password2']){
				    if($sms->checksms($_POST['verifycode'],$mobile)){
					    // 如果存在手机号，编辑数据，否则添加数据
					    $info = $user->where('mobile = '.$mobile)->find();
					    $validate = validate('Users');
							$_POST['password'] = sysmd5($_POST['password']);
						    if(!empty($info)){
							    $flag = $user->allowField(true)->save($_POST,['uid' => $info->uid]);
						    }else{
								if($validate->check($_POST)){
							    	$flag = $user->allowField(true)->save($_POST);
								}else{
									$res = array('code' => 2 ,'msg' => $validate->getError());
								}
						    }
						    if($flag){
							    $res = array('code' => 1 ,'msg' => '注册成功');
						    }else{
							    $res = array('code' => 2 ,'msg' => '失败');
						    }
				    }else{
					    $res = array('code' => 2 ,'msg' => '验证码错误');
				    }
			    }else{
				    $res = array('code' => 2 ,'msg' => '两次密码输入不一致');
			    }
		    }
		}
	    return $res;
	}
	/**
	 * 服务站注册页面
	 */
	public function reg_server()
	{
		return view();
	}
	/**
	 * 注册服务站处理
	 */
	public function server_log()
	{
		$res = array('code' => 2 ,'msg' => '缺少参数');
    	if($_POST){
    		$user = model('Users');
    		if(!empty($_POST['mobile'])){
    			$sms = new \sms\Sms;
			    $mobile = $_POST['mobile'];
			    if($_POST['password'] == $_POST['password2']){
				    if($sms->checksms($_POST['verifycode'],$mobile)){
						// 如果存在服务站名称，添加一条服务站记录
						$group = model('UserGroup');
						if(!empty($_POST['gname'])){
							$gdata['gname'] = $_POST['gname'];
							$gdata['aid'] = 4;             // 服务站
							$gdata['groupstatus'] = 2;
							$url='http://api.map.baidu.com/geocoder/v2/?address='.$_POST['address'].'&output=json&ak=cgfUI2WrHlGV9zCviIQOEwSbcxFZG6g2';
							$return = json_decode(file_get_contents($url),true);
							$gdata['address'] = $_POST['address'];
							if(!empty($return['result']['location'])){
								$gdata['lat'] = $return['result']['location']['lng'];     // 获取接口返回的经纬度
								$gdata['lng'] = $return['result']['location']['lat'];
								if($group->allowField(true)->save($gdata)){
									$Insgid = $group->getLastInsID();
									$rdata = [
										['rname' => '系统管理员','gid' => $Insgid,'mid' => "1,10,15,20,28,31,53,59,2,3,4,5,8,9,38,41,11,12,13,14,16,17,18,19,21,22,29,30,32,33,34,35,36,42,54,61,62,63,60"],
										['rname' => '经理','gid' => $Insgid,'mid' => "53,38,42,54,61,62,63"],
										['rname' => '工单管理员','gid' => $Insgid,'mid' => "1,2,3,4,5,8,9,38,41,56,63"],
										['rname' => '财务', 'gid' => $Insgid,'mid' => "10,53,11,12,13,14,61"],
										['rname' => '仓库', 'gid' => $Insgid,'mid' => "15,16,17,18,62"],
										['rname' => '采购员', 'gid' =>  $Insgid,'mid' => ""],
										['rname' => '维修工','gid' => $Insgid,'mid' => "1,2,4,43"],
									];
									$role = model('Role','logic');
									$resault = $role->allowField(true)->saveAll($rdata,false);    
									// 添加完服务站记录，添加用户记录
									$user = model('Users');
									// 存在手机号添加数据，不存在编辑
									$uinfo = $user->where('mobile ='.$_POST['mobile'])->find();
									$udata['password'] = sysmd5($_POST['password']);
									$udata['rela_name'] = $_POST['rela_name'];
									$udata['gid'] = $Insgid;
									$udata['rid'] = $resault[0]->rid;
									if(!empty($uinfo)){
										$flag = $user->allowField(true)->save($udata,['uid' => $uinfo->uid]);
									}else{
										$udata['mobile'] = $_POST['mobile'];
										$flag = $user->allowField(true)->save($udata);
									}
									$res = array('code' => 1 , 'msg' => "添加成功");
								}else{
									$res = array('code' => 2 , 'msg' => "失败");
								}
							}else{
								$res = array('code' => 2,'msg' => '地址信息不正确');
							}
						}
				    }else{
					    $res = array('code' => 2 ,'msg' => '验证码错误');
				    }
			    }else{
				    $res = array('code' => 2 ,'msg' => '两次密码输入不一致');
			    }
		    }
		}
	    return $res;
	}
    /**
     * 发送验证码
     */
    public function send_sms() {
    	if($_POST){
    		if(!empty($_POST['mobile'])){
    			$sms = new \sms\Sms('C31231149','ac3fef15b2f3c6a813b667648f57bb28');
    			$res = $sms->send_sms($_POST['mobile']);
    			return $res;
		    }
	    }
    }
}

<?php
/**
 * 系统管理
 */

namespace app\boquan\controller;


class Admin extends Index
{
    /**
     * 用户组设置
     * setgroup
     */
    public function setgroup()
    {
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
     * 添加主机厂、维修站
     */
    public function AddGroup()
    {
    	$res = array('code' => 2 ,'msg' => '缺少参数');
    	if ($_POST){
    		$validate = validate('UserGroup');
            if(!empty($_POST['address'])){
			    $url='http://api.map.baidu.com/geocoder/v2/?address='.$_POST['address'].'&output=json&ak=cgfUI2WrHlGV9zCviIQOEwSbcxFZG6g2';
			    $return = json_decode(file_get_contents($url),true);
			    if(!empty($return['result']['location'])){
				    if ($validate->check($_POST)){
				        $group = model('UserGroup');
                        $data = $_POST;
                        $data['aid'] = 2;
				        $data['groupstatus'] = 1;    // 待审核
					    $data['pid'] = 1;      // 主机厂身份
					    $data['lat'] = $return['result']['location']['lng'];     // 获取接口返回的经纬度
					    $data['lng'] = $return['result']['location']['lat'];
					    if(!empty($_POST['gid'])){
					        if($group->allowField(true)->save($data,['gid' => $_POST['gid']])){
					            $res = array('code' => 1 , 'msg' => "修改成功");
						    }else{
							    $res = array('code' => 2 , 'msg' => "失败");
						    }
					    }else{
						    if($group->allowField(true)->save($data)){
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
							    $role->saveAll($rdata,false);
							    $res = array('code' => 1 , 'msg' => "添加成功");
						    }else{
							    $res = array('code' => 2 , 'msg' => "失败");
						    }
					    }
			        }else{
				        $res = array('code' => 2 ,'msg' => $validate->getError());
				    }
			    }else{
			        $res = array('code' => 2,'msg' => '地址信息不正确');
			    }
		    }
	    }
	    return $res;
       /* $res = array('code' => 2,'msg' => '请填写必填项');
        if($_POST){
            if(!empty($_POST['gname']) && !empty($_POST['chager']) && !empty($_POST['mobile']) && !empty($_POST['address']) && !empty($_POST['tel'])){
                $group = model('UserGroup','logic');
                    $data = $_POST;
                    $address = $_POST['address'];           // 用户地址
                    if(preg_match("/^1[34578]\d{9}$/", $_POST['mobile'])){
                        $url='http://api.map.baidu.com/geocoder/v2/?address='.$address.'&output=json&ak=cgfUI2WrHlGV9zCviIQOEwSbcxFZG6g2';
                        $res = json_decode(file_get_contents($url),true);
//                        // 根据用户地址获取经纬度
                        if(!empty($res['result']['location'])){
                            $data['lat'] = $res['result']['location']['lng'];
                            $data['lng'] = $res['result']['location']['lat'];
                            if ($_POST['gid']) {
//                                $ret = $group->editData($data);    // 编辑用户组
                                $ret = $group->editData($data);
                            } else {
                                $user = model('Users','model');
                                $have = $user->where('user_name = \''.$_POST['chager'].'\'')->find();    // 查看负责人是否存在，不存在则添加
                                $have1 = $user->where('mobile = \''.$_POST['mobile'].'\'')->find();
                                if(!empty($have)){
                                    $ret = '管理员账户已经存在，请重新添加';
                                }else {
                                    if(!empty($have1)){
                                        $ret = '手机号已经存在，请重新添加';
                                    }else{
                                        $ret = $group->saveData($data);   // 往用户组表中添加一条数据
                                    }
                                }
                            }
                        }else{
                            $ret = '地址不存在';
                        }
                    }else{
                        $ret = '手机号格式不正确';
                    }
                if(empty($ret)){
                    $res = array('code' => 1,'msg' => '成功');
                }else{
                    $res = array('code' => 2,'msg' => $ret);
                }
            }
        }
        return $res;*/
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
    /**
     * 指定负责人
     */
    public function Appoint()
    {
    	$res = array('code' => 2 , 'msg' => '缺少参数');
    	if($_POST){
    		if(!empty($_POST['gid']) && !empty($_POST['name']) && !empty($_POST['mobile']) && !empty($_POST['job_num'])){
    			$user = model('Users','model');
                $role = model('Role','logic');
                $info = $user->where('mobile = '.$_POST['mobile'])->find();     // 根据手机号搜索用户
                $rinfo = $role->where('gid ='.$_POST['gid'])->find();          // 获取当前组的最高权限
                //  邀请负责人时，伪装把当前用户的gid 和rid 改成 当前组的id
			    $data['jgid'] = $_POST['gid'];       // 把当前用户的组id改成选中的组id
			    $data['job_num'] = $_POST['job_num'];   // 工号
			    $data['fw_name'] = $_POST['name'];    // 姓名
                $data['jrid'] = $rinfo->rid;             // 当前组的最高权限赋给负责人
                // 如果存在手机号，则修改数据，不存在则添加一条数据
    			if(!empty($info)){
    				$flag = $user->allowField(true)->save($data,['uid' => $info->uid]);
			    }else{
    				$udata['mobile'] = $_POST['mobile'];
    				$udata['jgid'] = $_POST['gid'];
				    $udata['jrid'] = $rinfo->rid;
				    $udata['job_num'] = $_POST['job_num'];
				    $udata['fw_name'] = $_POST['name'];
				    $udata['add_time'] = time();
    				$flag = $user->allowField(true)->save($udata);
			    }
			    if ($flag){
    				$res = array('code' => 1,'msg' => '成功');
			    }
		    }
	    }
	    return $res;
    }
}

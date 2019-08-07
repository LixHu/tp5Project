<?php
namespace app\boquan\controller;

use app\boquan\model\Client;
use think\Request;
use think\Db;

/**
 * Clientall 客户管理
 */
class Clientall extends Index
{

    // /**
    //  * 客户列表
    //  */
    // public function client_list()
    // {   
    //     $gid = json_decode(session('user')['gid']);//获取到当前操作用户的分类ID
    //     // 实例化模型类
    //     $sl = new Client();
    //     // 调用模型类里的方法
    //     $service_list = $sl->getclientAll($gid);
    //     $page = $service_list->render();
    //     $res = $service_list->isEmpty();//判断数据集
    //     $this->assign('res', $res);
    //     $this->assign('page', $page);
    //     $this->assign('service_list', $service_list);
        
    //     return view();
    // }

    // /**
    //  * 编辑客户
    //  */
    // public function client_edit()
    // {
    //     $id = input('param.id');
    //     if ($id) {
    //         $cli = new Client;
    //         $client_list = $cli->getone($id);
           
    //         $this->assign('client_list',$client_list);
    //     }
        
        
    //     return view('ad_client');
    // }
    // /**
    //  * 新增客户
    //  */
    // public function ad_client()
    // {   
    //     if ($_POST) {
            
    //         $param = input('post.');
    //         if (empty($param['id'])) {
                
    //             $param['gid'] = json_decode(session('user')['gid']);//获取到当前操作用户的分类ID
    //             $param['status'] = 1;
    //             $param['ad_time'] = time();
    //             $ser = new Client;
    //             $res = $ser->addclient($param);
                
    //             if ($res) {
    //                 $this->redirect('Clientall/client_list');
    //             }else{
    //                 $this->error('新增失败');
    //             }
    //         }else{

    //             $cli = new Client();
    //             $client_list = $cli->editclient($param);
    //             if ($client_list) {
    //                 $this->redirect('Clientall/client_list');
    //             }else{
    //                 $this->error('无任何编辑',url('Clientall/client_list'));
    //             }
    //         }
    //     }
        
    //     return view();
    // }



    // /**
    //  * [ad_state 客户状态]
    //  */
    // public function ad_status()
    // {
    //     $id = input('get.id'); // 获取id
    //     $status = Db::name('client')->where('id', $id)->value('status'); // 判断当前状态情况
    //     if ($status == 1) { // 修改状态
    //         $flag = Db::name('client')->where('id', $id)->setField(['status' => 2 ]);
    //         return $this->redirect('Clientall/client_list');
    //     } else { // 修改状态
    //         $flag = Db::name('client')->where('id',$id)->setField(['status' => 1]);
    //         return $this->redirect('Clientall/client_list');
    //     }
    // }

    // /**
    //  * 搜索客户
    //  */
    // public function search_service()
    // {
    //     // 接收所搜的关键字
    //     $keywords = input('param.keyword');
    //     if ($keywords) {
    //         $map['client_name'] = ['like','%'. $keywords .'%']; // 服务项目名称
    //         $service_list = Db::name('client')->where($map)->order('id desc')->paginate(10,false,['query' => request()->param(), ]);
    //         $page = $service_list->render();
    //         $res = $service_list->isEmpty();//判断数据集
    //         $this->assign('res', $res);
    //         $this->assign('page', $page);
    //         $this->assign('service_list', $service_list);
    //     } else {
    //         $this->error('暂无相关信息');
    //     }
    //     return $this->fetch('client_list');
    // }



    // /*
    //  * 删除
    //  */
    // public function del()
    // {
    //     $data = input('param.id/a');
    //     $param = implode(",",$data);

    //     $am = new Client;
    //     $res = $am->del($param);
    //         if ($res) {
    //             echo "1";
    //         } else {
    //             echo "0";
    //         }
        
    // }
    
    /**
     * 客户列表 主机厂拉取自己的客户（服务站） 服务站拉取自己添加的客户（司机）
     */
    public function custom_list()
    {
        // $list = 
        $where = '';
        if(Session('user')->pid == 1){
            // 主机厂
            if(!empty($_POST['keyword'])){
                $where = ' and gname like %'.$_POST['keyword'].'%';
            }
            $group = model('UserGroup');
            $list = $group->where('find_in_set(\''.Session('user')->gid.'\',pid)'.$where)->paginate(10);
            
        }else{
            // 服务站
            if(!empty($_POST['keyword'])){
                $where = ' and client_name like %'.$_POST['keyword'].'%';
            }
            $custom = model('Client');
            $list = $custom
                ->field('id as gid,client_name as gname ,client_tel as tel,client_address as address,gid as zid')
                ->where('gid ='.Session('user')->gid.$where)
                ->paginate(10);
        }
		$this->assign('page',$list->render());
        $this->assign('list',$list);
        return view();
    }
    /**
     * 申请服务站处理
     */
    public function custom_apply()
    {
        $usergroup = model('UserGroup');
        $list = db('group_apply a')
            ->join('user_group b','a.gid = b.gid')
            ->where('appid = '.Session('user')->gid)
            ->select();
        $this->assign('list',$list);
        return view();
    }
    /**
     * 审核服务站处理
     */
    public function appfuwu()
    {
        $res = array('code' => 1, 'msg' => '缺少参数');
        if($_POST){
            if(!empty($_POST['id'])){
                $lid = $_POST['id'];
                $info = db('group_apply')->where('lid ='.$lid)->find();
                if($_POST['type'] == 1){
                    // 通过
                    $group = model('UserGroup');
                    $ginfo = $group->get($info['gid']);
                    $where['gid'] = $info['gid'];
                    $pid = explode(',',$ginfo->pid);
                    
                    $data['pid'] = $ginfo->pid.','.$info['appid'];
                    $data['groupstatus'] = 1;
                    if($group->allowField(true)->save($data,$where)){
                        db('group_apply')->where('lid ='.$lid)->delete();
                        $res = array('code' => 1, 'msg' => '通过成功');
                    }
                }else{
                    // 拒绝
                    db('group_apply')->where('lid ='.$lid)->delete();
                    $res = array('code' => 1,'msg' => '拒绝成功');
                }
            }
        }
        return $res;
    }

	/**
	 * 添加编辑客户
	 */
    public function add_custom()
    {
    	if($_POST){
            $res = array('code' => 2,'msg' => '缺少参数');
            $validate = validate('UserGroup');
            if(Session('user')->pid == 1){
                // 主机厂添加客户
                $group = model('UserGroup');
                $validate = validate('UserGroup');
			    $url='http://api.map.baidu.com/geocoder/v2/?address='.$_POST['client_address'].'&output=json&ak=cgfUI2WrHlGV9zCviIQOEwSbcxFZG6g2';
                $return = json_decode(file_get_contents($url),true);
                if(!empty($return['result']['location'])){
                    $data['pid'] = Session('user')->gid;
                    $data['gname'] = $_POST['client_name'];
                    $data['tel'] = $_POST['client_tel'];
                    $data['address'] = $_POST['client_address'];
                    $data['lat'] = $return['result']['location']['lng'];     // 获取接口返回的经纬度
                    $data['lng'] = $return['result']['location']['lat'];
                    if($validate->check($data)){
                        if($group->allowField(true)->save($data)){
                            $res = array('code' => 1,'msg' => '添加成功');
                        }else{
                            $res = array('code' => 2, 'msg' => '失败');
                        }
                    }else{
                        $res = array('code' => 2, 'msg' => $validate->getError());
                    }
                }else{
                    $res = array('code' => 2, 'msg' => '地址信息不正确');
                }
            }else{
                // 服务站添加客户
                $_POST['gid'] = Session('user')->gid;
                $custom = model('Client');
                if($custom->allowField(true)->save($_POST)){
                    $res = array('code' => 1,'msg' => '添加成功');
                }else{
                    $res = array('code' => 2, 'msg' => '失败');
                }
            }
            return $res;
		}
    	return view();
    }
    /**
     * 解除关系
     */
    public function relieve()
    {
        if($_POST){
            $res = array('code' => 2, 'msg' => '缺少参数');
            if(!empty($_POST['gid'])){
                $gid = $_POST['gid'];
                $group = model('UserGroup');
                $info = $group->where('gid ='.$gid)->find();
                $pid = explode(',', $info->pid);
                foreach($pid as $key => $val){
                    if($val == Session('user')->gid){
                        unset($pid[$key]);
                    }
                }
                // 如果当前服务站没有上级，就把服务站关闭
                if(count($pid) == 1){
                    if($pid[0] == 0){
                        $data['groupstatus'] = 2;
                    }
                }
                if(count($pid) == 0){
                    $data['groupstatus'] = 2;
                }
                $pid = implode(',',$pid);
                $data['pid'] = $pid;
                if($group->where('gid ='.$gid)->update($data)){
                    $res = array('code' => 1, 'msg' => '删除成功');
                }else{
                    $res = array('code' => 2, 'msg' => '失败');
                }
            }
            return $res;
        }
    }
}
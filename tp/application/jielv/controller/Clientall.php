<?php
namespace app\jielv\controller;

use app\jielv\model\Client;
use think\Request;
use think\Db;

/**
 * Clientall 客户管理
 */
class Clientall extends Index
{

    /**
     * 客户列表
     */
    public function client_list()
    {   
        $gid = json_decode(session('user')['gid']);//获取到当前操作用户的分类ID
        // 实例化模型类
        $sl = new Client();
        // 调用模型类里的方法
        $service_list = $sl->getclientAll();
        $page = $service_list->render();
        $res = $service_list->isEmpty();//判断数据集
        $this->assign('res', $res);
        $this->assign('page', $page);
        $this->assign('service_list', $service_list);
        
        return view();
    }

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

    /**
     * 搜索客户
     */
    public function search_service()
    {
        // 接收所搜的关键字
        $keywords = input('param.keyword');
        if ($keywords) {
            $map['nick_name'] = ['like','%'. $keywords .'%']; // 服务项目名称
            $service_list = Db::name('users')->where($map)->order('uid desc')->paginate(10,false,['query' => request()->param(), ]);
            $page = $service_list->render();
            $res = $service_list->isEmpty();//判断数据集
            $this->assign('res', $res);
            $this->assign('page', $page);
            $this->assign('service_list', $service_list);
        } else {
            $this->error('暂无相关信息');
        }
        return $this->fetch('client_list');
    }



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
}

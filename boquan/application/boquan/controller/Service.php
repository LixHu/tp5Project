<?php
namespace app\boquan\controller;

use app\boquan\model\Services;
use think\Request;
use think\Db;

/**
 * Service 服务管理
 */
class Service extends Index
{

    /**
     * 服务列表
     */
    public function service_project()
    {
        // 实例化模型类
        $sl = new Services();
        // 调用模型类里的方法
        $service_list = $sl->getserviceAll();
        $page = $service_list->render();
        $res = $service_list->isEmpty();//判断数据集
        $this->assign('res', $res);
        $this->assign('page', $page);
        $this->assign('service_list', $service_list);
        
        return view();
    }

    /**
     * 编辑服务
     */
    public function service_edit()
    {
        $id = input('param.id');
        if ($id) {
            $se = db('services')->where('id',$id)->find();
            $this->assign('se',$se);
        }
        // 实例化模型
        $se = new Services();
        if (request()->isPost()) {
            // 接收数据并调用模型内方法
            $data = input('post.');
            $esv = $se->editservice($data);
            if ($esv) {
                $this->redirect('Service/service_project');
            } else {
                $this->error('数据无更新',url('Service/service_project'));
            }
        }
        
        
       
        
        return view();
    }
    /**
     * 新增服务项目
     */
    public function service_setting()
    {
        
        if ($_POST) {
            $param = input('post.');
            $param['gid'] = json_decode(session('user')['gid']);//获取到当前操作用户的分类ID
            $param['status'] = 1;
            $ser = new Services;
            $res = $ser->addservice($param);
            
            if ($res) {
                $this->redirect('Service/service_setting');
            }else{
                $this->error('新增失败');
            }
        }
        
        return view();
    }



    /**
     * [ad_state 服务项目状态]
     */
    public function ad_status()
    {
        $id = input('get.id'); // 获取id
        $status = Db::name('services')->where('id', $id)->value('status'); // 判断当前状态情况
        if ($status == 1) { // 修改状态
            $flag = Db::name('services')->where('id', $id)->setField([
                'status' => 2
            ]);
            return $this->redirect('Service/service_project');
        } else { // 修改状态
            $flag = Db::name('services')->where(array(
                'id' => $id
            ))->setField([
                'status' => 1
            ]);
            return $this->redirect('Service/service_project');
        }
    }

    /**
     * 搜索服务项目
     */
    public function search_service()
    {
        // 接收所搜的关键字
        $keywords = input('param.keyword');
        if ($keywords) {
            $map['name'] = [
                'like',
                '%' . $keywords . '%'
            ]; // 服务项目名称
            $service_list = Db::name('services')->where($map)
                ->order('id desc')
                ->paginate(10,false,['query' => request()->param(), ]);
            $page = $service_list->render();
            $res = $service_list->isEmpty();//判断数据集
            $this->assign('res', $res);
            $this->assign('page', $page);
            $this->assign('service_list', $service_list);
        } else {
            $this->error('暂无相关信息');
        }
        return $this->fetch('service_project');
    }



    /*
     * 删除
     */
    public function del()
    {
        $data = input('param.id/a');
        $param = implode(",",$data);

        $am = new Services;
        $res = $am->del($param);
            if ($res) {
                echo "1";
            } else {
                echo "0";
            }
        
    }
}

<?php
namespace app\jielv\controller;

use app\jielv\model\Services;
use think\Request;
use think\Db;

/**
 * Service 服务管理
 */
class Service extends Index
{

    /**
     * 车费列表
     */
    public function service_project()
    {
        // 实例化模型类
        $sl = new Services();
        // 调用模型类里的方法
        $service_list = $sl->getserviceAll();
        foreach ($service_list as $key => $value) {
            $service_list[$key]['region_id'] = db('region')->where('id',$value['region_id'])->value('name');
            $service_list[$key]['cart_type'] = db('cart_type')->where('id',$value['cart_type'])->value('type_name');
            $service_list[$key]['cart_cate'] = db('cart_cate')->where('id',$value['cart_cate'])->value('name');
            $service_list[$key]['time_slot'] = db('time_slot')->where('id',$value['time_slot'])->value('name');
        }
        $page = $service_list->render();
        $res = $service_list->isEmpty();//判断数据集
        $this->assign('res', $res);
        $this->assign('page', $page);
        $this->assign('service_list', $service_list);

        $region_data = db('region')->where('pid=1')->field('id,name')->select();//地区
        $cart_type = db('cart_type')->select();//车类
        $cart_cate = db('cart_cate')->select();//车型
        $time_slot = db('time_slot')->select();//时间段
        $this->assign('region_data', $region_data);
        $this->assign('cart_type', $cart_type);
        $this->assign('cart_cate', $cart_cate);
        $this->assign('time_slot', $time_slot);
        return view();
    }

    /**
     * 编辑服务
     */
    public function service_edit()
    {
        $id = input('param.id');
        if ($_POST) {
            $param = input('post.');
            $ser = model('Services');
            $res = $ser->editservice($param);
            if ($res) {
                $this->redirect('Service/service_project');
            }else{
                $this->redirect('Service/service_project');
            }
        }
        $data = db('cart_fee')->where('id',$id)->find();
        $data['region_id'] = db('region')->where('id',$data['region_id'])->value('name');
        $cart_type = db('cart_type')->select();//车类
        $cart_cate = db('cart_cate')->select();//车型
        $time_slot = db('time_slot')->select();//时间段
        $this->assign('cart_type', $cart_type);
        $this->assign('cart_cate', $cart_cate);
        $this->assign('time_slot', $time_slot);
        $this->assign('se',$data);
        return view();
    }

    /*
     * 新增车费
     */
    public function ad_cee(){
        $flog = ['code'=>3,'mag'=>'异常操作'];
        if (request()->isAjax()){
            $param = input('post.');
            $ser = model('Services');
            $res = $ser->ad_cee($param);
            if ($res){
                $flog = ['code'=>1,'mag'=>'新增成功'];
            }else{
                $flog = ['code'=>0,'mag'=>'新增失败'];
            }
        }
        return $flog;
    }


    /**
     * 评价标签
     */
    public function appraise()
    {
        
        // 实例化模型类
        $score = model('Score');
        // 调用模型类里的方法
        $service_list = $score->getscore_all();
        $page = $service_list->render();
        $res = $service_list->isEmpty();//判断数据集
        $this->assign('res', $res);
        $this->assign('page', $page);
        $this->assign('service_list', $service_list);
        
        return view();
    }

    /**
     * 新增标签
     */
    public function ad_appraise()
    {   
        if (request()->isAjax()) {
            $param = input('post.');
            $score = model('Score');
            $res = $score->ad_score($param);
            if ($res) {
                return 1;
            }else{
                return 0;
            }
        }else{
            return 3;
        }
        
    }


    /**
     * 编辑标签
     */
    public function appraise_edit()
    {
        $id = input('param.id');
        if ($_POST) {
            $param = input('post.');
            $ser = model('Score');
            $res = $ser->edit_appraise($param);
            if ($res) {
                $this->redirect('Service/appraise');
            }else{
                $this->redirect('Service/appraise');
            }
        }
        $ser = model('Score');
        $this->assign('se',$ser->getOneAd($id));
        return view();
    }

    /*
     * 删除标签
     */
    public function del_appraise()
    {
        $data = input('param.id/a');
        $param = implode(",",$data);

        $am = model('Score');
        $res = $am->del($param);
            if ($res) {
                return 1;
            } else {
                return 0;
            }
        
    }


    // /**
    //  * [ad_state 服务项目状态]
    //  */
    // public function ad_status()
    // {
    //     $id = input('get.id'); // 获取id
    //     $status = Db::name('services')->where('id', $id)->value('status'); // 判断当前状态情况
    //     if ($status == 1) { // 修改状态
    //         $flag = Db::name('services')->where('id', $id)->setField([
    //             'status' => 2
    //         ]);
    //         return $this->redirect('Service/service_project');
    //     } else { // 修改状态
    //         $flag = Db::name('services')->where(array(
    //             'id' => $id
    //         ))->setField([
    //             'status' => 1
    //         ]);
    //         return $this->redirect('Service/service_project');
    //     }
    // }

    /**
     * 搜索服务项目
     */
    public function search_service()
    {
        // 接收所搜的关键字
        $name = input('param.keyword');
        $region_id = db('region')->where('name',$name)->order('id desc')->value('id');
        
        if ($region_id) {
            
            $ser = model('Services');
            $service_list = $ser->search_list($region_id);
           
            foreach ($service_list as $key => $value) {
                $service_list[$key]['region_id'] = db('region')->where('id',$value['region_id'])->value('name');
                $service_list[$key]['cart_type'] = db('cart_type')->where('id',$value['cart_type'])->value('type_name');
                $service_list[$key]['cart_cate'] = db('cart_cate')->where('id',$value['cart_cate'])->value('name');
                $service_list[$key]['time_slot'] = db('time_slot')->where('id',$value['time_slot'])->value('name');
            }
            $page = $service_list->render();
            $res = $service_list->isEmpty();//判断数据集
            $region_data = db('region')->where('pid=1')->field('id,name')->select();//地区
            $cart_type = db('cart_type')->select();//车类
            $cart_cate = db('cart_cate')->select();//车型
            $time_slot = db('time_slot')->select();//时间段
            $this->assign('region_data', $region_data);
            $this->assign('cart_type', $cart_type);
            $this->assign('cart_cate', $cart_cate);
            $this->assign('time_slot', $time_slot);
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


    /**
     * ajax查询对应下拉的省市区
     */
    public function change_address() {
        $id = input('param.id');
        $region_data = db('region')->where('pid',$id)->field('id,name')->select();
        return $region_data;
    }
}

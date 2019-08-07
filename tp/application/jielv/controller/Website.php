<?php

namespace app\jielv\controller;

use think\Loader;
use think\Session;

class Website extends Index
{

    /**
     * 轮播图
     */
    public function banner()
    {   

        $web = model('WebsiteModel');
        $data = $web->banner_all();
        $page = $data->render();
        $res = $data->isEmpty();//判断数据集
        $this->assign('res', $res);
        $this->assign('page', $page);
        $this->assign('data',$data);
        return view();
    }
    /*
        新增轮播图
    */
    public function ad_banner(){
        if ($_POST) {
            $param = input('post.');
            $web = model('WebsiteModel');
            $res = $web->ad_banner($param);
            if ($res) {
                return 1;
            }else{
                return 0;
            }
        }
    }


    /**
     * 编辑轮播图
     */
    public function banner_edit()
    {   
        if ($_POST) {
            $param = input('post.');
            $web = model('WebsiteModel');
            $res = $web->edit_banner($param);
            if ($res) {
                $this->redirect('Website/banner');
            }else{
                $this->redirect('Website/banner');
            }
        }

        $id = input('param.id');

        $web = model('WebsiteModel');
        $this->assign('se',$web->getOne($id));
        return view();
    }
    


    /*
     * 删除轮播图
     */
    public function del_banner()
    {
        $data = input('param.id/a');
        $param = implode(",",$data);

        $am = model('WebsiteModel');
        $res = $am->del($param);
            if ($res) {
                return 1;
            } else {
                return 0;
            }
        
    }

    /**
     *  联系我们
     */
    public function contact()
    {   
        $web = model('ContactModel');
        $data = $web->contact();
        $page = $data->render();
        $res = $data->isEmpty();//判断数据集
        $this->assign('res', $res);
        $this->assign('page', $page);
        $this->assign('data',$data);
        
        return view();
    }

    /*
        新增公司信息
    */
    public function ad_contact(){
        if ($_POST) {
            $param = input('post.');
            $web = model('ContactModel');
            $res = $web->ad_contact($param);
            if ($res) {
                return 1;
            }else{
                return 0;
            }
        }
    }


    /**
     * 编辑公司信息
     */
    public function edit_contact()
    { 
      if ($_POST) {
            $param = input('post.');
            $web = model('ContactModel');
            $res = $web->edit_contact($param);
            if ($res) {
                $this->redirect('Website/contact');
            }else{
                $this->redirect('Website/contact');
            }
        }

        $id = input('param.id');

        $web = model('ContactModel');
        $this->assign('se',$web->getOne($id));
        return view();
    }

    /*
     * 删除公司信息
     */
    public function del_contact()
    {
        $data = input('param.id/a');
        $param = implode(",",$data);

        $am = model('ContactModel');
        $res = $am->del($param);
            if ($res) {
                return 1;
            } else {
                return 0;
            }
        
    }

    /**
     *  回访工单
     */
    public function workorder_back()
    {
        return view();
    }

    /**
     *  关闭工单
     */
    public function workorder_close()
    {
        return view();
    }

    
}

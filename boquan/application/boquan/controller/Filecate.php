<?php
namespace app\boquan\controller;
use app\boquan\model\Filescate;
use think\Controller;

    /**
     *  Filecate 文件分类管理
     */

class Filecate extends Index
{   
    

    /**
     *  文件类别
     */
    public function filecate(){

        $id = input('get.id');
        
        //实例化模型
        $fl = new Filescate;
        //调用模型内的方法
        $filecate = $fl->getfilecate($id);

        $this->assign('filecate',$filecate);

        return view();
    }

    /**
     *  文件类别添加
     */
    public function add_filecate(){
        
        $adfilecate = input('post.');
        //实例化模型
        $fl = new Filescate;
        //调用模型里的方法
        $filecate = $fl->addfilecate($adfilecate);

        $this->assign('filecate',$filecate);

        return $this->fetch('fileall');
    }

}

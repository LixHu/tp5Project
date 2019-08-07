<?php
namespace app\admin\controller;

class Banner extends Index
{
    /*
    * 广告列表
    */
    public function banner_list(){
        $banner_list = db('banner')->select();
        $this->assign('banner_list',$banner_list);
        return $this->fetch();
    }
    /*
    * 修改、添加广告图片
    */
    public function addedit_banner(){
        if(!empty($_GET['id'])){
            $id = $_GET['id'];
            $info = db('banner')->where('bn_id',$id)->find();
            $this->assign('info',$info);
        }else{
            $id = '';
        }
        $banner_pos = db('banner_pos')->select();
        $this->assign('pos_list',$banner_pos);
        if(!empty($_POST)){
            $bn_name = $_POST['bn_name'];
            $pos = $_POST['pos'];
            $file = request()->file('image1');
            if($file){
                $info = $file->validate(['size'=>62400,'ext'=>'jpg,jpeg,png,gif'])->move(ROOT_PATH.'public/static'.DS.'upload');
                if($info){
                    if($id){
                        $banner = db('banner')->where('bn_id = '.$id)->find();
                        @unlink(ROOT_PATH.'/public'.$banner['bn_url']);
                    }
                    $data['bn_url'] = '/static/upload/'.$info->getSaveName();
                }else{
                    $this->error($file->getError());
                }
            }
            $data['bn_name'] = $bn_name;
            $data['bn_pos'] = $pos;
            if($id){
                $res = db('banner')->where('bn_id',$id)->update($data);
            }else{
                $res = db('banner')->insert($data);
            }
            if($res){
                $this->success('添加/修改成功','banner/banner_list');
            }else{
                $this->error('失败');
            }
        }
        return $this->fetch();
    }

    /*
    * 删除banner
    */
    public function del_banner()
    {
        if($_POST){
            $id = $_POST['id'];
            if(is_array($id)){
                foreach($id as $key => $val){
                    $res[] =db('banner')->where('bn_id = '.$val)->delete();
                }
            }else{
                $res = db('banner')->where('bn_id ='.$id)->delete();
            }
            if(!empty($res)){
                $ret = array('code' => 1,'msg' => '删除成功');
            }else{
                $ret = array('code' => 2,'msg' => '失败');
            }
            return $ret;
        }
    }
    /*
    * 位置列表
    */
    public function banner_pos(){
        $pos_list = db('banner_pos')->select();
        $this->assign('pos_list',$pos_list);
        return $this->fetch();
    }
    /*
    * 添加修改位置
    */
    public function addedit_pos(){
        if(!empty($_GET['id'])){
            $id = $_GET['id'];
            $info = db('banner_pos')->where('pos_id ='.$id)->find();
            $this->assign('info',$info);
        }else{
            $id = '';
        }
        if($_POST){
            $data['pos_name'] = $_POST['pos_name'];
            $data['pos_desc'] = $_POST['pos_desc'];
            if($id){
                $res = db('banner_pos')->where('pos_id ='.$id)->update($data);
            }else{
                $res = db('banner_pos')->insert($data);
            }
            if($res){
                $this->success('添加/修改成功','banner/banner_pos');
            }else{
                $this->error('失败');
            }
        }
        return $this->fetch();
    }
    /*
    * 删除位置
    */
    public function del_pos()
    {
        if($_POST){
            $id = $_POST['id'];
            if(is_array($id)){
                foreach($id as $key => $val){
                    $res[] =db('banner_pos')->where('pos_id = '.$val)->delete();
                }
            }else{
                $res = db('banner_pos')->where('pos_id ='.$id)->delete();
            }
            if(!empty($res)){
                $ret = array('code' => 1,'msg' => '删除成功');
            }else{
                $ret = array('code' => 2,'msg' => '失败');
            }
            return $ret;
        }
    }
}

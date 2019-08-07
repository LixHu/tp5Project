<?php
namespace app\admin\controller;

class Banner extends Index
{

    /*
    *  banner 图管理
    */
    public function banner_list()
    {
        $banner_list = db('banner')->alias('a')->join('banner_pos b','a.bn_pos = b.pos_id')->paginate(10);
        $this->assign('page',$banner_list->render());
        $this->assign('banner_list',$banner_list);
        return $this->fetch();
    }
    /*
    * 添加、编辑banner
    */
    public function addedit_banner()
    {
        $title = '添加banner';
        $pos_list = db('banner_pos')->select();
        $id = '';
        if(!empty($_GET['id'])){
            $id = $_GET['id'];
            $title = '编辑banner';
            $banner_info = db('banner')->where('bn_id = '.$id)->find();
            $this->assign('info',$banner_info);
        }
        if($_POST){
            $data['bn_name'] = $_POST['bn_name'];
            $data['bn_pos'] = $_POST['bn_pos'];
            $data['is_show'] = 1;
            $file = request()->file('image1');
            if($file){
                $info = $file->validate(['size'=>4194304,'ext'=>'jpg,jpeg,png,gif'])->move(ROOT_PATH .'public/static'.DS.'uploads/banner');
                if($info){
                    if($id){
                        @unlink(ROOT_PATH.'public'.$banner_info['bn_url']);
                    }
                    $data['bn_url'] = '/static/uploads/banner/'.$info->getSaveName();
                }else{
                    $this->error($file->getError());
                }
            }
            if($id){
                $res = db('banner')->where('bn_id ='.$id)->update($data);
            }else{
                $data['add_time'] = time();
                $res = db('banner')->insert($data);
            }
            if($res){
                $this->success('成功','banner/banner_list');
            }else{
                $this->error('失败');
            }
        }
        $this->assign('pos_list',$pos_list);
        $this->assign('title',$title);
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
                foreach ($id as $key => $val) {
                    $res[] = db('banner')->where('bn_id ='.$val)->delete();
                }
            }else{
                $res = db('banner')->where('bn_id ='.$id)->delete();
            }
            if($res){
                $res = array('code' => 1, 'msg' => '删除成功');
            }else{
                $res = array('code' => 2, 'msg' => '失败');
            }
            return jsonReturn($res);
        }
    }
    /*
    *  banner 位置管理
    */
    public function banner_pos()
    {
        $pos_list = db('banner_pos')->paginate(10);
        $this->assign('page',$pos_list->render());
        $this->assign('pos_list',$pos_list);
        return $this->fetch();
    }
    /*
    *  添加、编辑位置
    */
    public function addedit_pos()
    {
        $title = '添加位置';
        $id = '';
        if(!empty($_GET['id'])){
            $title = '编辑位置';
            $id = $_GET['id'];
            $pos_info = db('banner_pos')->where('pos_id = '.$id)->find();
            $this->assign('info',$pos_info);
        }
        if($_POST){
            $data['pos_name'] = $_POST['pos_name'];
            $data['pos_desc'] = $_POST['pos_desc'];
            if($id){
                $res = db('banner_pos')->where('pos_id ='.$id)->update($data);
            }else {
                $res = db('banner_pos')->insert($data);
            }
            if($res){
                $this->success('成功','banner/banner_pos');
            }else{
                $this->error('失败');
            }
        }
        $this->assign('title',$title);
        return $this->fetch();
    }
    /*
    * 删除pos
    */
    public function del_pos()
    {
        if($_POST){
            $id = $_POST['id'];
            if(is_array($id)){
                foreach ($id as $key => $val) {
                    $res[] = db('banner_pos')->where('pos_id ='.$val)->delete();
                }
            }else{
                $res = db('banner_pos')->where('pos_id ='.$id)->delete();
            }
            if($res){
                $res = array('code' => 1, 'msg' => '删除成功');
            }else{
                $res = array('code' => 2, 'msg' => '失败');
            }
            return jsonReturn($res);
        }
    }
}

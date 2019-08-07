<?php
namespace app\admin\controller;
/*  软件管理 */
class Soft extends Index
{
    /*
    * 软件列表
    */
    public function soft_list()
    {
        $soft_list = db('software')->paginate(10);
        $this->assign('soft_list',$soft_list);
        $this->assign('page',$soft_list->render());
        return $this->fetch();
    }
    /*
    * 添加编辑软件
    */
    public function addedit_soft(){
        $id = '';
        if (!empty($_GET['id'])) {
            $id = $_GET['id'];
            $soft_info = db('software')->where('soft_id ='.$id)->find();
            $this->assign('info',$soft_info);
        }
        if ($_POST) {
            $data['soft_name'] = $_POST['soft_name'];
            $data['is_groom'] = $_POST['is_groom'];
            $data['soft_apply'] = $_POST['soft_apply'];
            $data['fun_list'] = $_POST['fun_list'];
            $data['video_url'] = $_POST['video_url'];
            $data['soft_desc'] = htmlspecialchars($_POST['soft_desc']);
            $fun_img = request()->file('fun_img');
            $soft_cost = request()->file('soft_cost');
            $soft_img = request()->file('soft_img');
            $soft_img_to = request()->file('soft_img_to');
            if($fun_img) {
                $info = $fun_img->validate(['size' => 412000 ,'ext' => 'jpg,jpeg,gif,png'])->move(ROOT_PATH.'public/static'.DS.'upload/soft');
                if ($info) {
                    if ($id) {
                        @unlink(ROOT_PATH.'public'.$soft_info['fun_img']);
                    }
                    $data['fun_img'] = '/static/upload/soft/'.$info->getSaveName();
                }else {
                    $this->error($fun_img->getError());
                }
            }
            if($soft_cost) {
                $info = $soft_cost->validate(['size' => 412000 ,'ext' => 'jpg,jpeg,gif,png'])->move(ROOT_PATH.'public/static'.DS.'upload/soft');
                if ($info) {
                    if ($id) {
                        @unlink(ROOT_PATH.'public'.$soft_info['soft_cost']);
                    }
                    $data['soft_cost'] = '/static/upload/soft/'.$info->getSaveName();
                }else {
                    $this->error($soft_cost->getError());
                }
            }
            if($soft_img) {
                $info = $soft_img->validate(['size' => 412000 ,'ext' => 'jpg,jpeg,gif,png'])->move(ROOT_PATH.'public/static'.DS.'upload/soft');
                if ($info) {
                    if ($id) {
                        @unlink(ROOT_PATH.'public'.$soft_info['soft_img']);
                    }
                    $data['soft_img'] = '/static/upload/soft/'.$info->getSaveName();
                }else {
                    $this->error($soft_img->getError());
                }
            }
            if($soft_img_to) {
                $info = $soft_img_to->validate(['size' => 412000 ,'ext' => 'jpg,jpeg,gif,png'])->move(ROOT_PATH.'public/static'.DS.'upload/soft');
                if ($info) {
                    if ($id) {
                        @unlink(ROOT_PATH.'public'.$soft_info['soft_img_to']);
                    }
                    $data['soft_img_to'] = '/static/upload/soft/'.$info->getSaveName();
                }else {
                    $this->error($fun_img->getError());
                }
            }
            if (!empty($data)) {
                if ($id) {
                    $ret = db('software')->where('soft_id ='.$id)->update($data);
                }else{
                    $ret = db('software')->insert($data);
                }
            }
            if ($ret) {
                $this->success('成功');
            }else{
                $this->error('失败');
            }
        }
        return $this->fetch();
    }
    /*
    *   更改状态
    */
    public function up_status()
    {
        if($_POST){
            if(!empty($_POST['type']) && !empty($_POST['status']) && !empty($_POST['soft_id'])) {
                $type = $_POST['type'];
                $status = $_POST['status'];
                if($status == 1){
                    $status = 2;
                }else {
                    $status = 1;
                }
                if ($type == 'is_groom') {
                    $count = db('software')->where('is_groom = 1')->count();
                    if ($count > 8) {
                        $res = array('code' => 2, 'msg'  => '精品软件最多8个');
                    }else{
                        $data[$type] = $status;
                        $where['soft_id'] = $_POST['soft_id'];
                        $ret = db('software')->where($where)->update($data);
                        if ($ret) {
                            $res = array('code' => 1, 'msg' => '修改成功');
                        }else {
                            $res = array('code' => 2, 'msg' => '失败');
                        }
                    }
                }
            }else {
                $res = array('code' => 2,'msg' => '缺少参数');
            }
            return $res;
        }
    }
    /*
    * 删除软件
    */
    public function del_soft()
    {
        if($_POST){
            $id = $_POST['id'];
            if(is_array($id)){
                foreach ($id as $key => $val) {
                    $res[] = db('software')->where('soft_id ='.$val)->delete();
                }
            }else{
                $res = db('software')->where('soft_id ='.$id)->delete();
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
    * 签约管理
    */
    public function sign_list()
    {
        $sign_list = db('sign')->paginate(10);
        $this->assign('page',$sign_list->render());
        $this->assign('sign_list',$sign_list);
        return view();
    }
    /*
    * 添加编辑 签约动态
    */
    public function addedit_sign()
    {
        $id = '';
        if(!empty($_GET['id'])) {
            $id = $_GET['id'];
            $sign_info = db('sign')->where('sign_id ='.$id)->find();
            $this->assign('info',$sign_info);
            $this->assign('id',$id);
        }
        if ($_POST) {
            if(!empty($_POST['sign_desc'])) {
                $data['sign_desc'] = $_POST['sign_desc'];
                if (!empty($_POST['sign_id'])) {
                    $id = $_POST['sign_id'];
                    $ret = db('sign')->where('sign_id ='.$id)->update($data);
                }else {
                    $ret = db('sign')->insert($data);
                }
                if ($ret) {
                    $res = array('code' => 1, 'msg' => '成功');
                }else {
                    $res = array('code' => 2, 'msg' => '失败');
                }
            }else {
                $res = array('code' => 2, 'msg' => '缺少参数');
            }
            return $res;
            exit;
        }
        return view();
    }
    /*
    * 删除签约信息
    */
    public function del_sign(){
        if($_POST){
            $id = $_POST['id'];
            if(is_array($id)){
                foreach ($id as $key => $val) {
                    $res[] = db('sign')->where('sign_id ='.$val)->delete();
                }
            }else{
                $res = db('sign')->where('sign_id ='.$id)->delete();
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
    * 签约管理
    */
    public function expert_list()
    {
        $expert_list = db('expert')->paginate(10);
        $this->assign('page',$expert_list->render());
        $this->assign('list',$expert_list);
        return view();
    }
    /*
    * 添加编辑 签约动态
    */
    public function addedit_expert()
    {
        $title = '添加观点';
        $id = '';
        if (!empty($_GET['id'])) {
            $id = $_GET['id'];
            $title = '编辑观点';
            $under_info = db('expert')->where('expert_id = '.$id)->find();
            $this->assign('info',$under_info);
        }
        if ($_POST) {
            if (!empty($_POST['expert_name']) && !empty($_POST['expert_desc']) && !empty($_POST['expert_content'])) {
                $data['expert_name'] = $_POST['expert_name'];
                $data['expert_desc'] = $_POST['expert_desc'];
                $data['expert_content'] = htmlspecialchars($_POST['expert_content']);
                $file = request()->file('img');
                if ($file) {
                     $info = $file->validate(['size'=>412000,'ext'=>'jpg,jpeg,png,gif'])->move(ROOT_PATH . 'public/static' . DS . 'upload/under');
                     if($info) {
                         if ($id) {
                             @unlink(ROOT_PATH.'public'.$case_info['expert_img']);
                         }
                         $data['expert_img'] = '/static/upload/under/'.$info->getSaveName();
                     }else {
                         $this->error($file->getError());
                     }
                }
                if ($id) {
                    $ret = db('expert')->where('expert_id ='.$id)->update($data);
                }else{
                    $data['is_show'] = 1;
                    $data['add_time'] = time();
                    $ret = db('expert')->insert($data);
                }
                if ($ret) {
                    $this->success('成功',url('soft/expert_list'));
                }else {
                    $this->error('失败');
                }
            }else {
                $this->error('缺少参数');
            }
        }
        $this->assign('title',$title);
        return view();
    }
    /*
    * 删除签约信息
    */
    public function del_expert(){
        if($_POST){
            $id = $_POST['id'];
            if(is_array($id)){
                foreach ($id as $key => $val) {
                    $res[] = db('expert')->where('expert_id ='.$val)->delete();
                }
            }else{
                $res = db('expert')->where('expert_id ='.$id)->delete();
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
    *   更改状态
    */
    public function up_status2()
    {
        if($_POST){
            if(!empty($_POST['type']) && !empty($_POST['status']) && !empty($_POST['expert_id'])) {
                $type = $_POST['type'];
                $status = $_POST['status'];
                if($status == 1){
                    $status = 2;
                }else {
                    $status = 1;
                }
                $data[$type] = $status;
                $where['expert_id'] = $_POST['expert_id'];
                $ret = db('expert')->where($where)->update($data);
                if ($ret) {
                    $res = array('code' => 1, 'msg' => '修改成功');
                }else {
                    $res = array('code' => 2, 'msg' => '失败');
                }
            }else {
                $res = array('code' => 2,'msg' => '缺少参数');
            }
            return $res;
        }
    }
}

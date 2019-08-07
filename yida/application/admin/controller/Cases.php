<?php
namespace app\admin\controller;

class Cases extends Index
{
    /*
    * 案例列表
    */
    public function case_list(){
        $case_list = db('case')->alias('a')->field('a.case_id,a.com_name,a.com_desc,a.is_groom,a.is_show,b.trade_name')->join('trade b','a.trade_id = b.trade_id')->paginate(10);

        $this->assign('case_list',$case_list);
        $this->assign('page',$case_list->render());
        return $this->fetch();
    }
    /*
    * 添加、编辑案例
    */
    public function addedit_case()
    {
        $title = '添加案例';
        $id = '';
        $trade_list = db('trade')->select();
        $soft_list = db('software')->where('is_show = 1')->select();
        if (!empty($_GET['id'])) {
            $id = $_GET['id'];
            $case_info = db('case')->where('case_id = '.$id)->find();
            $title = '编辑案例';
            $this->assign('info',$case_info);
        }
        if ($_POST) {
            $data['com_name'] = $_POST['com_name'];
            $data['trade_id'] = $_POST['trade_id'];
            $data['case_desc'] = $_POST['case_desc'];
            $data['com_desc'] = $_POST['com_desc'];
            $data['case_content'] = htmlspecialchars($_POST['case_content']);
            $data['soft_id'] = $_POST['soft_id'];
            $file = request()->file('img');
            if ($file) {
                $info = $file->validate(['size'=>412000,'ext'=>'jpg,jpeg,png,gif'])->move(ROOT_PATH . 'public/static' . DS . 'upload/case');
                if($info) {
                    if ($id) {
                        @unlink(ROOT_PATH.'public'.$case_info['case_img']);
                    }
                    $data['case_img'] = '/static/upload/case/'.$info->getSaveName();
                }
            }
            if($id) {
                $res = db('case')->where('case_id = '.$id)->update($data);
            }else {
                $data['is_show'] = 1;
                $data['is_groom'] = 2;
                $res = db('case')->insert($data);
            }
            if ($res) {
                $this->success('添加/修改成功',url('cases/case_list'));
            }else {
                $this->error('失败');
            }
        }
        $this->assign('soft_list',$soft_list);
        $this->assign('trade_list',$trade_list);
        $this->assign('title',$title);
        return $this->fetch();
    }
    /*
    *  删除行业
    */
    public function del_trade(){
        if($_POST){
            $id = $_POST['id'];
            if(is_array($id)){
                foreach ($id as $key => $val) {
                    $res[] = db('trade')->where('trade_id ='.$val)->delete();
                }
            }else{
                $res = db('trade')->where('trade_id ='.$id)->delete();
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
    * 删除案例
    */
    public function del_case(){
        if($_POST){
            $id = $_POST['id'];
            if(is_array($id)){
                foreach ($id as $key => $val) {
                    $res[] = db('case')->where('case_id ='.$val)->delete();
                }
            }else{
                $res = db('case')->where('case_id ='.$id)->delete();
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
    * 更改状态
    */
    public function up_status(){
        if($_POST){
            if(!empty($_POST['type']) && !empty($_POST['status']) && !empty($_POST['case_id'])) {
                $type = $_POST['type'];
                $status = $_POST['status'];
                if($status == 1){
                    $status = 2;
                }else {
                    $status = 1;
                }
                $data[$type] = $status;
                $where['case_id'] = $_POST['case_id'];
                $ret = db('case')->where($where)->update($data);
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
    /*
    *   行业列表
    */
    public function trade_list()
    {
        $trade_list = db('trade')->where('pid = 0')->select();
        foreach ($trade_list as $key => $val) {
            $trade_list[$key]['child'] = db('trade')->where('pid ='.$val['trade_id'])->select();
        }
        $this->assign('trade_list',$trade_list);
        return $this->fetch();
    }
    /*
    *  更改排序
    */
    public function up_sort()
    {
        if ($_POST) {
            $where['trade_id'] = $_POST['trade_id'];
            $data['sort'] = $_POST['sort'];
            $ret = db('trade')->where($where)->update($data);
            if ($ret) {
                $res = array('code' => 1, 'msg' => '更新成功');
            }else {
                $res = array('code' => 2, 'msg' => '成功');
            }
            return $res;
        }
    }
    /*
    * 行业
    */
    public function addedit_trade()
    {
        if ($_POST) {
            if( !empty($_POST['trade_name']) && !empty($_POST['sort'])){
                $msg = '';
                $data['pid'] = 0;
                if(!empty($_POST['pid'])){
                    $data['pid'] = $_POST['pid'];
                }

                $data['trade_name'] = $_POST['trade_name'];
                $data['sort'] = $_POST['sort'];
                if (!empty($_POST['trade_id'])) {
                    $trade_id = db('trade')->where('trade_id = '.$_POST['trade_id'])->find()['trade_id'];
                    if($data['pid'] == $trade_id) {
                        $ret = '';
                        $msg = '不能更改到自己的分类下';
                    }else{
                        $ret = db('trade')->where('trade_id ='.$_POST['trade_id'])->update($data);
                    }
                }else {
                    $ret = db('trade')->insert($data);
                }
                if ($ret) {
                    $res = array('code' => 1,'msg' => '成功');
                }else {
                    $res = array('code' => 2, 'msg' => $msg?$msg:'失败');
                }
            }else {
                $res = array('code' => 2, 'msg' => '缺少参数');
            }
            return $res;
        }
        return $this->fetch();
    }
    /*
    *  返回行业详情
    */
    public function trade_info()
    {
        if ($_POST) {
            if(!empty($_POST['trade_id'])){
                $info = db('trade')->where('trade_id ='.$_POST['trade_id'])->find();
                $res = array('code' => 1,'data' => $info);
            }else {
                $res = array('code' => 2,'msg' => '暂无' );
            }
            return $res;
        }
    }
    /*
    * 列表
    */
    public function trade_list2(){
        $trade_list = db('trade')->where('pid = 0')->select();
        return $trade_list;
    }
    /*
    * 列表
    */
    public function make(){
        $make_list = db('make')->paginate(10);
        // dump($make_list);
        $this->assign('list',$make_list);
        $this->assign('page',$make_list->render());
        return view();
    }

    /*
    * 删除预约
    */
    public function del_make(){
        if($_POST){
            $id = $_POST['id'];
            if(is_array($id)){
                foreach ($id as $key => $val) {
                    $res[] = db('make')->where('make_id ='.$val)->delete();
                }
            }else{
                $res = db('make')->where('make_id ='.$id)->delete();
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

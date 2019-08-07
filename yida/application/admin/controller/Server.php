<?php
namespace app\admin\controller;

/**
 *  客服管理
 */
class Server extends Index
{
    /*
    * 客服列表
    */
    public function server_list()
    {
        $server_list = db('server')->paginate(10);
        $this->assign('list',$server_list);
        $this->assign('page',$server_list->render());
        return view();
    }
    /*
    *  添加编辑客服
    */
    public function addedit_server()
    {
        $title = '添加客服';
        $id = '';
        $pos_list = db('server_pos')->select();
        if (!empty($_GET['id'])) {
            $id = $_GET['id'];
            $title = "编辑客服";
            $ser_info = db('server')->where('server_id ='.$id)->find();
            $this->assign('info',$ser_info);
        }
        if ($_POST) {
            $data['server_pos'] = $_POST['server_pos'];
            $data['qq'] = $_POST['qq'];
            $data['wechat'] = $_POST['wechat'];
            $data['mobile'] = $_POST['mobile'];
            $data['trade_num'] = $_POST['trade_num'];
            if ($id) {
                $ret = db('server')->where('server_id ='.$id)->update($data);
            }else {
                $ret = db('server')->insert($data);
            }
            if ($ret) {
                $this->success('成功',url('server/server_list'));
            }else {
                $this->error('失败');
            }
        }
        $this->assign('pos_list',$pos_list);
        $this->assign('title',$title);
        return view();
    }
    /*
    * 删除客服
    */
    public function del_server()
    {
        if($_POST){
            $id = $_POST['id'];
            if(is_array($id)){
                foreach ($id as $key => $val) {
                    $res[] = db('server')->where('server_id ='.$val)->delete();
                }
            }else{
                $res = db('server')->where('server_id ='.$id)->delete();
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
    * 位置列表
    */
    public function pos_list()
    {
        $pos_list = db('server_pos')->paginate(10);
        $this->assign('list',$pos_list);
        $this->assign('page',$pos_list->render());
        return view();
    }
    /*
    * 添加编辑位置信息
    */
    public function addedit_pos()
    {
        $title = '添加客服位置';
        $id = '';
        if (!empty($_GET['id'])) {
            $title = '编辑客服位置';
            $id = $_GET['id'];
            $pos_info = db('server_pos')->where('server_pos  ='.$id)->find();
            $this->assign('info',$pos_info);
        }
        if ($_POST) {
            if (!empty($_POST['pos_name'])) {
                $data['pos_name'] = $_POST['pos_name'];
                if ($id) {
                    $ret = db('server_pos')->where('server_pos ='.$id)->update($data);
                }else {
                    $ret = db('server_pos')->insert($data);
                }
                if ($ret) {
                    $this->success('成功',url('server/pos_list'));
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
    * 删除客服位置
    */
    public function del_pos()
    {
        if($_POST){
            $id = $_POST['id'];
            if(is_array($id)){
                foreach ($id as $key => $val) {
                    $res[] = db('server_pos')->where('server_pos ='.$val)->delete();
                }
            }else{
                $res = db('server_pos')->where('server_pos ='.$id)->delete();
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

<?php
namespace app\admin\controller;
class Custom extends Index
{
    /*
    *   合作客户管理
    */
    public function custom_list()
    {
        $custom_list = db('custom')->paginate(10);
        $this->assign('page',$custom_list->render());
        $this->assign('list',$custom_list);
        return view();
    }
    /*
    *  添加编辑客户
    */
    public function addedit_custom()
    {
        $title = '添加客户';
        $id = '';
        if (!empty($_GET['id'])) {
            $id = $_GET['id'];
            $title = '编辑客户';
            $cus_info = db('custom')->where('custom_id = '.$id)->find();
            $this->assign('info',$cus_info);
        }
        if ($_POST) {
            if (!empty($_POST['cus_com_name']) && !empty($_POST['cus_com_desc']) && !empty($_POST['cus_com_content'])) {
                $data['cus_com_name'] = $_POST['cus_com_name'];
                $data['cus_com_desc'] = $_POST['cus_com_desc'];
                $data['cus_com_content'] = $_POST['cus_com_content'];
                $data['cus_com_te'] = htmlspecialchars($_POST['cus_com_te']);
                $file = request()->file('img');
                if ($file) {
                    $info = $file->validate(['size'=>412000,'ext'=>'jpg,jpeg,png,gif'])->move(ROOT_PATH . 'public/static' . DS . 'upload/custom');
                    if($info) {
                        if ($id) {
                            @unlink(ROOT_PATH.'public'.$case_info['cus_com_img']);
                        }
                        $data['cus_com_img'] = '/static/upload/custom/'.$info->getSaveName();
                    }
                }
                if ($id) {
                    $ret = db('custom')->where('custom_id ='.$id)->update($data);
                }else {
                    $data['is_show'] = 1;
                    $ret = db('custom')->insert($data);
                }
                if ($ret) {
                    $this->success('成功',url('custom/custom_list'));
                }else {
                    $this->error('失败');
                }
            }else {
                $this->error('必填项为空');
            }
        }
        $this->assign('title',$title);
        return view();
    }

    /*
    * 更改状态
    */
    public function up_status(){
        if($_POST){
            if(!empty($_POST['type']) && !empty($_POST['status']) && !empty($_POST['custom_id'])) {
                $type = $_POST['type'];
                $status = $_POST['status'];
                if($status == 1){
                    $status = 2;
                }else {
                    $status = 1;
                }
                $data[$type] = $status;
                $where['custom_id'] = $_POST['custom_id'];
                $ret = db('custom')->where($where)->update($data);
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
    * 删除客户
    */
    public function del_custom(){
        if($_POST){
            $id = $_POST['id'];
            if(is_array($id)){
                foreach ($id as $key => $val) {
                    $res[] = db('custom')->where('custom_id ='.$val)->delete();
                }
            }else{
                $res = db('custom')->where('custom_id ='.$id)->delete();
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

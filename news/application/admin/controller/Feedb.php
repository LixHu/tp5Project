<?php

namespace app\admin\controller;

class Feedb extends Index
{

    public function feedback()
    {
        $where = '1 = 1';
        if(!empty($_POST['type'])){
            $where .= ' and type = '.$_POST['type'];
            $this->assign('type',$_POST['type']);
        }
        $feed_list = db('feedback')->where($where)->order('f_id desc')->paginate(10);
        $type_list = GetFeedType();
        $this->assign('type_list',$type_list);
        $this->assign('page',$feed_list->render());
        $this->assign('feed_list',$feed_list);
        return $this->fetch();
    }

    /*
    * 删除反馈信息
    */
    public function del_feed(){
        if($_POST){
            $id = $_POST['id'];
            if(is_array($id)){
                foreach ($id as $key => $val) {
                    $res[] = db('feedback')->where('f_id ='.$val)->delete();
                }
            }else{
                $res = db('feedback')->where('f_id ='.$id)->delete();
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

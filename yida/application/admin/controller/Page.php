<?php
namespace app\admin\controller;
/**
 * 页面信息
 */
class Page extends Index
{

    /*
    function __construct(argument)
    {
        # code...
    }
    */
    /*
    * 详情
    */
    public function page_info()
    {
        $info_list = db('page_info')->alias('a')->join('page b','a.page_id = b.page_id')->paginate(10);
        // dump($info_list);
        $page_list = db('page')->select();
        $this->assign('page_list',$page_list);
        $this->assign('page',$info_list->render());
        $this->assign('list',$info_list);
        return view();
    }
    /*
    *  获取详情
    */
    public function addedit_info(){
        $page_list = db('page')->select();
        $this->assign('page_list',$page_list);
        if(!empty($_GET['id'])) {
            $id = $_GET['id'];
            $info = db('page_info')->where('info_id ='.$id)->find();
            $this->assign('info',$info);
        }
        return view();
    }
    /*
    * 添加修改详情
    */
    public function addedit_page()
    {
        if ($_POST) {
            if(!empty($_POST['page_id']) && !empty($_POST['info_content'])) {
                $data['page_id'] = $_POST['page_id'];
                $data['info_content'] = $_POST['info_content'];
                if (!empty($_POST['info_id'])) {
                    $where['info_id'] = $_POST['info_id'];
                    $ret = db('page_info')->where($where)->update($data);
                }else {
                    $ret = db('page_info')->insert($data);
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
        }
    }
    /*
    * 删除详情信息
    */
    public function del_page(){
        if($_POST){
            $id = $_POST['id'];
            if(is_array($id)){
                foreach ($id as $key => $val) {
                    $res[] = db('page_info')->where('info_id ='.$val)->delete();
                }
            }else{
                $res = db('page_info')->where('info_id ='.$id)->delete();
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

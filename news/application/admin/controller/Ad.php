<?php
namespace app\admin\controller;

class Ad extends Index
{
    /*
    *  广告列表
    */
    public function ad_list()
    {
        $col_list = db('ad_column')->select();
        $where = '1=1';
        $col_id = '';
        if($_POST){
            if(!empty($_POST['keyword'])){
                $where .= ' and a.title REGEXP \''.$_POST['keyword'].'\'';
                $this->assign('keyword',$_POST['keyword']);
            }
            if($_POST['col_id']){
                $where .= ' and a.col_id = '.$_POST['col_id'];
                $col_id = $_POST['col_id'];
            }
        }
        $this->assign('col_id',$col_id);
        $field = 'a.ad_id,b.col_name,c.user_name,a.title,a.see_count,a.price,a.stock,a.is_show,a.is_groom,d.t_name,a.groom_status,a.end_time,a.add_time';
        $ad_list = db('ad')
                    ->alias('a')
                    ->field($field)
                    ->join('ad_column b','a.col_id = b.col_id')
                    ->join('users c','a.user_id = c.user_id')
                    ->join('groom d','a.t_id = d.t_id','left')
                    ->where($where)
                    ->order('add_time desc')
                    ->paginate(10);
        $this->assign('col_list',$col_list);
        $this->assign('page',$ad_list->render());
        $this->assign('ad_list',$ad_list);
        return $this->fetch();
    }
    /*
    * 推荐广告
    */
    public function groom(){
        if($_POST){
            $ad_id = $_POST['id'];
            $info = db('ad')->where('ad_id ='.$ad_id)->find();
            if($info['groom_status'] == 3){

                $data['groom_status'] = $_POST['status'];

                $g_info = db('groom')->where('t_id ='.$info['t_id'])->find();
                if($data['groom_status'] == 1){
                    $type = GetGroomType($g_info['t_type'])['status']; #
                    $data['end_time'] = strtotime('+'.$g_info['t_time'].' '.$type,time());
                }
                $num = db('ad')->where('col_id ='.$info['col_id'] .' and groom_status = 1')->count();
                if($num < 4 || $data['groom_status'] != 1){
                    $res = db('ad')->where('ad_id = '.$ad_id)->update($data);
                }else{
                    $msg = '分类推荐商品不能大于四个';
                    $res = '';
                }
                if($res){
                    $res = array('code' => 1, 'msg' => '成功');
                }else{
                    $res = array('code' => 2, 'msg' => !empty($msg)?$msg:'失败');
                }
            }else{
                $res = array('code' => 2,'msg' => '已经处理');
            }
            return jsonReturn($res);
        }
    }
    /*
    *  取消推荐
    */
    public function qx_groom()
    {
        if($_POST){
            $ad_id = $_POST['id'];
            $status = $_POST['status'];
            $ret = db('ad')->where('ad_id ='.$ad_id)->update(['groom_status' => 4]);
            if($ret){
                $res = array('code' => 1, 'msg' => '取消成功');
            }else{
                $res = array('code' =>2 ,'msg' => '失败' );
            }
            return jsonReturn($res);
        }
    }
    /*
    *  添加、编辑广告
    */
    public function addedit_ad()
    {
        $title = '添加广告';
        $col_list = db('ad_column')->select();
        if(!empty($_GET['id'])){
            $title = '编辑广告';
            $id = $_GET['id'];
            $ad_info = db('ad')->where('ad_id = '.$id)->find();
            $ad_info['ad_img'] = explode(',',$ad_info['ad_img']);
            $this->assign('info',$ad_info);
            // dump($ad_info);
        }
        $this->assign('col_list',$col_list);
        $this->assign('title',$title);
        return $this->fetch();
    }
    /*
    *  广告详情
    */
    public function ad_info()
    {
        if(!empty($_GET['id'])){
            $id = $_GET['id'];
            $ad_info = db('ad')->where('ad_id = '.$id)->find();
            $ad_info['ad_img'] = explode(',',$ad_info['ad_img']);
            $this->assign('info',$ad_info);
        }
        return $this->fetch();
    }
    /*
    * 删除广告
    */
    public function del_ad(){
        if($_POST){
            $id = $_POST['id'];
            if(is_array($id)){
                foreach ($id as $key => $val) {
                    $res[] = db('ad')->where('ad_id ='.$val)->delete();
                }
            }else{
                $res = db('ad')->where('ad_id ='.$id)->delete();
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
    * 栏目管理
    */
    public function ad_col()
    {
        $col_list = db('ad_column')->paginate(10);
        $this->assign('page',$col_list->render());
        $this->assign('col_list',$col_list);
        return $this->fetch();
    }
    /*
    * 添加编辑分类
    */
    public function addedit_col()
    {
        $title = '添加分类';
        if(!empty($_GET['id'])){
            $title = '编辑分类';
            $id = $_GET['id'];
            $col_info = db('ad_column')->where('col_id = '.$id)->find();
            $this->assign('info',$col_info);
        }else{
            $id = '';
        }
        if($_POST){
            $data['col_name'] = $_POST['col_name'];
            if($id){
                $res = db('ad_column')->where('col_id ='.$id)->update($data);
            }else{
                $data['is_show'] = 1;
                $res = db('ad_column')->insert($data);
            }
            if($res){
                $this->success('成功','ad/ad_col');
            }else{
                $this->error('失败');
            }
        }
        $this->assign('title',$title);
        return $this->fetch();
    }
    /*
    * 删除分类
    */
    public function del_col(){
        if($_POST){
            $id = $_POST['id'];
            if(is_array($id)){
                foreach ($id as $key => $val) {
                    $res[] = db('ad_column')->where('col_id ='.$val)->delete();
                }
            }else{
                $res = db('ad_column')->where('col_id ='.$id)->delete();
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
    * 修改是否显示
    */
    public function update_status()
    {
        if($_POST){
            if(!empty($_POST['id']) && !empty($_POST['status'])){
                $id = $_POST['id'];
                $status = $_POST['status'];
                $data['is_show'] = 1;
                if($status == 1){
                    $data['is_show'] = 2;
                }
                $ret = db('ad_column')->where('col_id ='.$id)->update($data);
                if($ret){
                    $res = array('code' => 1, 'msg' => '更改成功');
                }else {
                    $res = array('code' => 2, 'msg' => '失败');
                }
            }else{
                $res = array('code' => 2, 'msg' => '缺少参数');
            }
            return jsonReturn($res);
        }
    }
    /*
    *  修改广告显示
    */
    public function update_ishow()
    {
        if($_POST){
            if(!empty($_POST['id']) && !empty($_POST['status'])){
                $id = $_POST['id'];
                $status = $_POST['status'];
                $data['is_show'] = 1;
                if($status == 1){
                    $data['is_show'] = 2;
                }
                $ret = db('ad')->where('ad_id ='.$id)->update($data);
                if($ret){
                    $res = array('code' => 1, 'msg' => '更改成功');
                }else {
                    $res = array('code' => 2, 'msg' => '失败');
                }
            }else{
                $res = array('code' => 2, 'msg' => '缺少参数');
            }
            return jsonReturn($res);
        }
    }
}

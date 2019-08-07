<?php
namespace app\admin\controller;
use app\admin\model\Shop;
/**
 *  shop
 */
class Shops extends Index
{
    /*
    *  店铺列表
    */
    public function shop_list()
    {
        $list = Shop::paginate(10);
        $this->assign('page',$list->render());
        $this->assign('list',$list);
        return view();
    }
    /*
    *  添加编辑 店铺
    */
    public function addedit_shop()
    {
        $title = '添加店铺';
        $id = '';
        if (!empty($_GET['id'])) {
            $id = $_GET['id'];
            $sinfo = Shop::get($id);
            $this->assign('info',$sinfo);
        }
        if ($_POST) {
            $shop = new Shop;
            $data = $_POST;
            $file = request()->file('simg');
            if ($file) {
                $info = $file->validate(['size' => 4194304,'ext' => 'jpg,jpeg,gif,png'])->move(ROOT_PATH.'public/static'.DS.'upload/shop/');
                if ($info) {
                    if ($id) {
                        @unlink(ROOT_PATH.'public'.$sinfo->simg);
                    }
                    $data['simg'] = '/static/upload/shop/'.$info->getSaveName();
                }else {
                    $this->error($file->getError());
                }
            }
            if ($id) {
                $res = $shop->save($data,['sid' => $id]);
            }else {
                $res = $shop->save($data);
            }
            if ($res) {
                $this->success('成功',url('shops/shop_list'));
            }else {
                $this->error('失败');
            }
        }
        $this->assign('title',$title);
        return view();
    }
    /**
     * 首页描述图片管理
     */
    public function index_info()
    {
        $list = db('index')->paginate(10);
        $page = $list->render();
        $indexdesc = db('company')->where('com_id = 1')->find();
        $this->assign('indexdesc',$indexdesc['indexdesc']);
        $this->assign('list',$list);
        $this->assign('page',$page);
        return view();
    }
    /**
     * 首页文字修改
     */
    public function SetIndexDesc()
    {
        $res = array('code' => 2,'msg' => '失败');
        if($_POST){
            $desc = $_POST['indexdesc'];
            $ret = db('company')->where('com_id = 1')->update(['indexdesc' =>  $desc]);
            if($ret){
                $res = array('code' => 1,'msg' => '成功');
            }
        }
        return $res;
    }
    /**
     * 添加编辑主页图片
     */
    public function addedit_info()
    {
        $title = '添加图片';
        $id = '';
        if(!empty($_GET['id'])){
            $title = '编辑图片';
            $id = $_GET['id'];
            $img_info = db('index')->where('img_id ='.$id)->find();
            $this->assign('info',$img_info);
        }
        if($_POST){
            $data['img_name'] = $_POST['img_name'];
//            dump(request());
            $file = request()->file("img_url");
            if($file) {
                $info = $file->validate(['size' => 10000000 ,'ext'=>'jpg,jpeg,png,gif'])->move(ROOT_PATH . 'public/static' . DS . 'upload/index/');
                if ($info) {
                    if($id){
                        @unlink(ROOT_PATH.'public/'.$img_info['img_url']);
                    }
                    $data['img_url'] = '/static/upload/index/'.$info->getSaveName();
                }else {
                    $this->error($file->getError());
                }
            }
            if($id){
                $ret = db('index')->where('img_id ='.$id)->update($data);
            }else{
                $data['is_show'] = 1;
                $ret = db('index')->insert($data);
            }
            if ($ret){
                $this->success('成功',url('shops/index_info'));
            }else{
                $this->error('失败');
            }
        }
        $this->assign('title',$title);
        return view();
    }
    public function SetDesc()
    {
        $res = array('code' => 2,'msg' => '失败');
        if($_POST){
            if(!empty($_POST['indextitle']) && !empty($_POST['indexshowdesc'])){
                if(db('company')->where('com_id = 1')->update($_POST)){
                    $res = array('code' => 1,'msg' => '成功');
                }
            }
        }
        return $res;
    }
}

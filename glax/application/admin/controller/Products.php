<?php
namespace app\admin\controller;
use app\admin\model\Product;
use app\admin\model\Category;
use think\Loader;
/**
 *  product
 */
class Products extends Index
{
    /*
    *  产品列表
    */
    public function pro_list()
    {
        $product = new Product;
        $list = $product->select();
        $this->assign('page',$list->render());
        $this->assign('list',$list);
        return view();
    }
    /*
    *  添加编辑 产品
    */
    public function addedit_pro()
    {
        $cat = new Category;
        $cat_list = $cat->select();
        $id = '';
        $title = '添加产品';
        if (!empty($_GET['id'])) {
            $title = '编辑产品';
            $id = $_GET['id'];
            $pro_info = Product::get($id);
            $this->assign('info',$pro_info);
        }
        if ($_POST) {
            $data = $_POST;
            $file = request()->file('p_img');
            if($file) {
                $info = $file->validate(['size' => 10000000 ,'ext'=>'jpg,jpeg,png,gif'])->move(ROOT_PATH . 'public/static' . DS . 'upload/product/');
                if ($info) {
                    $data['p_img'] = '/static/upload/product/'.$info->getSaveName();
                }else {
                    $this->error($file->getError());
                }
            }
            $product = new Product;
            if ($id) {
                $data['p_id'] = $id;
                $res = $product->save($data,["p_id" => $id]);
            }else {
                $data['is_groom'] = 2;
                $data['is_ab_us'] = 2;
                $res = $product->save($data);
            }
            if ($res) {
                $this->success('成功',url('products/pro_list'));
            }else {
                $this->error('失败');
            }
        }
        $this->assign('categroy',$cat_list);
        $this->assign('title',$title);
        return view();
    }
    /*
    *  category
    */
    public function category()
    {
        $cat = new Category;
        $list = $cat->where('pid = 0')->select();
//        $this->assign('page',$list->render());
        foreach ($list as $key => $val){
            $list[$key]['child'] =  $cat->where('pid ='.$val['cid'])->select();
        }
        $this->assign('list',$list);
        return view();
    }
    /*
    *  addedit_cat
    */
    public function addedit_cat()
    {
        $validate = Loader::validate('Category');
        $title = '添加分类';
        $id = '';
        $cat = new Category;
        if (!empty($_GET['id'])) {
            $title = '编辑分类';
            $id = $_GET['id'];
            $cat_info = $cat->find($id);
            $this->assign('info',$cat_info);
        }
        if ($_POST) {
            $data = $_POST;
            $file = request()->file('cimg');
            if($file) {
                $info = $file->validate(['size' => 7000000 ,'ext'=>'jpg,jpeg,png,gif'])->move(ROOT_PATH . 'public/static' . DS . 'upload/product/');
                if ($info) {
                    if ($id) {
                        @unlink(ROOT_PATH.'public'.$cat_info->cimg);
                    }
                    $data['cimg'] = '/static/upload/product/'.$info->getSaveName();
                }else {
                    $this->error($file->getError());
                }
            }
            if ($validate->check($data)) {
                if ($id) {
                    $ret = $cat->save($data,['cid' => $id]);
                }else {
                    $data['is_groom'] = 2;
                    $data['is_btn1'] = 2;
                    $data['is_btn2'] = 2;
                    $data['is_btn3'] = 2;
                    $data['is_btn4'] = 2;
                    $ret = $cat->save($data);
                }
                if ($ret) {
                    $this->success('成功',url('products/category'));
                }else {
                    $this->error('失败');
                }
            }else{
                $this->error($validate->getError());
            }
        }
        $list = $cat->where('pid = 0')->select();
        $this->assign('categroy',$list);
        $this->assign('title',$title);
        return view();
    }
}

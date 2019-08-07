<?php
namespace app\jielv\controller;

use app\jielv\model\Parts;
use app\jielv\model\PartsCate;
use app\jielv\model\Addpurchase;
use think\Db;
use app\jielv\model\Purchase;

/**
 * ========================================================
 * ==商城管理==
 * ========================================================
 */
class Goods extends Index
{

    /**
     * 商品列表
     */
    public function goods_all()
    {   
        
             // 获取产品信息
            $ps = model('GoodsModel');
            $parts = $ps->getgoods_list();
            $parts_all = [];
            //把对象转化为数组
            foreach ($parts as $key => $val){
                $parts_all[] = $val->toArray();
            }

            $page = $parts->render();
            $res = $parts->isEmpty();
            $this->assign('page', $page);//分页
            $this->assign('parts_all', $parts_all);
            $this->assign('res', $res);
        
        return view();
    }

    /**
     * 新建产品
     */
    public function goods_add()
    {   
        // $gid = json_decode(session('user')['gid']);//获取到当前操作用户的分类ID
        $data = input('post.');
        $data['ad_time'] = time();
        $data['status'] = 1;//默认状态
        $data['hot'] = 1;//默认状态
        // $data['gid'] =$gid;
        $res = Db::name('goods')->where('name',$data['name'])->find();
        if (!empty($res)){
            $this->error('产品已存在，请勿重复添加');
        }
        // 实例化模型
        $ps = model('GoodsModel');
        $parts_new = $ps->ad_goods($data);
        $ps->getLastSql();
        if ($parts_new) {
            $this->redirect('Goods/goods_all');
        } else {
            $this->redirect('Goods/goods_all');
        }
    }


     /**
     * 编辑产品
     */
    public function goods_edit()
    {
        $gid = json_decode(session('user')['gid']);
        // 判断是否有数据传递过来
        if ($_POST) {
            // 接收数据
            $param = input('post.');
            
            // 实例化模型
            $se = model('GoodsModel');
            $ep = $se->editparts($param);
            if (! empty($ep)) {
                $this->redirect('Goods/goods_all');
            } else {
                $this->redirect('Goods/goods_all');
            }
        }
        
        $id = input('param.id');
        $ep = model('GoodsModel');

        $this->assign('se', $ep->getOneAd($id));

        return view();
    }
   

    /**
     * 删除产品
     */
    public function delparts()
    {
        $id = input('param.id');
        
        if (Db::name('parts')->where('id', $id)->delete()) {
            echo "1";
        } else {
            echo "0";
        }
    }

    /**
     * 批量删除
     */
    public function del()
    {
        $data = input('param.id/a');
        $param = implode(",",$data);

        $am = model('GoodsModel');
        $res = $am->del($param);
            if ($res) {
                return 1;
            } else {
                return 0;
            }
    }

    /**
     * 搜索商品
     */
    public function search_goods()
    {   
        
        // 接收所搜的关键字
        $keywords = input('param.keyword');
        if ($keywords) {
            // 关键字模糊查询
            $ps = model('GoodsModel');
            $parts = $ps->search_list($keywords); 
            

            $parts_all = [];
            //把对象转化为数组
            foreach ($parts as $key => $val){
                $parts_all[] = $val->toArray();
            }
            

            $page = $parts->render();//分页
            $res = $parts->isEmpty();//判断数据集
            $this->assign('res', $res);
            $this->assign('page', $page);//分页
            $this->assign('data', $parts_all);
        } else {
            $this->error('暂无相关信息');
        }
        return $this->fetch('goods_all');
    }

    // /**
    //  * 删除产品分类
    //  */
    // public function delpartscate($cateid)
    // {
    //     if ($cateid) {
    //         Db::name('partscate')->where('id', $cateid)->delete();
    //         $this->redirect('Accessories/parts_all');
    //     } else {
    //         $this->error('删除失败');
    //     }
    // }

    /**
     * 修改产品状态
     */
    public function save_status()
    {   
        if (request()->isAjax()) {
            $id = input('param.id');
            $status = Db::name('goods')->where('id', $id)->value('status'); // 判断当前状态
            if ($status == 1) {
                // 修改状态(禁用状态)
                $flag = Db::name('goods')->where('id', $id)->setField([
                    'status' => 2
                ]);
                return 1;
            } else {
                // 修改状态(启用状态)
                $flag = Db::name('goods')->where('id', $id)->setField([
                    'status' => 1
                ]);
                return 1;
            }
        }else{
            return 3;
        }
    }

    /**
     * 设置热门
     */
     public function save_hot(){
        if (request()->isAjax()) {
            $id = input('param.hid');
            $go = model('GoodsModel');
            $res = $go->getOneAd($id);
            if ($res['hot'] == 1) {
                $flag = db('goods')->where('id',$id)->setField(['hot'=>2]);
                if ($flag) {
                    return 1;
                }else{
                    return 0;
                }
            }else{
                $flag = db('goods')->where('id',$id)->setField(['hot'=>1]);
                if ($flag) {
                    return 1;
                }else{
                    return 0;
                }
            }
        }
     }
   


    /**
     * 删除产品分类
     */
    public function delcate()
    {
        $id = input('param.id');
        
        if (Db::name('partscate')->where('id', $id)->delete()) {
            echo "1";
        } else {
            echo "0";
        }
    }


    //添加产品分类
    public function ad_cate(){

        if ($_POST) {

            $param = input('post.');
            // $param['gid'] = json_decode(session('user')['gid']);
            $cate = model('GoodsCate');
            $res = $cate->cate_add($param);
            if ($res) {
                $this->redirect('Goods/goods_all');
            }else{
                $this->error('添加失败');
            }
        }

        return view();
    }
        
    /**
     * 问题帮助
     */
    public function problem(){

        $ps = model('Problem');
        $data = $ps->getproblem_list();
        $page = $data->render();
        $res = $data->isEmpty();
        $this->assign('page', $page);//分页
        $this->assign('data', $data);
        $this->assign('res', $res);

        return view();
    }

    /**
     * 新增问题帮助
     */
    public function add_problem(){
        if ($_POST) {
            $param = input('post.');
            $ps = model('Problem');
            $res = $ps->ad_problem($param);
            if ($res) {
                $this->redirect('Goods/problem');
            }else{
                $this->redirect('Goods/problem');
            }
        }
        
    }


    /**
     * 删除问题帮助
     */
    public function del_problem()
    {
        $data = input('param.id/a');
        $param = implode(",",$data);

        $am = model('Problem');
        $res = $am->del($param);
            if ($res) {
                return 1;
            } else {
                return 0;
            }
    }


    /**
     * 编辑问题帮助
     */
    public function problem_edit()
    {
        
        // 判断是否有数据传递过来
        if ($_POST) {
            // 接收数据
            $param = input('post.');
            
            // 实例化模型
            $se = model('Problem');
            $ep = $se->editproblem($param);
            if (! empty($ep)) {
                $this->redirect('Goods/problem');
            } else {
                $this->redirect('Goods/problem');
            }
        }
        
        $id = input('param.id');
        $ep = model('Problem');

        $this->assign('se', $ep->getOneAd($id));

        return view();
    }

     /**
     * 搜索问题帮助
     */
    public function search_problem()
    {   
        
        // 接收所搜的关键字
        $keywords = input('param.keyword');
        if ($keywords) {
            // 关键字模糊查询
            $ps = model('Problem');
            $parts = $ps->search_list($keywords); 
            

            $parts_all = [];
            //把对象转化为数组
            foreach ($parts as $key => $val){
                $parts_all[] = $val->toArray();
            }
            

            $page = $parts->render();//分页
            $res = $parts->isEmpty();//判断数据集
            $this->assign('res', $res);
            $this->assign('page', $page);//分页
            $this->assign('data', $parts_all);
        } else {
            $this->error('暂无相关信息');
        }
        return $this->fetch('problem');
    }


    /**
     * 商品订单
     */
    public function goods_order(){
        
        $ps = model('GoodsOrder');
        $data = $ps->getorder_list();
        $page = $data->render();
        $res = $data->isEmpty();
        $this->assign('page', $page);//分页
        $this->assign('data', $data);
        $this->assign('res', $res);
        return view();
    }

     /**
     * 搜索订单
     */
    public function search_order()
    {   
        
        // 接收所搜的关键字
        $keywords = input('param.keyword');
        if ($keywords) {
            // 关键字模糊查询
            $ps = model('GoodsOrder');
            $parts = $ps->search_list($keywords); 
            

            $parts_all = [];
            //把对象转化为数组
            foreach ($parts as $key => $val){
                $parts_all[] = $val->toArray();
            }
            

            $page = $parts->render();//分页
            $res = $parts->isEmpty();//判断数据集
            $this->assign('res', $res);
            $this->assign('page', $page);//分页
            $this->assign('data', $parts_all);
        } else {
            $this->error('暂无相关信息');
        }
        return view('goods_order');
    }

    /**
     * 审核订单
     */
    public function audit(){
        if (request()->isAjax()) {
            $id = input('param.id');
            $res = db('goods_order')->where('id',$id)->value('status');
            if ($res == 1) {
                $flag = db('goods_order')->where('id',$id)->setField(['status'=>2]);
                if ($flag) {
                    return 1;
                }else{
                    return 0;
                }
            }else{
                $flag = db('goods_order')->where('id',$id)->setField(['status'=>1]);
                if ($flag) {
                    return 1;
                }else{
                    return 0;
                }
            }
        }
    }

   /**
     * 发货
     */
    public function fahuo(){
        if (request()->isAjax()) {
            $oid = input('param.oid');
            $tracking_number = input('param.tracking_number');
            $o_status = db('goods_order')->where('id',$oid)->value('status');
            if ($o_status == 1) {
                $res = db('goods_order')->where('id',$oid)->update(['status'=>2,'tracking_number'=>$tracking_number]);
                if ($res) {
                    return 1;
                }else{
                    return 0;
                }
            }else{
                $res = db('goods_order')->where('id',$oid)->update(['tracking_number'=>$tracking_number]);
                if ($res) {
                    return 1;
                }else{
                    return 0;
                }
            }
        }else{
            return 3;
        }
    }

    /**
     * 删除订单
     */
    public function del_order()
    {
        $data = input('param.id/a');
        $param = implode(",",$data);

        $am = model('GoodsOrder');
        $res = $am->del($param);
            if ($res) {
                return 1;
            } else {
                return 0;
            }
    }
}

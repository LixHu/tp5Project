<?php
namespace app\jielv\controller;

use app\jielv\model\Parts;
use app\jielv\model\PartsCate;
use app\jielv\model\Addpurchase;
use think\Db;
use app\jielv\model\Purchase;

/**
 * ========================================================
 * ==优惠券管理==
 * ========================================================
 */
class Coupons extends Index
{

    /**
     * 优惠券列表
     */
    public function parts_all()
    {   
        
        
        $cateid = input('param.cateid');
        isset($cateid) ? $cateid : '';
        if (empty($cateid)) { // 查看全部产品
                                // 获取产品信息
            $ps = new Parts();
            $parts = $ps->getpartsall();
            $parts_all = [];
            //把对象转化为数组
            foreach ($parts as $key => $val){
                $parts_all[] = $val->toArray();
            }
            //把分类id值替换成对应的分类名
            foreach ($parts_all as $key => $value) {
                $parts_all[$key]['cateid'] = db('partscate')->where(['id'=>$parts_all[$key]['cateid']])->value('name');
            }
            // 获取分类
            $pc = new PartsCate();
            $partscate = $pc->getpartscate();
            $page = $parts->render();
            $res = $parts->isEmpty();
            $this->assign('page', $page);//分页
            $this->assign('partscate', $partscate);
            $this->assign('parts_all', $parts_all);
             
            $this->assign('res', $res);
        } else {
            $ps = new Parts();
            $parts = $ps->getcatepartsall($cateid);
            $parts_all = [];
            //把对象转化为数组
            foreach ($parts as $key => $val){
                $parts_all[] = $val->toArray();
            }
            //把分类id值替换成对应的分类名
            foreach ($parts_all as $key => $value) {
                $parts_all[$key]['cateid'] = db('partscate')->where(['id'=>$parts_all[$key]['cateid']])->value('name');
            }
            // 获取分类
            $pc = new PartsCate();
            $partscate = $pc->getpartscate();
            $page = $parts->render();
            $res = $parts->isEmpty();//判断数据集
            $this->assign('res', $res);
            $this->assign('page', $page);//分页
            $this->assign('parts_all', $parts_all);
            $this->assign('partscate', $partscate);
            
        }   
            $this->assign('cateid', $cateid);
        
        return view();
    }

    /**
     * 新建产品
     */
    public function parts_new()
    {   
        $gid = json_decode(session('user')['gid']);//获取到当前操作用户的分类ID
        $data = input('post.');
        $data['start_time'] = strtotime($data['start_time']);
        $data['end_time'] = strtotime($data['end_time']);
        $data['ad_time'] = time();
        
        //
        $res = Db::name('parts')->where(['name'=>$data['name']])->find();
        if (!empty($res)){
            $this->error('产品已存在，请勿重复添加');
        }
        // 实例化模型
        $ps = model('Parts');
        $parts_new = $ps->addparts($data);
        $ps->getLastSql();
        if ($parts_new) {
            $this->redirect('Coupons/parts_all');
        } else {
            $this->redirect('Coupons/parts_all');
        }
        
        
    }


     /**
     * 编辑产品
     */
    public function parts_edit()
    {
        $gid = json_decode(session('user')['gid']);
        // 判断是否有数据传递过来
        if ($_POST) {
            // 接收数据
            $param = input('post.');
            $param['start_time'] = strtotime($param['start_time']);
            $param['end_time'] = strtotime($param['end_time']);
            // 实例化模型
            $se = new Parts();
            $ep = $se->editparts($param);
            if (! empty($ep)) {
                $this->redirect('Coupons/parts_all');
            } else {
                $this->redirect('Coupons/parts_all');
            }
        }
        
        $id = input('param.id');
        // 获取分类
        $pc = new PartsCate();
        $partscate = $pc->getpartscate();
        // 实例化模型
        $ep = new Parts();
        $this->assign('se', $ep->getOneAd($id));
        $this->assign('partscate', $partscate);
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

        $am = model('Parts');
        $res = $am->del($param);
            if ($res) {
                return 1;
            } else {
                return 0;
            }
    }

    /**
     * 删除产品分类
     */
    public function delpartscate($cateid)
    {
        if ($cateid) {
            Db::name('partscate')->where('id', $cateid)->delete();
            $this->redirect('Coupons/parts_all');
        } else {
            $this->redirect('Coupons/parts_all');
        }
    }

    /**
     * 修改产品状态
     */
    public function parts_status()
    {
        $id = input('get.id');
        $status = Db::name('parts')->where('id', $id)->value('status'); // 判断当前状态
        if ($status == 1) {
            // 修改状态(禁用状态)
            $flag = Db::name('parts')->where('id', $id)->setField([
                'status' => 2
            ]);
            return $this->redirect('Coupons/parts_all');
        } else {
            // 修改状态(启用状态)
            $flag = Db::name('parts')->where('id', $id)->setField([
                'status' => 1
            ]);
            return $this->redirect('Coupons/parts_all');
        }
    }

    /**
     * 搜索优惠券
     */
    public function search_parts()
    {   
        $cateid = input('get.cateid');//此处是为了避免模板页面出错,可以忽视此变量
        $gid = json_decode(session('user')['gid']);//获取到当前操作用户的分类ID
        // 接收所搜的关键字
        $keywords = input('param.keyword');
        if ($keywords) {
            // 关键字模糊查询
            $ps = new Parts();
            $parts = $ps->search_list($keywords); 
            // 获取分类
            $ps = new PartsCate();
            $partscate = $ps->getpartscate();

            $parts_all = [];
            //把对象转化为数组
            foreach ($parts as $key => $val){
                $parts_all[] = $val->toArray();
            }
            //把分类id值替换成对应的分类名
            foreach ($parts_all as $key => $value) {
                $parts_all[$key]['cateid'] = db('partscate')->where(['id'=>$parts_all[$key]['cateid']])->value('name');
                
            }

            $page = $parts->render();//分页
            $res = $parts->isEmpty();//判断数据集
            $this->assign('res', $res);
            $this->assign('page', $page);//分页
            $this->assign('partscate', $partscate);
            $this->assign('parts_all', $parts_all);
        } else {
            $this->error('暂无相关信息');
        }
        $this->assign('cateid',$cateid);
        return $this->fetch('parts_all');
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


    //添加优惠券分类
    public function ad_cate(){

        if ($_POST) {

            $param = input('post.');
            $cate = new PartsCate;
            $res = $cate->adcate($param);
            if ($res) {
                $this->redirect('Coupons/parts_all');
            }else{
                $this->error('添加失败');
            }
        }

        return view();
    }
}

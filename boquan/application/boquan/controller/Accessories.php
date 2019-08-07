<?php
namespace app\boquan\controller;

use app\boquan\model\Parts;
use app\boquan\model\PartsCate;
use app\boquan\model\Addpurchase;
use think\Db;
use app\boquan\model\Purchase;

/**
 * ========================================================
 * ==配件管理==
 * ========================================================
 */
class Accessories extends Index
{

    /**
     * 配件明细列表
     */
    public function parts_all()
    {   
        $gid = json_decode(session('user')['gid']);//获取到当前操作用户的分类ID
        $rid = session('user')['rid'];
        
        $cateid = input('param.cateid');
        isset($cateid) ? $cateid : '';
        if (empty($cateid)) { // 查看全部产品
                                // 获取产品信息
            $ps = new Parts();
            $parts_all = $ps->getpartsall();

            // 获取分类
            $pc = new PartsCate();
            $partscate = $pc->getpartscate($gid);
            $page = $parts_all->render();
            $res = $parts_all->isEmpty();
            
            $this->assign('page', $page);//分页
            $this->assign('partscate', $partscate);
            $this->assign('parts_all', $parts_all);
            $this->assign('rid', $rid);
            $this->assign('res', $res);
        } else {
            
            
            $parts_all = Db::name('parts')->where(['cateid'=>$cateid,'gid'=>$gid])->paginate(10);

            // 获取分类
            $pc = new PartsCate();
            $partscate = $pc->getpartscate($gid);
            $page = $parts_all->render();
            $res = $parts_all->isEmpty();//判断数据集
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
        $data['ad_time'] = time();
        $data['gid'] =$gid;
        //
        $res = Db::name('parts')->where(['product_number'=>$data['product_number'],'gid'=>$gid])->find();
        if (!empty($res)){
            $this->error('产品编号已存在，请重新输入');
        }
        // 实例化模型
        $ps = new Parts();
        $parts_new = $ps->addparts($data);
        $ps->getLastSql();
        if ($parts_new) {
            $this->redirect('Accessories/parts_all');
        } else {
            $this->error('操作失败');
        }
        
        return $this->fetch('parts_all');
    }

    /**
     * 配件采购
     */
    public function parts_purchase()
    {  
        
        $user_id = json_decode(session('user')['uid']);//获取到当前操作用户的ID
        $gid = json_decode(session('user')['gid']);//获取到当前操作用户的分类ID
        $pid = json_decode(session('user')['pid']);//获取到当前操作用户的分类ID
        // 自动生成采购单号
        $year_code = array('CG' );
        $order_sn = $year_code[intval(date('Y')) - 2018] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), - 5) . substr(microtime(), 2, 5) . sprintf(rand(0, 99));
       //获取提交过来的采购订单所有数据
        if ($_POST) {
            $purchase = input('post.');
            if ($purchase) {
                $purchase['user_id'] =  $user_id;
                $purchase['sid'] = 1;   //此状态采购订单
                $pd = Db::name('add_purchase')->where(['user_id'=>$user_id,'sid'=>1])->order('id desc')->select(); // 获取采购订单添加的产品
                //把产品信息加入数组
                $purchase['product'] = json_encode($pd);
                
                $purchase['gid'] = $gid;//所属用户组分类
                $purchase['pid'] = session('user')['gname'];//所属区域
                $purchase['add_time'] = time();
                $purchase['status'] = 4;//此为订单状态

                $pc = new Purchase();
                $se = $pc->adpurchase($purchase);
                $aid = Db::name('purchase')->getLastInsID();
                
                $aud['type'] = 2;
                $aud['rela_id'] = $aid;
                $aud['table'] = 'purchase';
                $aud['gid'] = $gid;
                $aud['add_time'] = time();
                $aud['status'] = 4;
                $aud['p_status'] = 4;
                Db::name('aud_list')->insert($aud);
                Db::name('add_purchase')->where(['user_id'=>$user_id,'sid'=>1])->delete();//提交订单成功之后清除当前用户所添加的产品
                
                $this->redirect('Accessories/parts_purchase');
            }else {
                $this->error('提交失败');
            }
        }else {
            $add_purchase = Db::name('add_purchase')->select(); // 添加的产品
            $partscate = Db::name('partscate')->where('gid',$gid)->select(); // 产品分类
            $supplier = Db::name('supplier')->select(); // 供应商
            $warehouse = Db::name('user_group')->where('gid',$pid)->select(); // 仓库
            $buyer = Db::name('users')->where(['rid'=>95,'gid'=>$gid])->select(); // 采购人员
            $purchaselist = Db::name('add_purchase')->where(['user_id'=>$user_id,'sid'=>1])->order('id desc')->select(); // 采购订单添加的产品
            $count_total= db('add_purchase')->where(['user_id'=>$user_id,'sid'=>1])->sum('count');//总数量
            $price_total= db('add_purchase')->where(['user_id'=>$user_id,'sid'=>1])->sum('price_total');//总价格
            
            $this->assign('supplier', $supplier);
            $this->assign('warehouse', $warehouse);
            $this->assign('buyer', $buyer);
            $this->assign('partscate', $partscate);
            $this->assign('add_purchase', $add_purchase);
            $this->assign('purchaselist', $purchaselist);
            $this->assign('price_total', $price_total);
            $this->assign('count_total', $count_total);
        }
        
        
            $this->assign('order_sn', $order_sn);
        
        return view();
    }

    /**
     * 采购订单添加产品
     */
    public function add_purchase()
    {   
        $user_id = json_decode(session('user')['uid']);//获取到当前操作用户的ID
        $gid = json_decode(session('user')['gid']);//获取到当前操作用户的分类ID
        if ($_POST) {
           
            $param = input('post.');
            //判断添加的产品是否存在
            $res = db('parts')->where(['product_number'=>$param['product_number'],'gid'=>$gid])->find();
            if (empty($res)) {
                $this->error('产品不存在,请核实后再添加',url('Accessories/parts_purchase'));
            }
            $se = db('add_purchase')->where(['product_number'=>$param['product_number'],'user_id'=>$user_id,'sid'=>1])->find();
            if ($se) {
                $this->error('产品已存在,请勿重复添加',url('Accessories/parts_purchase'));
            }
            $param['price_total'] = $param['price']*$param['count']; //计算当前提交过来的产品总价格
            $param['sid'] = 1;   //此为采购订单内添加的产品
            $param['user_id'] =  $user_id;
            
                $pc = new Addpurchase();
                $res = $pc->adpurchase($param);
                if ($res) {
                    $this->redirect('Accessories/parts_purchase');
                } else {
                    $this->success('添加失败', url('Accessories/parts_purchase'));
                }
            
        }
    }

    /**
     * 删除订单添加的产品
     */
    public function delpurchase()
    {
        $id = input('param.id');
        if ($id) {
            if (Db::name('add_purchase')->where('id',$id)->delete()) {
                echo "1";
            } else {
                echo "0";
            }
        }
        
    }

    /**
     * 配件销售
     */
    public function parts_sales()
    {   
        $user_id = json_decode(session('user')['uid']);//获取到当前操作用户的ID

        $gid = json_decode(session('user')['gid']);//获取到当前操作用户的分类ID
        $pid = json_decode(session('user')['pid']);//获取到当前操作用户的分类ID
        // 自动生成采购单号
        $year_code = array('XS' );
        $order_sn = $year_code[intval(date('Y')) - 2018] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), - 5) . substr(microtime(), 2, 5) . sprintf(rand(0, 99));
        //获取提交过来的采购订单所有数据
        if ($_POST) {
            $purchase = input('post.');
            $purchase['user_id'] =  $user_id;
            $purchase['sid'] = 2;   //此状态销售订单
            $pd = Db::name('add_purchase')->where(['user_id'=>$user_id,'sid'=>2])->order('id desc')->select(); // 获取采购订单添加的产品
            //把产品信息加入数组
            $purchase['product'] = json_encode($pd);

            $purchase['gid'] = $gid;
            $purchase['pid'] = session('user')['gname'];//所属区域
            $purchase['add_time'] = time();
            $purchase['status'] = 4;//此为订单状态
            
           

            
            
                $pc = new Purchase();
                $pc->adpurchase($purchase);
                $aid = Db::name('purchase')->getLastInsID();
                
                $aud['type'] = 3;
                $aud['rela_id'] = $aid;
                $aud['table'] = 'purchase';
                $aud['gid'] = $gid;
                $aud['add_time'] = time();
                $aud['status'] = 4;
                $aud['p_status'] = 4;
                Db::name('aud_list')->insert($aud);
                
                Db::name('add_purchase')->where(['user_id'=>$user_id,'sid'=>2])->delete();//提交订单成功之后清除当前用户所添加的产品
                
                $this->redirect('Accessories/parts_sales');
            
        }else {
            $add_purchase = Db::name('add_purchase')->select(); // 产品分类
            $partscate = Db::name('partscate')->where('gid',$gid)->select(); // 产品分类
            
            $warehouse = Db::name('user_group')->where('gid',$pid)->select(); // 仓库
            $buyer = Db::name('users')->where(['rid'=>8,'gid'=>$gid])->select(); // 销售人员
            $purchaselist = Db::name('add_purchase')->where(['user_id'=>$user_id,'sid'=>2])->order('id desc')->select(); // 订单添加的产品
            $count_total= db('add_purchase')->where(['user_id'=>$user_id,'sid'=>2])->sum('count');//总数量
            $price_total= db('add_purchase')->where(['user_id'=>$user_id,'sid'=>2])->sum('price_total');//总价格
            
            $this->assign('warehouse', $warehouse);
            $this->assign('buyer', $buyer);
            $this->assign('partscate', $partscate);
            $this->assign('add_purchase', $add_purchase);
            $this->assign('purchaselist', $purchaselist);
            $this->assign('price_total', $price_total);
            $this->assign('count_total', $count_total);
        }
        
        
        $this->assign('order_sn', $order_sn);
        return view();
    }
    
    
    /**
     * 销售订单添加产品
     */
    public function add_sales()
    {   
        $user_id = json_decode(session('user')['uid']);//获取到当前操作用户的ID
        $gid = json_decode(session('user')['gid']);//获取到当前操作用户的分类ID
        if ($_POST) {
            $param = input('post.');
            //判断添加的产品是否存在
            $res = db('parts')->where(['product_number'=>$param['product_number'],'gid'=>$gid])->find();
            if (empty($res)) {
                $this->error('产品不存在,请核实后再添加',url('Accessories/parts_sales'));
            }
            $se = db('add_purchase')->where(['product_number'=>$param['product_number'],'user_id'=>$user_id,'sid'=>2])->find();
            if ($se) {
                $this->error('产品已存在,请勿重复添加',url('Accessories/parts_sales'));
            }

            $param['price_total'] = $param['price']*$param['count'];
            
            $param['sid'] = 2;   //此为销售订单内添加的产品
            $param['user_id'] =  json_decode(session('user')['uid']);//获取到当前操作用户的ID
            
                $pc = new Addpurchase();
                $res = $pc->adpurchase($param);
                if ($res) {
                    $this->redirect('Accessories/parts_sales');
                } else {
                    $this->success('添加失败', url('Accessories/parts_sales'));
                }
            
            
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
            
            // 实例化模型
            $se = new Parts();
            $ep = $se->editparts($param);
            if (! empty($ep)) {
                $this->redirect('Accessories/parts_all');
            } else {
                $this->error('编辑失败');
            }
        }
        
        $id = input('param.id');
        // 获取分类
        $pc = new PartsCate();
        $partscate = $pc->getpartscate($gid);
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

        $am = new Parts;
        $res = $am->del($param);
            if ($res) {
                echo "1";
            } else {
                echo "0";
            }
    }

    /**
     * 删除产品分类
     */
    public function delpartscate($cateid)
    {
        if ($cateid) {
            Db::name('partscate')->where('id', $cateid)->delete();
            $this->redirect('Accessories/parts_all');
        } else {
            $this->error('删除失败');
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
            return $this->redirect('Accessories/parts_all');
        } else {
            // 修改状态(启用状态)
            $flag = Db::name('parts')->where('id', $id)->setField([
                'status' => 1
            ]);
            return $this->redirect('Accessories/parts_all');
        }
    }

    /**
     * 搜索产品
     */
    public function search_parts()
    {   
        $cateid = input('get.cateid');//此处是为了避免模板页面出错,可以忽视此变量
        $gid = json_decode(session('user')['gid']);//获取到当前操作用户的分类ID
        // 接收所搜的关键字
        $keywords = input('param.keyword');
        if ($keywords) {
            // 关键字模糊查询 
            $parts_all = Db::name('parts')->where(['product_number|name'=>['like','%'.$keywords.'%'],'gid'=>$gid])
                ->order('id desc')
                ->paginate(10,false,['query' => request()->param(), ]);
            // 获取分类
            $ps = new PartsCate();
            $partscate = $ps->getpartscate($gid);

            $page = $parts_all->render();//分页
            $res = $parts_all->isEmpty();//判断数据集
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


    //添加产品分类
    public function ad_cate(){

        if ($_POST) {

            $param = input('post.');
            $param['gid'] = json_decode(session('user')['gid']);
            $cate = new PartsCate;
            $res = $cate->adcate($param);
            if ($res) {
                $this->redirect('Accessories/parts_all');
            }else{
                $this->error('添加失败');
            }
        }

        return view();
    }
}

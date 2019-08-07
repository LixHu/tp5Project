<?php
namespace app\jielv\controller;
use app\jielv\model\Parts;
use app\jielv\model\Check;
use app\jielv\model\Safety;
use app\jielv\model\Safenumber;
use app\jielv\model\Inventory;
use app\jielv\model\PartsCate;
use app\jielv\model\Purchase;
use think\Db;
use think\Request;

/**
 * ==================================================================
 * ==库存管理==
 * ==================================================================
 */
class Inventorys extends Index
{

    /**
     * ===============================
     * ==供应商==
     * ===============================
     */
    
    /**
     * 供应商列表
     */
    public function supplier_all()
    {
        $cateid = input('param.cateid');

        $gid = json_decode(session('user')['gid']);//获取到当前操作用户的分类ID
        if($cateid) {
            // 获取产品分类
            $ps = new PartsCate();
            $partscate = $ps->getpartscate($gid);
            // 获取供应商类型
            $supplier_cate = db('supplier_cate')->select();
            $supplierall = Db::name('supplier')->where(['cate'=>$cateid,'gid'=>$gid])->paginate(10,false,['query' => request()->param(), ]);
            

            $page = $supplierall->render();
            $res = $supplierall->isEmpty();//判断数据集
            $this->assign('res', $res);
            $this->assign('page', $page);
            $this->assign('supplierall', $supplierall);
            $this->assign('partscate', $partscate);
            $this->assign('supplier_cate', $supplier_cate);
        }else{
            // 获取产品分类
            $ps = new PartsCate();
            $partscate = $ps->getpartscate($gid);
            // 获取供应商类型
            $supplier_cate = db('supplier_cate')->select();
            // 实例化模型
            $sm = new Inventory();
            $supplierall = $sm->getsupplierall();
            

            $page = $supplierall->render();
            $res = $supplierall->isEmpty();//判断数据集
            $this->assign('res', $res);
            $this->assign('page', $page);
            $this->assign('supplierall', $supplierall);
            $this->assign('partscate', $partscate);
            $this->assign('supplier_cate', $supplier_cate);
        }
        $this->assign('cateid',$cateid);
        return view();
    }

    /**
     * 新增供应商
     */
    public function supplier_add()
    {   
        $gid = json_decode(session('user')['gid']);//获取到当前操作用户的分类ID
        if (request()->isPost()) {
            
            $param = input('post.');
            $res = Db::name('supplier')->where('number',$param['number'])->find();
            if ($res) {//判断编号是否存在
                $this->error('编号已存在,请重新输入');
            }
            $param['ad_time'] = time();
            $param['gid'] = $gid;
            $article = new Inventory();
            $flag = $article->addsupplier($param);
            if ($flag) {
                $this->redirect('Inventorys/supplier_all');
            } else {
                $this->error('操作失败');
            }
        }
    }

    /**
     * 编辑供应商
     * 
     */
    public function supplier_edit(){
        $id = input('param.id');
        if ($id){
            $se = db('supplier')->where('id',$id)->find();
            if ($se) {
                $this->assign('se',$se);
            } 
        }
        if ($_POST) {
            $param = input('post.');
            
            $article = new Inventory();
            $flag = $article->editsupplier($param);
            if ($flag) {
                $this->redirect('Inventorys/supplier_all');
            } else {
                $this->error('操作失败',url('Inventorys/supplier_all'));
            }
        }

        // 获取产品分类
        $ps = new PartsCate();
        $partscate = $ps->getpartscate($gid);
        // 获取供应商类型
        $supplier_cate = db('supplier_cate')->select();
        $this->assign('partscate', $partscate);
        $this->assign('supplier_cate', $supplier_cate);
        
        return view();
    }

    /**
     * 删除供应商
     */
    public function delsupplier()
    {
        $id = input('param.id');
        
        if (Db::name('supplier')->where('id', $id)->delete()) {
            echo "1";
        } else {
            echo "0";
        }
    }

    /*
     * 批量删除
     */
    public function del()
    {
        $data = input('param.id/a');
        $param = implode(",",$data);

        $am = new Inventory;
        $res = $am->del($param);
            if ($res) {
                echo "1";
            } else {
                echo "0";
            }
        
    }

    /**
     * 搜索供应商
     */
    public function search_supplier()
    {
        $cateid = input('get.cateid');//此处是为了避免模板页面出错,可以忽视此变量
        $gid = json_decode(session('user')['gid']);
        // 接收所搜的关键字
        $keywords = input('param.keyword');
        if ($keywords) {
            // 关键字模糊查询
            $map['number'] = ['like','%' . $keywords . '%']; // 供应商编号
            $map['gid'] = json_decode(session('user')['gid']);//获取到当前操作用户的分类ID
            $supplierall = Db::name('supplier')->where(['number|name'=>['like','%'.$keywords.'%'],'gid'=>json_decode(session('user')['gid'])])->order('id desc')->paginate(10,false,['query' => request()->param(), ]);
            // 获取分类
            $ps = new PartsCate();
            $partscate = $ps->getpartscate($gid);
            // 获取供应商类型
            $supplier_cate = db('supplier_cate')->select();
            $page = $supplierall->render();//分页
            $res = $supplierall->isEmpty();//判断数据集
            $this->assign('res', $res);
            $this->assign('page', $page);
            $this->assign('partscate', $partscate);
            $this->assign('supplierall', $supplierall);
            $this->assign('supplier_cate', $supplier_cate);
        } else {
            $this->error('暂无相关信息');
        }
        $this->assign('cateid',$cateid);
        return $this->fetch('supplier_all');
    }

    /**
     * ===============================
     * ==盘点==
     * ===============================
     */
    
    /**
     * 盘点列表
     */
    public function check_all()
    {   
        $parts_list = input('post.');
        $gid = json_decode(session('user')['gid']);//获取到当前操作用户的分类ID
        if ($parts_list) {
            $parts_list['ad_time'] = time();
            $check_all = Db::name('check')->where('cid',$parts_list['pid'])->update(['pan_count'=>$parts_list['pan_count'],'pan_profit'=>$parts_list['pan_profit'],'pan_content'=>$parts_list['pan_content'],'ad_time'=>$parts_list['ad_time'],'status'=>2]);
            if ($check_all) {
                $this->redirect('Inventorys/check_all');
            }else{
                $this->error('操作失败');
            }
            
        }else{
            $ch = new Check;
            $check_all = $ch->getcheckall();
            $check_count = Db::name('check')->where('gid',$gid)->count();
            $check_counts = Db::name('check')->where(['status'=>2,'gid'=>$gid])->count();
            $time = time();
            $page = $check_all->render();
            $res = $check_all->isEmpty();//判断数据集
            $this->assign('res', $res);
            $this->assign('page', $page);
            $this->assign('check_all',$check_all);
            $this->assign('check_count',$check_count);
            $this->assign('check_counts',$check_counts);
            $this->assign('time',$time);
        }
        
        return view();
    }

    /**
     * 添加盘点产品
     */
    public function add_check()
    {   
        $gid = json_decode(session('user')['gid']);//获取到当前操作用户的分类ID
        $catename = input('get.catename');
        isset($catename) ? $catename : '';
        $partsid = input('param.partsid');

        if ($partsid) {

            $parts_list = Db::name('parts')->where(['id'=>$partsid,'gid'=>$gid])->find();

            //判断所添加产品是否有库存
            if (empty($parts_list['p_count'])) {
                $this->error('此产品暂无库存');
            }
            //判断所添加产品是否已经存在
            $pn_number = Db::name('check')->where(['product_number'=>$parts_list['product_number'],'gid'=>$gid])->find();
            if ($pn_number) {
                $this->error('此产品已存在,请勿重复添加');
            }
            
            $parts_list['status'] = 1;
            $parts_list['gid'] = $gid;
            $parts_list['ad_time'] = '';
            $ch = new Check;
            $check_all = $ch->addcheck($parts_list);
            if ($check_all) {
                $this->redirect('Inventorys/check_all');
            }else{
                $this->error('添加失败');
            }
        }
        
        if (empty($catename)) { // 查看全部产品
            // 获取产品信息
            $ps = new Parts();
            $parts_all = $ps->getpartsall();
            // 获取分类
            $pc = new PartsCate();
            $partscate = $pc->getpartscate($gid);
            $page = $parts_all->render();//分页
            $res = $parts_all->isEmpty();//判断数据集
            $this->assign('res', $res);
            $this->assign('page', $page);
            $this->assign('partscate', $partscate);
            $this->assign('parts_all', $parts_all);
        } else {
            
            // 获取分类
            $pc = new PartsCate();
            $partscate = $pc->getpartscate($gid);
            $parts_all = Db::name('parts')->where(['cateid'=>$catename,'gid'=>$gid])->paginate(10,false,['query' => request()->param(), ]);
            $page = $parts_all->render();//分页
            $res = $parts_all->isEmpty();//判断数据集
            $this->assign('res', $res);
            $this->assign('page', $page);
            $this->assign('parts_all', $parts_all);
            $this->assign('partscate', $partscate);
        }
        $this->assign('catename', $catename);
        return view();
    }


    /**
     * 搜索盘点产品
     */
    public function search_check_parts()
    {   
        $gid = json_decode(session('user')['gid']);//获取到当前操作用户的分类ID
        $catename = input('get.catename');//此处是为了避免模板页面出错,可以忽视此变量
        // 接收所搜的关键字
        $keywords = input('param.keyword');
        if ($keywords) {
            // 关键字模糊查询 
            $parts_all = Db::name('parts')->where(['product_number|name'=>['like','%'.$keywords.'%'],'gid'=>$gid])->order('id desc')->paginate(10,false,['query' => request()->param(), ]);
            // 获取分类
            $ps = new PartsCate();
            $partscate = $ps->getpartscate($gid);
            $page = $parts_all->render();//分页
            $res = $parts_all->isEmpty();//判断数据集
            $this->assign('res', $res);
            $this->assign('page', $page);
            $this->assign('partscate', $partscate);
            $this->assign('parts_all', $parts_all);
        } else {
            $this->error('暂无相关信息');
        }
        $this->assign('catename',$catename);
        return $this->fetch('add_check');
    }


    /*
     * 批量删除盘点产品
     */
    public function del_check()
    {
        $data = input('param.id/a');
        $param = implode(",",$data);

        $am = new Check;
        $res = $am->del($param);
            if ($res) {
                echo "1";
            } else {
                echo "0";
            }
        
    }

    /**
     * ===============================
     * ==出入库记录==
     * ===============================
     */

    
    /**
     * 出入库记录
     */
    public function order_all()
    {       
            
            
            
            if ($_POST){
                if (!empty($_POST['currentpage']) && !empty($_POST['pagesize'])) {
                    $fund = new Purchase;
                    $start = ($_POST['currentpage'] -1) * $_POST['pagesize'];
                    $end = $_POST['pagesize'];
                    $where = [];
    //                $resarr = [];    // 存放返回数组
                    if (!empty($_POST['keyword'])){
                        $where['number'] = ['like','%' . $_POST['keyword'] . '%'];
                    }
                    if (!empty($_POST['time'])){
                        $sjd = explode(',',$_POST['time']);
                        $stime = strtotime($sjd[0]);
                        $etime = strtotime('+1 day',strtotime($sjd[1]));
                        $where['add_time'] = ['between' ,[$stime,$etime]];
                    }
                    if (!empty($_POST['sid'])){
                        $where['sid'] = $_POST['sid'];
                    }
                    $list = $fund->getStatusData($where);

                    if (!empty($list)){
                        foreach ($list as $key => $val){
                            $list[$key] = $val->toArray();
                            $list[$key]['url'] = url('order_list_s',['id'=>$val['id']]);
                        }
                        $total = count($list);
                        $totalpage =  ceil(count($list)/$end);
                        $resarr = array_splice($list,$start,$end);
                        $res = array('code' => 1,'data' => $resarr ,'total' => $total, 'totalpage' => $totalpage);
                    }else{
                        $res = array('code' => 2 ,'msg' => '暂无数据');
                    }
                    return $res;
                }
            }
            
        return view();
    }


    /**
     * 订单详情
     */
    public function order_list_s(){
        $rid = json_decode(session('user')['rid']);//取出身份id
        $pid = json_decode(session('user')['pid']);//父级id
        $gid = json_decode(session('user')['gid']);//获取到当前操作用户的分类ID
        
          
        $id = input('param.id');
        $pu = new Purchase;
        $order_list = $pu->getOneAd($id);//获取订单数据
        $product = json_decode($order_list['product'],true);

        

        $order_list['username'] = db('users')->where('uid',$order_list['user_id'])->value('user_name');//操作人名字
        $order_list['usertel'] = db('users')->where('uid',$order_list['user_id'])->value('mobile');//操作人电话
        
        
        $this->assign('order_list',$order_list);
        $this->assign('order_id',$id);
        $this->assign('rid', $rid);
        $this->assign('pid', $pid);
        $this->assign('product', $product);
        return view();
    }


    /**
     * 搜索出入库记录
     */
    public function search_order()
    {   
        $sid = input('get.cate');//此处是为了避免模板页面出错,可以忽视此变量
        $gid = json_decode(session('user')['gid']);//获取到当前操作用户的分类ID
        // 接收所搜的关键字 
        $keywords = input('param.keyword');
        if ($keywords) {
            // 关键字模糊查询
            $map['number'] = ['like','%' . $keywords . '%']; // 产品编号
            $map['gid'] = $gid;
            $order_list = Db::name('purchase')->where($map)->order('id desc')->paginate(10,false,['query' => request()->param(), ]);
            $page = $order_list->render();
            $res = $order_list->isEmpty();//判断数据集
            // 获取分类
            $ps = new PartsCate();
            $partscate = $ps->getpartscate($gid);
            $this->assign('res', $res);
            $this->assign('page', $page);
            $this->assign('order_list', $order_list);
            $this->assign('partscate', $partscate);
        } else {
            $this->error('暂无相关信息');
        }
        $this->assign('sid',$sid);
        return $this->fetch('order_all');
    }



    /*
     * 批量删除出入库记录
     */
    public function del_order()
    {
        $data = input('param.id/a');
        $param = implode(",",$data);

        $am = new Purchase;
        $res = $am->del($param);
            if ($res) {
                echo "1";
            } else {
                echo "0";
            }
        
    }


    /**
     * ===============================
     * ==安全库存==
     * ===============================
     */
    
    
    /**
     * 安全库存
     */
    public function safety_all()
    {   
        $gid = json_decode(session('user')['gid']);//获取到当前操作用户的分类ID
        $number = input('post.');

        
        if ($number) {
            $number['gid'] = $gid;
            $sares = Db::name('safenumber')->where('gid',$gid)->find();//查询当前用户所属分类是否已设置安全库存
            if ($sares) {//如果有设置，那么就更新数据，否则就新增数据
                Db::name('safenumber')->where('gid',$gid)->update(['minimum'=>$number['minimum'],'maximum'=>$number['maximum']]);
                $this->redirect('Inventorys/safety_all');
            }else{
                $sa = new Safenumber();
                $res = $sa->addsafety($number);
                if ($res) {
                   $this->redirect('Inventorys/safety_all');
                }else{
                    $this->error('设置失败');
                }
            }
            
            
        }else{
            $ch = new Safety;
            $check_all = $ch->getcheckall();
            $sa = new Safenumber;//取出设置的安全库存值
            $res = $sa->getsafenumberall();
            $minimum = $res['minimum'];//安全库存最小值
            $maximum = $res['maximum'];//安全库存最大值
            
            
            $check_count = Db::name('safety')->where(['status'=>1,'gid'=>$gid])->count();
            $check_counts = Db::name('parts')->where(['gid'=>$gid,'anid'=>0])->count();
            $time = time();
            $page = $check_all->render();//分页
            $res = $check_all->isEmpty();//判断数据集
            $this->assign('res', $res);
            $this->assign('page', $page);
            $this->assign('check_all',$check_all);
            $this->assign('check_count',$check_count);
            $this->assign('check_counts',$check_counts);
            $this->assign('time',$time);
            $this->assign('minimum',$minimum);
            $this->assign('maximum',$maximum);
        }
        
        return view();
    }
    
    /**
     * 添加安全库存产品
     */
    public function add_safety()
    {   
        $gid = json_decode(session('user')['gid']);//获取到当前操作用户的分类ID
        $catename = input('get.catename');
        isset($catename) ? $catename : '';
        $partsid = input('param.partsid');
        if ($partsid) {
            //获取产品信息
            $parts_list = Db::name('parts')->where(['id'=>$partsid,'gid'=>$gid])->find();
            //设置产品安全库存之前先检查所选产品是否有库存
            $p_count = $parts_list['p_count'];
            if (empty($p_count)) {
                $this->error('此产品暂无库存,请先进行采购');
            }
            $an_number = Db::name('safety')->where(['product_number'=>$parts_list['product_number'],'gid'=>$gid])->find();
            if ($an_number) {
                $this->error('此产品已存在,请勿重复添加');
            }
            
            $parts_list['status'] = 1;
            $parts_list['gid'] = $gid;
            $ch = new Safety;
            $check_all = $ch->addsafety($parts_list);
            if ($check_all) {
                Db::name('parts')->where('id',$partsid)->update(['anid'=>1]);//设置安全库存之后更新一下状态
                $this->redirect('Inventorys/safety_all');
            }else{
                $this->error('添加失败');
            }
        }
        
        if (empty($catename)) { // 查看全部产品
            // 获取产品信息
            $ps = new Parts();
            $parts_all = $ps->getpartsall();
            // 获取分类
            $pc = new PartsCate();
            $partscate = $pc->getpartscate($gid);
            $page = $parts_all->render();//分页
            $res = $parts_all->isEmpty();//判断数据集
            $this->assign('res', $res);
            $this->assign('page', $page);
            $this->assign('partscate', $partscate);
            $this->assign('parts_all', $parts_all);
        } else {
            
            // 获取分类
            $pc = new PartsCate();
            $partscate = $pc->getpartscate($gid);
            $parts_all = Db::name('parts')->where(['cateid'=>$catename,'gid'=>$gid])->paginate(10,false,['query' => request()->param(), ]);
            $page = $parts_all->render();//分页
            $res = $parts_all->isEmpty();//判断数据集
            $this->assign('res', $res);
            $this->assign('page', $page);
            $this->assign('parts_all', $parts_all);
            $this->assign('partscate', $partscate);
        }
        $this->assign('catename', $catename);
        return view();
    }
    
    
    /**
     * 搜索安全库存产品
     */
    public function search_safety_parts()
    {   
        $catename = input('get.catename');//此处是为了避免模板页面出错,可以忽视此变量
        // 接收所搜的关键字
        $keywords = input('param.keyword');
        if ($keywords) {
            // 关键字模糊查询
            $map['product_number'] = ['like','%' . $keywords . '%']; // 产品编号
            $parts_all = Db::name('parts')->where(['product_number|name'=>['like','%'.$keywords.'%'],'gid'=>json_decode(session('user')['gid'])])->order('id desc')->paginate(10,false,['query' => request()->param(), ]);
            // 获取分类
            $ps = new PartsCate();
            $partscate = $ps->getpartscate($gid);
            $page = $parts_all->render();//分页
            $res = $parts_all->isEmpty();//判断数据集
            $this->assign('res', $res);
            $this->assign('page', $page);
            $this->assign('partscate', $partscate);
            $this->assign('parts_all', $parts_all);
        } else {
            $this->error('暂无相关信息');
        }
        $this->assign('catename',$catename);
        return $this->fetch('add_safety');
    }
    
    /**
     * 删除安全库存产品
     */
    public function delsafety()
    {
        $id = input('param.id');
        
        
        if (Db::name('safety')->where('cid', $id)->delete()) {
            echo "1";
        } else {
            echo "0";
        }
    }


    /*
     * 批量删除安全库存产品
     */
    public function del_safety()
    {
        $data = input('param.id/a');
        $param = implode(",",$data);

        $am = new Safety;
        $res = $am->del($param);
            if ($res) {
                echo "1";
            } else {
                echo "0";
            }
        
    }
    
}

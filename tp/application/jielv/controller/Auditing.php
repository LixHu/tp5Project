<?php
/**
 * 审核列表
 */

namespace app\jielv\controller;
use app\jielv\model\Parts;
use app\jielv\model\PartsCate;
use app\jielv\model\Addpurchase;
use think\Db;
use app\jielv\model\Purchase;

class Auditing extends Index
{
    /**
     * 审核列表
     */
    public function not_aud()
    {      
        
        $rid = json_decode(session('user')['rid']);
        if ($rid == 3) {
            $rid = 4;
        }
        $aud = model('AudList','model');
        $list = $aud->where('gid ='.Session('user')->gid)->select();
        $audlist = [];
        foreach ($list as $key => $val){
            $audlist[] = $val->toArray();
        }
        foreach ($audlist as $key => $val){
            if ($val['type'] == '工单审核'){
                $audlist[$key]['url'] = url('workorder/workorder_details',array('wid' => $val['rela_id']));
            }else if ($val['type'] == '采购申请'){
                $audlist[$key]['url'] = url('auditing/order_list',array('id' => $val['rela_id']));
            }
        }
        
        
        $this->assign('audlist',$audlist);
        $this->assign('rid',$rid);
        
        return view();
    }
    /**
     * 已经审核
     */
    public function aleady_aud()
    {
        return view();
    }



    /**
     * 未审核订单
     */

    public function parts_order(){

        $rid = json_decode(session('user')['rid']);//取出身份id
        $pid = json_decode(session('user')['pid']);//父级id
        $gid = json_decode(session('user')['gid']);//获取到当前操作用户的分类ID


            if ($rid == 3) {
                $rid = 4;//订单状态默认为4,系统管理员和经理一样可以审核订单,此处是为了让系统管理员可以进行审核操作
            }
            $pu = new Purchase;
            $order_list = $pu->getorderall($rid);


            $page = $order_list->render();//分页
            $res = $order_list->isEmpty();//判断数据集
            $this->assign('res', $res);
            $this->assign('page', $page);//分页
            $this->assign('order_list', $order_list);
            $this->assign('rid', $rid);







        return view();
    }
    /**
     * 已审核订单
     */
    public function parts_aleady(){
        $rid = json_decode(session('user')['rid']);//身份id
        $pid = json_decode(session('user')['pid']);//父级id
        $gid = json_decode(session('user')['gid']);//获取到当前操作用户的分类ID


            if ($rid == 3) {
                $rid = 4;//订单状态默认为4,系统管理员和经理一样可以审核订单,此处是为了让系统管理员可以进行审核操作
            }

            $order_list = db('purchase')->where(['gid'=>$gid,'status'=> ['>',$rid]])->paginate(10);//不属于当前用户操作状态的订单



            $page = $order_list->render();//分页
            $res = $order_list->isEmpty();//判断数据集
            $this->assign('res', $res);
            $this->assign('page', $page);//分页
            $this->assign('order_list', $order_list);
            $this->assign('rid', $rid);

        return view();
    }


    /**
     * 订单详情
     */
    public function order_list(){
        $rid = json_decode(session('user')['rid']);//取出身份id
        $pid = json_decode(session('user')['pid']);//父级id
        $gid = json_decode(session('user')['gid']);//获取到当前操作用户的分类ID
        if ($rid == 3) {
                $rid = 4;//订单状态默认为4,系统管理员和经理一样可以审核订单,此处是为了让系统管理员可以进行审核操作
            }

        $id = input('param.id');
        $pu = new Purchase;
        $order_list = $pu->getOneAd($id);//获取订单数据
        $product = json_decode($order_list['product'],true);



        $order_list['username'] = db('users')->where('uid',$order_list['user_id'])->value('user_name');//操作人名字
        $order_list['usertel'] = db('users')->where('uid',$order_list['user_id'])->value('mobile');//操作人电话
        if ($order_list['status'] == 4) {
            $order_status = '待经理确认';
        }elseif ($order_list['status'] == 6) {
            $order_status = '待财务确认';
        }elseif ($order_list['z_audi'] == $gid) {
            $order_status = '待仓库发货';
        }elseif ($order_list['status'] == 7) {
            $order_status = '待仓库确认';
        }elseif ($order_list['status'] == 100) {
            $order_status = '已入库';
        }

        $this->assign('order_list',$order_list);
        $this->assign('order_id',$id);
        $this->assign('rid', $rid);
        $this->assign('pid', $pid);
        $this->assign('order_status', $order_status);
        $this->assign('product', $product);
        return view();
    }

    /**
     * 搜索订单
     */
    public function search_parts_order()
    {
        $rid = json_decode(session('user')['rid']);//取出身份id

        $gid = json_decode(session('user')['gid']);//获取到当前操作用户的分类ID
        // 接收所搜的关键字
        $keywords = input('param.keyword');
        if ($keywords) {
            // 关键字模糊查询
            $map['number'] = ['like','%' . $keywords . '%']; // 订单编号
            $map['gid'] = json_decode(session('user')['gid']);//获取到当前操作用户的分类ID
            // $map['status'] = json_decode(session('user')['rid']);//获取到当前操作用户的分类ID
            $order_list = Db::name('purchase')->where($map)
                ->order('id desc')
                ->paginate(10);
            $page = $order_list->render();//分页
            $res = $order_list->isEmpty();//判断数据集
            $this->assign('res', $res);
            $this->assign('page', $page);//分页
            $this->assign('order_list', $order_list);
            $this->assign('rid', $rid);
        }
        return $this->fetch('parts_order');
    }


    /**
     * 批量删除订单
     */
    public function del_order()
    {
        $data = input('param.id/a');
        $param = implode(",",$data);

        $am = new Purchase;
        $res = $am->del($param);
            if ($res) {
                return 1;
            } else {
                return 0;
            }
    }


    /**
     * 审核订单
     */
    public function audit(){

        $id = input('param.id');
        $bill_number = input('param.bill_number');
        $rid = json_decode(session('user')['rid']);//获取到当前操作用户身份id
        $pid = json_decode(session('user')['pid']);//父级id
        $gid = json_decode(session('user')['gid']);//所属用户组分类

        if ($rid == 3) { //系统管理员审核
            $res = db('purchase')->where('id',$id)->update(['status'=>6]);//到财务
            db('aud_list')->where('rela_id',$id)->update(['status'=>6]);//审核列表状态
            if ($res) {
                return 1;
            }else{
                return 0;
            }
        }elseif($rid == 4){//经理审核
            $res = db('purchase')->where('id',$id)->update(['status'=>6]);//到财务
            db('aud_list')->where('rela_id',$id)->update(['status'=>6]);//审核列表状态
            if ($res) {
                return 1;
            }else{
                return 0;
            }
        }elseif ($rid == 6) {//财务审核
                $pu = new Purchase;
                $param = $pu->getOneAd($id);
                if ($param['sid'] == 1) {//判断当前的订单类型，如果是采购单则提交到主机厂
                    $res = db('purchase')->where('id',$id)->update(['status'=>7,'z_audi'=>$gid,'gid'=>$pid,'bill_number'=>$bill_number]);//提交到主机厂
                    db('aud_list')->where('rela_id',$id)->update(['status'=>7]);//审核列表状态
                    if ($res) {
                        return 1;
                    }else{
                        return 0;
                    }
                }else{//如果是销售单，则提交到仓库
                    $res = db('purchase')->where('id',$id)->update(['status'=>7]);//提交仓库
                    db('aud_list')->where('rela_id',$id)->update(['status'=>7]);//审核列表状态
                    if ($res) {
                        return 1;
                    }else{
                        return 0;
                    }
                }

        }elseif ($rid == 7) {//仓库审核
            $res = db('purchase')->where('id',$id)->update(['status'=>100]);//确认收货，入库
            db('aud_list')->where('rela_id',$id)->update(['status'=>100]);//审核列表状态
            if ($res) {
                $pu = new Purchase;
                $param = $pu->getOneAd($id);
                $product = json_decode($param['product'],true);
                if ($param['sid'] == 1) {//判断订单状态，修改系统数量
                    foreach ($product as $key => $value) {
                        Db::name('parts')->where(['product_number'=>$value['product_number'],'gid'=>$gid])->setInc('p_count',$value['count']);//此处是为了更新产品表的‘产品系统数量’
                        Db::name('safety')->where(['product_number'=>$value['product_number'],'gid'=>$gid])->setInc('p_count',$value['count']);//此处是为了更新安全库存表的‘产品系统数量’
                        Db::name('check')->where(['product_number'=>$value['product_number'],'gid'=>$gid])->setInc('p_count',$value['count']);//此处是为了盘点表的‘产品系统数量’
                    }

                }else{
                    foreach ($product as $key => $value) {
                        Db::name('parts')->where(['product_number'=>$value['product_number'],'gid'=>$gid])->setDec('p_count',$value['count']);//此处是为了更新产品表的‘产品系统数量’
                        Db::name('safety')->where(['product_number'=>$value['product_number'],'gid'=>$gid])->setDec('p_count',$value['count']);//此处是为了更新安全库存表的‘产品系统数量’
                        Db::name('check')->where(['product_number'=>$value['product_number'],'gid'=>$gid])->setDec('p_count',$value['count']);//此处是为了盘点表的‘产品系统数量’
                    }

                }

                return 1;
            }else{
                return 0;
            }
        }
    }
    /**
     * 驳回
     */
    public function reject(){
        $id = input('param.id');
        if ($id) {
            $res = db('purchase')->where('id',$id)->update(['status'=>4]);//无论哪个环节驳回，状态都改为4，初始状态
            if ($res) {
                return 1;
            }else{
                return 0;
            }
        }
    }



    /**
     * 提交发货信息
     */
    public function audit_s(){
        $param = input('post.');
        if (!empty($param)) {
            if ($param['z_audi']) {//如果有值说明是提交到主机厂的订单
                $res = db('purchase')->where('id',$param['orderid'])->update(['deliver'=>$param['deliver'],'deliver_number'=>$param['deliver_number'],'deliver'=>$param['deliver'],'deliver_unit'=>$param['deliver_unit'],'deliver_name'=>$param['deliver_name'],'deliver_name_tel'=>$param['deliver_name_tel'],'deliver_parts'=>$param['deliver_parts'],'deliver_count'=>$param['deliver_count'],'deliver_time'=>$param['deliver_time'],'gid'=>$param['z_audi']]);
                if ($res) {
                    $this->redirect('Auditing/aleady_aud');
                }else{
                    $this->redirect('Auditing/aleady_aud');
                }
            }else{
                $res = db('purchase')->where('id',$param['orderid'])->update(['deliver'=>$param['deliver'],'deliver_number'=>$param['deliver_number'],'deliver'=>$param['deliver'],'deliver_unit'=>$param['deliver_unit'],'deliver_name'=>$param['deliver_name'],'deliver_name_tel'=>$param['deliver_name_tel'],'deliver_parts'=>$param['deliver_parts'],'deliver_count'=>$param['deliver_count'],'deliver_time'=>$param['deliver_time']]);
                if ($res) {
                    $this->redirect('Auditing/aleady_aud');
                }else{
                    $this->redirect('Auditing/aleady_aud');
                }
            }

        }
    }
}

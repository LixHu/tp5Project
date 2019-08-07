<?php
/**
 *  资金管理
 *  is_bill 1 应收 2应付 3 开票记录 4收票记录
 */

namespace app\jielv\controller;
/**
 * 资金管理
 * status
 * 1:应收
 * 2:应付
 * 3:开票
 * 4:收票
 */
class Fund extends Index
{
    /**
     * 应收
     */
    public function funds_receivable(){

        return view();
    }

    /**
     * 应付
     * @return view();
     */
    public function funds_payables(){

        return view();
    }

    /**
     * 开票记录
     */
    public function funds_billing(){

        return view();
    }
    /**
     * 收票记录
     */
    public function funds_receipt()
    {

        return view();
    }

    /**
     * 获取对应数据
     * @return array
     */
    public function getData(){
        if ($_POST){
            if (!empty($_POST['currentpage']) && !empty($_POST['pagesize']) && $_POST['status']) {
                $fund = model('Funds','logic');
                $start = ($_POST['currentpage'] -1) * $_POST['pagesize'];
                $end = $_POST['pagesize'];
                $where = [];
//                $resarr = [];    // 存放返回数组
                if (!empty($_POST['keyword'])){
                    $where['wo_sn'] = $_POST['keyword'];
                }
                if (!empty($_POST['time'])){
                    $sjd = explode(',',$_POST['time']);
                    $stime = strtotime($sjd[0]);
                    $etime = strtotime('+1 day',strtotime($sjd[1]));
                    $where['add_time'] = ['between' ,[$stime,$etime]];
                }
                $list = $fund->getStatusData($_POST['status'],$where);
                if (!empty($list)){
                    foreach ($list as $key => $val){
                        $list[$key] = $val->toArray();
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
    }
    /**
     * 结算资金
     */
    public function SetBlance()
    {
        $res = array('code' => 2,'msg' => '失败');
        if ($_POST){
            if(!empty($_POST['fund_id'])){    // 接收到资金ID请求
                $fund = model('Funds','logic');
                $info = $fund->get($_POST['fund_id']);
                $data['status'] = 1;
                $data['fund_status'] = 3;
                $data['must_bill_price'] = 0;                         // 把应开票金额设为0
                $data['alea_bill_price'] = $info['must_bill_price'];  //设已收价格为未开票金额
                $data['not_bill_price'] = 0;                          // 把未开票金额设为0
                $where['fund_id'] = $_POST['fund_id'];
                if($fund->setStatus($data,$where)){    // 修改资金表中数据
                    $res = array('code' => 1,'msg' => '成功');
                }
            }
        }
        return $res;
    }
}
<?php
namespace app\index\controller;

class Company extends Index
{
    /*
    *  公司信息
    */
    public function com_info()
    {
        $info = db('company')->field('com_name,logo,com_phone,com_email,sale_phone,server_phone,free_server_phone,control_phone,free,qrcode')->find();
        return jsonReturn($info);
    }
    /*
    * 案例
    */
    public function case_list(){
        return jsonReturn($trade_list);
    }
    /*
    *  分类下案例
    */
    public function get_trade_case()
    {
        // $arr = $this->arr;
        if ($_POST) {
            if (!empty($_POST['trade_id'])) {
                $trade_id = $_POST['trade_id'];
                $case_list = db('case')->where('trade_id = '.$trade_id)->field('com_name,com_desc,case_desc,case_img')->where('is_show = 1')->select();
                $str = '';
                foreach ($case_list as $key => $val) {
                    if(!empty($val['case_img'])) {
                        $img = $val['case_img'];
                    }
                    $str .= '<div class="pullLeft">
                        <div class="textLeft thanksCon">
                            <img src="'.$img.'" alt="">
                            <div class="thanksConCon">
                                <h3 class="ellipsis">'.$val['com_name'].'</h3>
                                <p class="ellipsis font14 gray">'.$val['com_desc'].'</p>
                            </div>
                        </div>
                    </div>';
                }
                $res = array('code' => 1, 'data' => $str);

            }else {
                $res = array('code' => 1, 'msg' => '缺少分类id');
            }
            return $res;
        }
    }
    /*
    *  签单动态
    */
    public function get_sign()
    {
        $sign_list = db('sign')->query("SELECT * FROM yd_sign  ORDER BY  RAND() LIMIT 50");
        // $sign_list = array_slice($sign_list,50,rand(0,50),false);
        return $sign_list;
    }
    /*
    *  签单观点
    */
    public function get_expert()
    {
        $expert_list = db('expert')->select();
        // $sign_list = array_slice($sign_list,50,rand(0,50),false);
        return $expert_list;
    }
    /*
    *   企业之家
    */
    public function under_com()
    {
        $com_list = db('under_com')->field('under_com_id,com_name,com_desc,com_img')->where('is_show = 1')->select();
        return $com_list;
    }



}

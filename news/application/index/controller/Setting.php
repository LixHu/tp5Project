<?php
namespace app\index\controller;

class Setting extends Index
{

    /*
    *   客服页显示
    */
    public function problem()
    {
        $pro_list = db('problem')->field('pro_id,pro_name')->select();

        $tel = db('websetting')->find();

        $res['problem'] = $pro_list;

        $res['tel'] = $tel['tel'];

        return jsonReturn($res);
    }

    /*
    *  问题详情页
    */
    public function pro_info()
    {
        $arr = $this->arr;
        if(!empty($arr)){
            $flag = true;
            if(empty($arr['pro_id'])){
                $flag = false;
            }
            if($flag){
                $pro_id = $arr['pro_id'];
                $pro_info = db('problem')->field('pro_name,pro_content')->where('pro_id ='.$pro_id)->find();
                if(!empty($pro_info)){
                    $res = array('code' => 1, 'data' => $pro_info);
                }else {
                    $res = array('code' => 2, 'msg' => '暂无数据');
                }
            }else{
                $res = array('code' => 2,'msg' => '缺少参数');
            }
            return jsonReturn($res);
        }
    }
}

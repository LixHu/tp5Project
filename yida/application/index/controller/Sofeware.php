<?php

namespace app\index\controller;

class Sofeware extends Index
{
    /*
    * 软件列表
    */
    public function soft_list()
    {
        $soft_list = db('software')->field('soft_id,soft_name')->where('is_show = 1')->select();
        return jsonReturn($soft_list);
    }
    /*
    *  软件详情
    */
    public function soft_info()
    {
        // $arr = $this->arr;
        if($_POST){
            if(!empty($_POST['soft_id'])) {
                $soft_id = $_POST['soft_id'];
                $info = db('software')->field('soft_name,soft_desc,soft_img,soft_img_to,soft_apply,fun_img,soft_cost,fun_list,video_url')->where('soft_id = '.$soft_id)->find();
                $info['case'] = db('case')->field('case_id,com_name,com_desc,case_desc,case_img')->where('soft_id ='.$soft_id)->limit(0,3)->select();
                if (!empty($info)) {
                    $info['soft_desc'] = htmlspecialchars_decode($info['soft_desc']);
                    if (!empty($info['video_url'])) {
                        $info['video_url'] = substr($info['video_url'],strpos($info['video_url'],'embed/')+6,15);
                    }
                    $info['fun_list'] = explode('，',$info['fun_list']);
                    $res = array('code' => 1, 'data' => $info);
                }else {
                    $res = array('code' => 2, 'msg' => '暂无信息' );
                }
            }else{
                $res = array('code' => 2, 'msg' => '缺少参数');
            }
            return $res;
        }
    }
}

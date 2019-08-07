<?php
namespace app\index\controller;

class Page extends Index
{

    /*
    *  页面配置信息
    */
    public function page_list()
    {
        $page_list = db('page')->field('page_id,page_name')->where('is_show = 1')->select();
        return jsonReturn($page_list);
    }
    /*
    *  页面内容
    */
    public function get_page()
    {
        $arr = $this->arr;
        if(!empty($arr)){
            if(!empty($arr['page_id'])) {
                $page_id = $arr['page_id'];
                $page_info = db('page_info')->field('info_content')->where('page_id ='.$page_id)->find();
                if (!empty($page_info)) {
                    $res = array('code' => 1, 'data' => $page_info);
                }else {
                    $res = array('code' => 2, 'msg' => '暂无数据');
                }
            }else {
                $res = array('code' => 2, 'msg' => '缺少id');
            }
            return jsonReturn($res);
        }
    }
}

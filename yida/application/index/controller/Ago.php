<?php
namespace app\index\controller;
/**
 *
 */
class Ago extends Index
{
    public function index()
    {
        $title = '易大软件';
        $info['company'] = db('company')->find();
        $info['banner'] = db('banner')->field('bn_id,bn_name,bn_url')->where('is_show = 1 and bn_pos = 1')->select();                           #广告列表
        $info['soft_list'] = db('software')->field('soft_id,soft_name,soft_desc,soft_img')->where('is_show = 1 and is_groom = 1')->select();    #软件精品
        foreach ($info['soft_list'] as $key => $value) {
            $info['soft_list'][$key]['soft_desc'] = htmlspecialchars_decode($value['soft_desc']);
        }
        $info['custom_list1'] = db('custom')->field('custom_id,cus_com_name,cus_com_desc,cus_com_content,cus_com_img')->where('is_show = 1')->limit(0,3)->select();                #合作客户
        $info['custom_list2'] = db('custom')->field('custom_id,cus_com_name,cus_com_desc,cus_com_content,cus_com_img')->where('is_show = 1')->limit(3,3)->select();                #合作客户
        $this->assign('info',$info);
        $this->assign('title',$title);
        return view();
    }
    /*
    *  软件列表&详情
    */
    public function software()
    {
        $title = '体验精品';
        $id = '';
        $soft_list = db('software')
                    ->field('soft_id,soft_name')
                    ->where('is_show = 1')
                    ->select();
        $banner = db('banner')
                ->alias('a')
                ->join('banner_pos b','a.bn_pos = b.pos_id')
                ->where('b.pos_name = \''.$title.'\'')
                ->select();
        $id = $soft_list[0]['soft_id'];
        $this->assign('soft_list',$soft_list);
        $this->assign('id',$id);
        $this->assign('title',$title);
        $this->assign('banner',$banner);
        return view();
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
    public function software2()
    {
        $id = '';
        if(!empty($_GET['id'])) {
            $id = $_GET['id'];
        }
        $soft_list = db('software')->field('soft_id,soft_name')->where('is_show = 1')->select();
        $this->assign('soft_list',$soft_list);
        $title = '体验精品';
        $banner = db('banner')
                ->alias('a')
                ->join('banner_pos b','a.bn_pos = b.pos_id')
                ->where('b.pos_name = \''.$title.'\'')
                ->select();
        $this->assign('banner',$banner);
        $this->assign('title',$title);
        $this->assign('id',$id);
        return view();
    }
    public function industry()
    {
        $title = '深耕行业';
        $banner = db('banner')
                ->alias('a')
                ->join('banner_pos b','a.bn_pos = b.pos_id')
                ->where('b.pos_name = \''.$title.'\'')
                ->select();
        $this->assign('banner',$banner);
        $this->assign('title',$title);
        return view();
    }
    public function in_info(){
        if (!empty($_POST['id'])) {
            $id = $_POST['id'];
            $wenben = db('sheng')->where('pid ='.$id)->find();
            $wenben['s_content'] = htmlspecialchars_decode($wenben['s_content']);
            return $wenben;
        }
    }
    public function thanks()
    {
        $field = 'case_id,com_name,com_desc,case_desc,case_img';
        $trade_list['classic1'] = db('case')->field($field)->where('is_show =1 and is_groom = 1')->limit(0,3)->select();   // 推荐
        $trade_list['classic2'] = db('case')->field($field)->where('is_show =1 and is_groom = 1')->limit(3,3)->select();   // 推荐
        $trade_list['notclas'] = db('trade')->field('trade_id,trade_name,pid')->where('pid = 0 ')->order('sort asc')->select();

        foreach ($trade_list['notclas'] as $key => $value) {
            $trade_list['notclas'][$key]['child'] = db('trade')->field('trade_id,trade_name,pid')->where('pid = '.$value['trade_id'])->limit(0,7)->select();
            $trade_list['notclas'][$key]['child2'] = db('trade')->field('trade_id,trade_name,pid')->where('pid = '.$value['trade_id'])->limit(7,7)->select();
        }
        foreach ($trade_list['notclas'] as $key => $val) {
            $trade_list['notclas'][$key]['case'] = db('case')->field($field)->where('is_show =1 and trade_id ='.$val['trade_id'])->select();
            if(!empty($val['child'])){
                foreach ($val['child'] as $k => $value) {
                    $trade_list['notclas'][$key]['child'][$k]['case'] = db('case')->field($field)->where('is_show = 1 and trade_id ='.$val['trade_id'])->select();
                    unset($trade_list['notclas'][$key]['child'][$k]['pid']);
                }
            }
            unset($trade_list['notclas'][$key]['pid']);
        }
        $title = '感谢客户';
        $banner = db('banner')
                ->alias('a')
                ->join('banner_pos b','a.bn_pos = b.pos_id')
                ->where('b.pos_name = \''.$title.'\'')
                ->select();
        $this->assign('banner',$banner);
        $this->assign('title',$title);
        $this->assign('trade_list',$trade_list);
        return view();
    }

    public function service()
    {
        $title = '真诚服务';
        $banner = db('banner')
                ->alias('a')
                ->join('banner_pos b','a.bn_pos = b.pos_id')
                ->where('b.pos_name = \''.$title.'\'')
                ->select();
        $this->assign('banner',$banner);
        $this->assign('title',$title);
        return view();
    }
    public function enterprise()
    {
        $title = '良心企业';
        $banner = db('banner')
                ->alias('a')
                ->join('banner_pos b','a.bn_pos = b.pos_id')
                ->where('b.pos_name = \''.$title.'\'')
                ->select();
        $this->assign('banner',$banner);
        $this->assign('title',$title);
        $com_info = db('company')->field('summary,com_img')->find();
        $com_info['summary'] = htmlspecialchars_decode($com_info['summary']);
        $com_info['img_list'] = db('real')->select();
        $this->assign('com_info',$com_info);
        return view();
    }
    public function signsingle()
    {
        $title = '签单动态';
        $banner = db('banner')
                ->alias('a')
                ->join('banner_pos b','a.bn_pos = b.pos_id')
                ->where('b.pos_name = \''.$title.'\'')
                ->select();
        $this->assign('banner',$banner);
        $this->assign('title',$title);
        return view();
    }
    public function signsingle_detail()
    {
        $title = '企业详情';
        $banner = db('banner')
                ->alias('a')
                ->join('banner_pos b','a.bn_pos = b.pos_id')
                ->where('b.pos_name = "签单动态"')
                ->select();
        $this->assign('banner',$banner);
        $this->assign('title',$title);
        if (!empty($_GET['id'])) {
            $com_id = $_GET['id'];
            $info = db('under_com')->field('com_name,com_content,add_time')->where('under_com_id = '.$com_id)->find();
            $info['com_content'] = htmlspecialchars_decode($info['com_content']);
            if(!empty($info['add_time'])) {
                $info['add_time'] = date("Y-m-d H:i:s",$info['add_time']);
            }
            if(!empty($info)) {
                $this->assign('under_info',$info);
            }
            return view();
        }else {
            $this->error('参数有误');
        }
    }
    public function expert_detail()
    {
        $title = '专家观点详情';
        $this->assign('title',$title);
        if (!empty($_GET['id'])) {
            $com_id = $_GET['id'];
            $info = db('expert')->field('expert_name,expert_content,add_time')->where('expert_id = '.$com_id)->find();
            $info['expert_content'] = htmlspecialchars_decode($info['expert_content']);
            if(!empty($info['add_time'])) {
                $info['add_time'] = date("Y-m-d H:i:s",$info['add_time']);
            }
            if(!empty($info)) {
                $this->assign('under_info',$info);
            }
            return view();
        }else {
            $this->error('参数有误');
        }
    }

    public function cases()
    {
        $title = '案例详情';
        $type = '';
        $this->assign('title',$title);
        if(!empty($_GET['id'])) {
            $id = $_GET['id'];
            if(!empty($_GET['type']))  {
                $type = $_GET['type'];
            }
            if($type) {
                $case_info = db('custom')->field('cus_com_te as case_content,cus_com_img as case_img,cus_com_content as case_desc,cus_com_name as com_name,cus_com_desc as com_desc')->where('custom_id ='.$id)->find();
            }else {
                $case_info = db('case')->where('case_id ='.$id)->find();
            }
            $this->assign('case_info',$case_info);
        }
        return view();
    }
}

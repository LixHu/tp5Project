<?php
namespace app\index\controller;
class Ad extends Index
{
    function __construct()
    {
        parent::__construct();
        $this->zero();
        $this->_up();
    }
    /*
    * 广告主到期 广告主店铺下的所有广告不显示 把广告主状态改掉
    */
    private function _up()
    {
        $ader_list = db('user_data')->select();
        foreach($ader_list as $key => $val){
            if($val['expire_time'] < time()){
                db('user_data')->where('data_id ='.$val['data_id'])->update(['aud_status' => 3]);
                db('ad')->where('user_id ='.$val['user_id'])->update(['is_show' => 2]);
            }
        }
    }
    /*
    *  每年清空广告主发布数量
    */
    private function zero()
    {
        $time = date("m-d");
        if($time == '1-1'){
            db('user_data')->where('1=1')->update(['fnum' => 0]);
        }
        $curr = time();
        $ad_list = db('ad')->where('is_groom = 1')->select();
        foreach ($ad_list as $key => $val) {
            if(!empty($val['end_time'])){
                if($curr > $val['end_time']){
                    db('ad')->where('ad_id ='.$val['ad_id'].' and is_groom = 1')->update(['groom_status' => 4]);
                }
            }
        }
    }
    /*
    *  获取推荐时间
    */
    public function get_groom()
    {
        $g_list = db('groom')->field('t_id,t_name,t_time,t_type')->where('is_show = 1')->select();
        foreach ($g_list as $key => $val) {
            $type = GetGroomType($val['t_type'])['desc'];
            $g_list[$key]['t_time'] = $val['t_time'].$type;
            unset($g_list[$key]['t_type']);
        }
        $res = array('code' => 1, 'data' => $g_list);

        return jsonReturn($res);
    }
    /*
    *  推荐列表
    */
    public function groom_list()
    {
        $arr = $this->arr;
        $where = 'is_show = 1 and is_groom = 1 and groom_status = 1 and end_time >'.time();
        $field = 'ad_id,title,ad_img,see_count,price,stock,a.add_time,b.lat,b.lng';
        if(!empty($arr)){
            $flag = true;
            if(empty($arr['user_id'])){
                $flag = false;
            }
            if($flag){
                $user_id = $arr['user_id'];
                $col_list = db('ad_column')
                            ->alias('a')
                            ->field('a.col_id,a.col_name')
                            ->join('user_take b','a.col_id = b.col_id')
                            ->where('user_id ='.$user_id)
                            ->select();
                foreach ($col_list as $key => $val) {
                    $col_list[$key]['child'] = db('ad')->alias('a')->join('user_data b','a.user_id = b.user_id')->field($field)->where($where.' and col_id ='.$val['col_id'])->select();
                    if(empty($col_list[$key]['child'] )){
                        unset($col_list[$key]);
                    }
                    if(!empty($col_list[$key])){
                        foreach ($col_list[$key]['child'] as $k => $v) {
                            $col_list[$key]['child'][$k]['ad_img'] = explode(',',$v['ad_img']);
                            $col_list[$key]['child'][$k]['add_time'] = date("Y-m-d H:i:s",$v['add_time']);
                            if(!empty($arr['lat']) && !empty($arr['lng'])){
                                $col_list[$key]['child'][$k]['km_num'] = sprintf('%.2f',calcDistance($arr['lat'],$arr['lng'],$v['lat'],$v['lng']));
                                unset($col_list[$key]['child'][$k]['lat']);
                                unset($col_list[$key]['child'][$k]['lng']);
                            }
                        }
                    }
                }
                if(!empty($col_list)){
                    $res = array('code' => 1, 'data' => $col_list);
                }else {
                    $res = array('code' => 2,'msg' => '暂无数据' );
                }
            }else{
                // 默认返回前五个 分类下的推荐广告，拿到分类id 根据id搜索分类下推荐商品
                $col_list = db('ad_column')->field('col_id,col_name')->limit(0,5)->select();
                foreach ($col_list as $key => $val) {
                    $col_list[$key]['child'] = db('ad')->alias('a')->join('user_data b','a.user_id = b.user_id')->field($field)->where($where.' and col_id ='.$val['col_id'])->select();
                    if(empty($col_list[$key]['child'] )){
                        unset($col_list[$key]);
                    }
                    if(!empty($col_list[$key])){
                        foreach ($col_list[$key]['child'] as $k => $v) {
                            $col_list[$key]['child'][$k]['ad_img'] = explode(',',$v['ad_img']);
                            $col_list[$key]['child'][$k]['add_time'] = date("Y-m-d H:i:s",$v['add_time']);
                            if(!empty($arr['lat']) && !empty($arr['lng'])){
                                $col_list[$key]['child'][$k]['km_num'] = sprintf('%.2f',calcDistance($arr['lat'],$arr['lng'],$v['lat'],$v['lng']));
                                unset($col_list[$key]['child'][$k]['lat']);
                                unset($col_list[$key]['child'][$k]['lng']);
                            }
                        }
                    }
                }
                $ad_list = db('ad')->where($where)->select();
                $res = array('code' => 1, 'data' => $col_list);
            }
            return jsonReturn($res);
        }
    }
    /*
    *   广告分类
    */
    public function ad_column()
    {
        $arr = $this->arr;
        if(!empty($arr)){
            $flag = true;
            if(empty($arr['user_id'])){
                $flag = false;
            }
            if($flag){
                $user_id = $arr['user_id'];
                $column_list = db('ad_column')
                            ->alias('a')
                            ->field('a.col_id,a.col_name')
                            ->join('user_take b','a.col_id = b.col_id')
                            ->where('b.user_id = '.$user_id)
                            ->order('a.col_id asc')
                            ->select();
                $str = '';
                foreach ($column_list as $key => $val) {
                    $str .= $val['col_id'].',';
                }
                $str = substr($str,0,-1);
                $notin = db('ad_column')->field('col_id,col_name')->where('col_id not in ('.$str.')')->select();
                $res = array('code' =>1 ,'data' =>  $column_list ,'nottack' => $notin);
            }else {
                $res = array('code' => 2, 'msg' => '缺少参数');
            }

        }else{
            $column_list = db('ad_column')->field('col_id,col_name')->where('is_show = 1')->limit("0,5")->select();

            $res = array('code' => 1,'data' => $column_list);
        }
        return jsonReturn($res);
    }
    /*
    *  发布广告
    */
    public function send_ad()
    {
        $arr = $this->arr;
        if(!empty($arr)){
            $flag = true;
            if(empty($arr['title']) && empty($arr['content']) && empty($arr['user_id'])){
                $flag = false;
            }
            if($flag){
                $a = true;
                $data['user_id'] = $arr['user_id'];                             #用户id
                $col_id = db('user_data')->field('user_id,aud_status,column_id')->where('user_id ='.$data['user_id'])->find();
                $data['col_id'] = $col_id['column_id'];                         #分类id
                $data['title'] = $arr['title'];                                 #标题
                $data['content'] = $arr['content'];                             #内容
                $data['add_time'] = time();
                if(!empty($arr['ad_img'])){
                    $ad_img = $arr['ad_img'];                           #广告图片base64 多张图片数组[]
                    if(count($ad_img) > 9){
                        $a = false;
                    }else{
                        $upload_url = ROOT_PATH .'public/static'.DS.'uploads/ad/';
                        $str = '';
                        foreach ($ad_img as $key => $val) {
                            $ret = base_upload($upload_url,$val);
                            if($ret['code'] == 1){
                                $str .= $ret['url'].',';
                            }
                        }
                        $data['ad_img'] = substr($str,0,-1);
                    }
                }
                if(!empty($arr['price'])){
                    $data['price'] = $arr['price'];                             #价格
                }
                if(!empty($arr['stock'])){
                    $data['stock']  = $arr['stock'];                            #库存
                }
                $data['is_groom'] = 0;                                          #是否申请推荐 默认不推荐
                if(!empty($arr['t_id'])){
                    $data['is_groom'] = 1;
                    $data['groom_status'] = 3;
                    $data['t_id'] = $arr['t_id'];                               #推荐天数
                }else{
                    $data['groom_status'] = 5;
                }
                // 判断上传图片多于九张不能上传
                if($a){
                    $ret = '';
                    // if($col_id['aud_status'] == 1){
                        $year = date('Y',time());
                        $stime = strtotime($year.'-01-01');
                        $etime = strtotime($year.'-12-31');
                        $num = db('users')
                                ->alias('a')
                                ->field('position')
                                ->join('iden b','a.iden = b.iden_id')
                                ->where('user_id = '.$col_id['user_id'])
                                ->find();
                        // $fnum = db('user_data')->where('user_id ='.$col_id['user_id'])->find();
                        $fnum = db('ad')->where('user_id ='.$col_id['user_id'])->count();
                        // if($fnum['fnum'] < $num['position']){
                        $data['is_show'] = 1;
                        if($fnum < $num['position']){
                            $ret = db('ad')->insert($data);
                            // db('user_data')->where('user_id = '.$col_id['user_id'])->setInc('fnum');
                        }else{
                            $msg = '发布条数已经用完';
                        }
                    // }else{
                        // $msg = '请等待审核通过';
                    // }
                }else{
                    $msg = '上传图片不能多于9张';
                }
                if($ret){
                    $res = array('code' => 1 ,'msg' => '发布成功');
                }else{
                    $res = array('code' => 2,'msg' => $msg);
                }
            }else{
                $res = array('code' => 2,'msg' => '缺少参数');
            }
            return jsonReturn($res);
        }
    }
    /*
    *   订阅
    */
    public function take()
    {
        $arr = $this->arr;
        if(!empty($arr)){
            $flag = true;
            if(empty($arr['user_id']) && empty($arr['col_id'])){
                $flag = false;
            }
            if($flag){
                $user_id = $arr['user_id'];
                $col_id = $arr['col_id'];
                $ha1 = db('users')->where('user_id ='.$user_id)->find();
                $ha2 = db('ad_column')->where('col_id ='.$col_id)->find();
                if(!empty($ha1) && !empty($ha2)){
                    $where['user_id'] = $user_id;
                    $where['col_id'] = $col_id;
                    $have = db('user_take')->where($where)->find();
                    if(!empty($have)){
                        $msg = '取消成功';
                        $ret = db('user_take')->where($where)->delete();
                    }else {
                        $msg = '订阅成功';
                        $ret = db('user_take')->insert(['user_id' => $user_id , 'col_id' => $col_id ]);
                    }
                    if($ret){
                        $res = array('code' => 1,'msg' => $msg);
                    }else{
                        $res = array('code' => 2, 'msg' => '失败');
                    }
                }
            }else{
                $res = array('code' => 1, 'msg' => '参数有误');
            }
            return jsonReturn($res);
        }
    }
    /*
    *  获取广告分类列表
    */
    public function ad_list(){
        $arr = $this->arr;
        if(!empty($arr)){
            $flag = true;
            if(empty($arr['col_id'])){
                $flag = false;
            }
            if($flag){
                $page = 1;
                $page_size = 10;
                if(!empty($arr['page'])){
                    $page = $arr['page'];
                }
                $col_id = $arr['col_id'];
                $ad_list = db('ad')
                        ->alias('a')
                        ->field('a.ad_id,a.title,a.ad_img,a.see_count,a.price,a.stock,a.add_time,b.lat,b.lng')
                        ->join('user_data b','a.user_id = b.user_id')
                        ->where('col_id = '.$col_id .' and is_show = 1')
                        ->order('add_time desc')
                        ->limit($page_size*($page-1).','.$page_size)
                        ->select();
                foreach ($ad_list as $key => $val) {
                    $ad_img[] = explode(',',$val['ad_img']);
                    foreach($ad_img as $k => $v){
                        foreach($v as $ke => $va){
                            $v[$ke] = trim($va);
                        }
                        $ad_list[$key]['ad_img'] = $v;
                    }
                    $ad_list[$key]['km_num'] = sprintf('%.2f',calcDistance($val['lat'],$val['lng'],$arr['lat'],$arr['lng']));
                    $ad_list[$key]['add_time'] = date('Y-m-d H:i:s',$val['add_time']);
                    unset($ad_list[$key]['lat']);
                    unset($ad_list[$key]['lng']);
                }
                if(!empty($ad_list)){
                    // $sortFile = array();
                    $res = array('code' => 1,'data' =>  $ad_list);
                }else{
                    $res = array('code' => 2, 'msg' => '暂无数据');
                }
            }else{
                $res = array('code' => 2,'msg' => '参数有误');
            }
            return jsonReturn($res);
        }
    }
    /*
    *  广告详情
    */
    public function ad_info()
    {
        $arr = $this->arr;
        if(!empty($arr)){
            $flag = true;
            if(empty($arr['ad_id']) && empty($arr['lng']) && empty($arr['lat'])){
                $flag = false;
            }
            if($flag){
                $ad_id = $arr['ad_id'];
                $lng = $arr['lng'];
                $lat = $arr['lat'];
                $ad_info = db('ad')
                        ->alias('a')
                        ->field('a.ad_id,a.title,a.content,a.ad_img,a.see_count,a.price,a.user_id,a.stock,a.add_time,b.data_id,b.lat,b.lng,b.name,b.tel,b.mobile,b.province,b.city,b.area,b.add,c.head_img')
                        ->join('user_data b','a.user_id = b.user_id')
                        ->join('users c','b.user_id = c.user_id')
                        ->where('ad_id ='.$ad_id)
                        ->find();
                // 如果有信息就修改数据返回
                if(!empty($ad_info)){
                    $ad_info['km_num'] = sprintf('%.2f',calcDistance($ad_info['lat'],$ad_info['lng'],$arr['lat'],$arr['lng']));
                    $ad_info['add_time'] = date('Y-m-d H:i:s',$ad_info['add_time']);
                    $ad_info['ad_img'] = explode(',',$ad_info['ad_img']);
                    unset($ad_info['lat']);
                    unset($ad_info['lng']);
                    db('ad')->where('ad_id ='.$ad_id)->setInc('see_count',1);
                    $collect = 0;
                    if(!empty($arr['user_id'])){
                        $collect = db('collect')->where('ad_id = '.$ad_info['ad_id'] .' and user_id ='.$arr['user_id'])->count();
                    }
                    $res = array('code' => 1,'data' => $ad_info ,'like' => $collect);
                }else{
                    $res = array('code' => 2,'msg' => '暂无信息');
                }
            }else{
                $res = array('code' => 2,'msg' => '参数有误');
            }
            return jsonReturn($res);
        }
    }
    /*
    * 关键字搜素
    */
    public function search_ad()
    {
        $arr = $this->arr;
        if(!empty($arr)){
            $flag = true;
            if(empty($arr['keyword'])){
                $flag = false;
            }
            if($flag){
                if(!empty($arr['sort'])){

                }
                $page = 1;
                if(!empty($arr['page'])){
                    $page = $arr['page'];
                }
                $page_size = 10;
                $keyword = $arr['keyword'];
                $ad_list = db('ad')
                        ->alias('a')
                        ->field('a.ad_id,a.title,a.ad_img,a.see_count,a.price,a.stock,a.add_time,b.lat,b.lng')
                        ->join('user_data b','a.user_id = b.user_id')
                        ->where('title REGEXP \''.$keyword.'\' and is_show = 1')
                        ->limit($page_size *($page-1).','.$page_size)
                        ->order('add_time desc')
                        ->select();
                if(!empty($ad_list)){
                    foreach($ad_list as $key => $val){
                        $ad_list[$key]['km_num'] = sprintf('%.2f',calcDistance($val['lat'],$val['lng'],$arr['lat'],$arr['lng']));
                        $ad_list[$key]['ad_img'] = explode(',',$val['ad_img']);
                        $ad_list[$key]['add_time'] = date('Y-m-d H:i:s',$val['add_time']);
                        unset($ad_list[$key]['lat']);
                        unset($ad_list[$key]['lng']);
                    }
                    // $sortFile = array();
                    // foreach ($ad_list as $key => $val) {
                    //     $sortFile[] = $val['km_num'];
                    // }
                    // array_multisort($sortFile,SORT_ASC,SORT_REGULAR ,$ad_list);
                    $res = array('code' => 1, 'data' => $ad_list);
                }else{
                    $res = array('code' => 2, 'msg' => '暂无');
                }
            }else{
                $res = array('code' => 2,'msg' => '请输入关键字');
            }
            return jsonReturn($res);
        }
    }
    /*
    * 广告主删除广告
    */
    public function del_ad()
    {
        $arr = $this->arr;
        if(!empty($arr)){
            $flag = true;
            if(empty($arr['user_id']) && empty($arr['ad_id'])){
                $flag = false;
                $res = array('code' => 2, 'msg' => '缺少参数');
            }
            if($flag){
                $user_id = $arr['user_id'];
                $ad_id = $arr['ad_id'];
                $ad_user = db('ad')->where('user_id = '.$user_id.' and ad_id = '.$ad_id)->find();
                if(!empty($ad_user)) {
                    $ret = db('ad')->where('ad_id = '.$ad_user['ad_id'])->delete();
                }else{
                    $msg = '广告不存在';
                    $ret = '';
                }
                if($ret){
                    $res = array('code' => 1, 'msg' => '删除成功');
                }else{
                    $res = array('code' => 2, 'msg' => !empty($msg)?$msg:'失败');
                }
            }
            return jsonReturn($res);
        }
    }
}

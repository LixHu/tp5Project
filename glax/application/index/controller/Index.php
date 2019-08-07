<?php
namespace app\index\controller;
use think\Controller;
use think\Session;
use think\Loader;
use think\Cache;
use think\ValidateCode;
use app\index\model\Company;
use app\index\model\Banner;
use app\index\model\Category;
use app\index\model\Product;
use app\index\model\Shop;
use app\index\model\Event;
use app\index\model\Contact;
use app\index\model\Email;
use app\index\model\Real;
/**
 * 主页
 */
class Index extends Controller
{

    function __construct()
    {
        parent::__construct();
        $company = Company::get(1);
        $info = Category::field('cname,cid')->find();
        $this->assign('btn1',$info);
        $this->assign('info',$company);
    }
    public function test() {
        return true;
    }
    /*
    *  event
    */
    public function event()
    {
        $list = Event::where('is_show = 1')->select();
        $this->assign('list',$list);
        return view();
    }
    /**
     *  index
     */
    public function index()
    {
        $banner = new Banner;
        $shop = new Shop;
        $category = new Category;
        $list = $banner->select();
        $p_list = db('index')->where('is_show = 1')->select();
        $a = 0;
        $p['val'] = [];
        foreach ($p_list as $key => $val) {
            if ($key%4 == 0) {
                $a++;
            }
            $p['val'][$a][] =$val;
        }
        $c_list = $category->where('is_groom = 1')->select();
        $s_list = $shop->where('is_groom = 1')->select();
        $this->assign('clist',$c_list);                                     #推荐分类
        $this->assign('slist',$s_list);                                     #推荐店铺
        $this->assign('p_list',$p);                                         #推荐产品
        $this->assign('bn_list',$list);                                     #banner
        return view();
    }

    /**
     * about_us
     */
    public function about_us()
    {
        $real = new Real;
        $list = $real->select();
        foreach ($list as $key => $val) {
            $list[$key] = $val->toArray();
        }
        $a = 0;
        $p['val'] = [];
        foreach ($list as $key => $val) {
            if ($key%3 == 0) {
                $a++;
            }
            $p['val'][$a][] =$val;
        }
        $this->assign('a_list',$p);
        return view();
    }
    /*
    * products
    */
    public function products()
    {
        $first = Category::find();
        $btn2 = '';
        $btn4 = '';
        $where = '1 = 1 ';
        if (empty($_GET['cid']) && empty($_GET['page'])) {
            Session('cid',null);
        }
        if (!empty($_GET['cid']) || !empty(Session('cid'))) {
            $cid = !empty($_GET['cid']) ? $_GET['cid'] : Session('cid');
//            Session('cid',$cid);
//            $count = Category::where('pid ='.$cid)->select();
//            if (count($count) > 0){
//                foreach ($count as $key => $val){
//                    $cid .= ','.$val->cid;
//                }
//            }
            $where .= ' and a.cid = '.$cid;
        }
        $list = [];
        $catlist = Category::field('cname,cid')->where('pid = 0')->order('`order` asc')->select();
        foreach ($catlist as $key => $val){
            $catlist[$key]['child'] = Category::field('cname,cid')->where('pid = '.$val['cid'])->order('`order` asc')->select();
        }
        foreach ($catlist as $key => $val) {
            $arr = $val->toArray();
            if (array_key_exists('child',$arr) && !empty($val['child'])){
                $arrlist[] = $val;
            }else{
                $brr[] = $val;
            }
        }
        $list['btn1'] = $brr[0];
        $list['btn2'] = !empty($arrlist[0])?$arrlist[0]:'';
        $list['btn3'] = $brr[1];
        $list['btn4'] = $arrlist[1];
        $list['data'] = Product::alias('a')->join('category b','a.cid = b.cid')->where($where)->paginate(6);
//         foreach ($list['data'] as $key => $val) {
//             if ($val->is_btn2 == 1) {
//                 $btn2 = $val->cname;
//             }
//             if ($val->is_btn4 == 1) {
//                 $btn4 = $val->cname;
//             }
//         }
        if (!empty($_GET['cid'])) {
            $cid = $_GET['cid'];
            if ($cid == $arrlist[0]->cid) {
                $btn = Category::field('cname,cid')->where('cid = '.$cid)->find();
            }
            foreach ($arrlist[0]['child'] as $key => $val){
                if ($cid == $val->cid) {
                    $btn = Category::field('cname,cid')->where('cid = '.$cid)->find();
                }
            }
            if(!empty($btn)){
                $btn2 = $btn;
            }
            if ($cid == $arrlist[1]->cid) {
                $btn1 = Category::field('cname,cid')->where('cid = '.$cid)->find();
            }
            foreach ($arrlist[1]['child'] as $key => $val){
                if ($cid == $val->cid) {
                    $btn1 = Category::field('cname,cid')->where('cid = '.$cid)->find();
                }
            }
            if(!empty($btn1)) {
                $btn4 = $btn1;
            }
        }
        $this->assign('btn2',$btn2);
        $this->assign('btn4',$btn4);
        $this->assign('page',$list['data']->render());
        $this->assign('list',$list);
        return view();
    }
    /*
    * contact_us
    */
    public function contact_us()
    {
        return view();
    }
    /*
    * contact_us submit
    */
    public function contact_sub()
    {
        if ($_POST) {
            $contact = new Contact;
            $validate = Loader::validate('Contact');
            $data = $_POST;
            if (strtolower($data['captcha']) == Session('capt')) {
                if (!$validate->check($data)) {
                    $ret = '';
                    $msg = $validate->getError();
                }else {
                    $data['add_time'] = time();
                    $ret = $contact->allowField(true)->save($data);
                }
                $str = '';
                if (!empty($data['uname'])) {
                    $str .= '姓名：'.$data['uname'].'<br/>';
                }
                if(!empty($data['email'])){
                    $str .= '邮箱：'.$data['email'].'<br/>';
                }
                if(!empty($data['company'])){
                    $str .= '公司名称：'.$data['company'].'<br/>';
                }
                if(!empty($data['tel'])){
                    $str .= '电话:'.$data['tel'].'<br/>';
                }
                if(!empty($data['message'])){
                    $str .= '留言:'.$data['message'].'<br/>';
                }
                $this->sendMail('2629984398@qq.com','邮件',$str);   //
                if ($ret) {
                    $res = array('code' => 1, 'msg' => 'Submission of success');
                }else {
                    $res = array('code' => 2, 'msg' => $msg?$msg:'fail');
                }
            }else {
                $res = array('code' => 2, 'msg' => 'Validation code is incorrect');
            }
            return $res;
        }
    }
    /*
    * captcha
    */
    public function doimg()
    {
        $validatecode = new ValidateCode;
        $validatecode->doimg();
        Session('capt',$validatecode->getCode());
    }
    /*
    * getproduct
    */
    public function getproduct()
    {
        if ($_POST) {
            if(!empty($_POST['cid'])) {
                $id = $_POST['cid'];
                $product = new Product;
                $list = $product->getCatSelect($id);
                if (!empty($list)) {
                    $res = array('code' => 1, 'data' =>  $list);
                }else {
                    $res = array('code' => 2, 'msg' => '暂无数据');
                }
            }else{
                $res = array('code' => 2, 'msg' => '缺少参数');
            }
            return $res;
        }
    }
    /*
    *  subemail
    */
    public function subemail()
    {
        if ($_POST) {
            $email = new Email;
            $data = $_POST;
            $validate = Loader::validate('Email');
            if ($validate->check($data)) {
                $data['add_time'] = time();
                $res = $email->allowField(true)->save($data);
            }
            if ($res) {
                $ret = array('code' => 1, 'msg' => 'Submission of success');
            }else {
                $ret = array('code' => 1, 'msg' => 'fail');
            }
            return $ret;
        }
    }
    function sendMail($to,$title,$content){

        //引入PHPMailer的核心文件 使用require_once包含避免出现PHPMailer类重复定义的警告
        import('PHPMailer',EXTEND_PATH,'.php');
        import('smtp',EXTEND_PATH,'.php');
        //实例化PHPMailer核心类
        $mail = new \PHPMailer();

        //是否启用smtp的debug进行调试 开发环境建议开启 生产环境注释掉即可 默认关闭debug调试模式
        $mail->SMTPDebug = 1;

        //使用smtp鉴权方式发送邮件
        $mail->isSMTP();

        //smtp需要鉴权 这个必须是true
        $mail->SMTPAuth=true;

        //链接163域名邮箱的服务器地址
        $mail->Host = 'smtp.163.com';

        //设置使用ssl加密方式登录鉴权
        $mail->SMTPSecure = 'ssl';

        //设置ssl连接smtp服务器的远程服务器端口号，以前的默认是25，但是现在新的好像已经不可用了 可选465或587
        $mail->Port = 587;

        //设置smtp的helo消息头 这个可有可无 内容任意
        // $mail->Helo = 'Hello smtp.qq.com Server';

        //设置发件人的主机域 可有可无 默认为localhost 内容任意，建议使用你的域名
        $mail->Hostname = 'glaxtex.com';

        //设置发送的邮件的编码 可选GB2312 我喜欢utf-8 据说utf8在某些客户端收信下会乱码
        $mail->CharSet = 'UTF-8';

        //设置发件人姓名（昵称） 任意内容，显示在收件人邮件的发件人邮箱地址前的发件人姓名
        $mail->FromName = '联系我们信息';

        //smtp登录的账号 这里填入字符串格式的qq号即可
        $mail->Username ='testyida@163.com';

        //smtp登录的密码 使用生成的授权码（就刚才叫你保存的最新的授权码）
        $mail->Password = 'wangyi123';

        //设置发件人邮箱地址 这里填入上述提到的“发件人邮箱”
        $mail->From = 'testyida@163.com';

        //邮件正文是否为html编码 注意此处是一个方法 不再是属性 true或false
        $mail->isHTML(true);

        //设置收件人邮箱地址 该方法有两个参数 第一个参数为收件人邮箱地址 第二参数为给该地址设置的昵称 不同的邮箱系统会自动进行处理变动 这里第二个参数的意义不大
        $mail->addAddress($to,'邮件');

        //添加多个收件人 则多次调用方法即可
        // $mail->addAddress('xxx@163.com','lsgo在线通知');

        //添加该邮件的主题
        $mail->Subject = $title;

        //添加邮件正文 上方将isHTML设置成了true，则可以是完整的html字符串 如：使用file_get_contents函数读取本地的html文件
        $mail->Body = $content;

        //为该邮件添加附件 该方法也有两个参数 第一个参数为附件存放的目录（相对目录、或绝对目录均可） 第二参数为在邮件附件中该附件的名称
        // $mail->addAttachment('./d.jpg','mm.jpg');
        //同样该方法可以多次调用 上传多个附件
        // $mail->addAttachment('./Jlib-1.1.0.js','Jlib.js');

        $status = $mail->send();

        //简单的判断与提示信息
        if($status) {
            return true;
        }else{
            return false;
        }
    }
}

<?php
namespace app\index\controller;

class Server extends Index
{
    function sendMail($to,$title,$content){

        //引入PHPMailer的核心文件 使用require_once包含避免出现PHPMailer类重复定义的警告
        import('PHPmailer',EXTEND_PATH,'.php');
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
        $mail->Port = 465;

        //设置smtp的helo消息头 这个可有可无 内容任意
        // $mail->Helo = 'Hello smtp.qq.com Server';

        //设置发件人的主机域 可有可无 默认为localhost 内容任意，建议使用你的域名
        $mail->Hostname = 'localhost';

        //设置发送的邮件的编码 可选GB2312 我喜欢utf-8 据说utf8在某些客户端收信下会乱码
        $mail->CharSet = 'UTF-8';

        //设置发件人姓名（昵称） 任意内容，显示在收件人邮件的发件人邮箱地址前的发件人姓名
        $mail->FromName = '易大通知';

        //smtp登录的账号 这里填入字符串格式的qq号即可
        $mail->Username ='testyida@163.com';

        //smtp登录的密码 使用生成的授权码（就刚才叫你保存的最新的授权码）
        $mail->Password = 'wangyi123';

        //设置发件人邮箱地址 这里填入上述提到的“发件人邮箱”
        $mail->From = 'testyida@163.com';

        //邮件正文是否为html编码 注意此处是一个方法 不再是属性 true或false
        $mail->isHTML(true);

        //设置收件人邮箱地址 该方法有两个参数 第一个参数为收件人邮箱地址 第二参数为给该地址设置的昵称 不同的邮箱系统会自动进行处理变动 这里第二个参数的意义不大
        $mail->addAddress($to,'通知');

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
    /*
    * 预约演示
    */
    public function make()
    {
        if ($_POST) {
            $data = [];
            if(!empty($_POST['com_name']) && !empty($_POST['name']) && !empty($_POST['mobile'])) {
                $data['com_name'] = htmlspecialchars($_POST['com_name']);
                $data['name'] = htmlspecialchars($_POST['name']);
                $msg = '';
                $check = true;
                $flag = false;
                $str = '您有一个新的预约：</br> '."\n";
                $str .= '公司名称：'.$data['com_name'].'</br>';
                $str .= '姓名：'.$data['name'].'</br>';
                if(!empty($_POST['qq'])) {
                    if (preg_match('/^\d{5,10}$/',$_POST['qq'])) {
                        $data['qq'] = htmlspecialchars($_POST['qq']);
                        $str .= 'QQ:'.$data['qq'].'</br>';
                    }else {
                        $flag = true;
                        $msg = '请输入正确的qq号码';
                    }
                }
                if(!empty($_POST['wechat'])) {
                    $data['wechat'] = htmlspecialchars($_POST['wechat']);
                    $str .= '微信：'.$data['wechat'].'</br>';
                }
                if (strlen($_POST['mobile']) == 11) {
                    if(preg_match('/^13[0-9]|14[5|7]|(15([0-3]|[5-9]))|(18[0,5-9])\\d{8}$/',$_POST['mobile'])) {
                        $data['mobile'] = htmlspecialchars($_POST['mobile']);
                        $str .= '联系电话：'.$data['mobile'].'</br>';
                    }else {
                        $flag = true;
                        $msg = '手机号码格式不正确';
                    }
                }else{
                    $flag = true;
                    $msg = '请输入11位手机号码';
                }
                if (!empty($_POST['email'])) {
                    if (preg_match('/^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/',$_POST['email'])) {
                        $data['email'] = htmlspecialchars($_POST['email']);
                        $str .= 'email：'.$data['email'].'<br/>';
                    }else {
                        $flag = true;
                        $msg = '邮箱格式不正确';
                    }
                }

                if ($flag) {
                    $check = false;
                }
                if ($check) {
                    $data['add_time'] = time();
                    $ret = db('make')->insert($data);
                    if ($ret) {
                        $this->sendMail('875468934@qq.com','通知',$str);
                        $res = array('code' => 1, 'msg' => '预约成功');
                    }else {
                        $res = array('code' => 2, 'msg' => '失败');
                    }
                }else {
                    $res = array('code' => 2, 'msg' => $msg?$msg:'失败2');
                }
            }else{
                $res = array('code' => 2, 'msg' => '缺少参数');
            }
            return $res;
        }
    }
}

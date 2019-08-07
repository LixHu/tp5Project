<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:70:"F:\zm\my\boquan\public/../application/boquan\view\user\reg_server.html";i:1521003368;s:58:"F:\zm\my\boquan\application\boquan\view\public\header.html";i:1520643971;s:58:"F:\zm\my\boquan\application\boquan\view\public\footer.html";i:1520643971;}*/ ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="renderer" content="webkit">
    <link rel="shortcut icon" href="_icon/favicon.ico" type="image/vnd.microsoft.icon">
    <link rel="icon" href="_icon/favicon.ico" type="image/vnd.microsoft.icon">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <title>博权云后台管理系统</title>
    <link href="_css/bootstrap.min.css" rel="stylesheet">
    <link href="_css/sb-admin.css" rel="stylesheet">
    <link href="_font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="_css/style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="_css/select2.min.css">
    <link href="_css/AdminLTE.min.css" rel="stylesheet" type="text/css"/>
    <script src="_js/jquery.js"></script>
    <script src="_js/bootstrap.min.js"></script>
    <!--<script src="_js/closable-tab-div.js"></script>-->
    <script src="_js/public.js"></script>
    <script src="_js/echarts.js"></script>
    <script src="_js/vue.min.js"></script>
    <link rel="stylesheet" href="_css/select2.min.css">
    <script src="_js/select2.min.js"></script>
    <!--<script src="_js/jqPaginator.js" type="text/javascript"></script>-->
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <link href="http://cdn.bootcss.com/bootstrap-daterangepicker/2.1.25/daterangepicker.css" rel="stylesheet"/>
    <script src="http://cdn.bootcss.com/bootstrap-daterangepicker/2.1.25/moment.min.js"></script>
    <script src="http://cdn.bootcss.com/bootstrap-daterangepicker/2.1.25/daterangepicker.js"></script>
    <![endif]-->
    <script src="_js/layer/layer.js"></script>
    <script src="_js/laydate/laydate.js"></script>
</head>
<body>
<style>
    #vue-dingyi-paging ul {
        list-style: none;
        margin-top: 10px;
    }

    #vue-dingyi-paging ul li {
        margin: 0 5px;
    }

    #vue-dingyi-paging ul li,
    .pageLink {
        display: inline-block;
        width: 40px;
        height: 40px;
        background: #F0F0F0;
        color: #ABABAB;
        border-radius: 3px;
        text-align: center;
        text-decoration: none;
        line-height: 40px;
    }

    #vue-dingyi-paging ul li .pageLink:hover {
        background: #ABABAB;
        color: #FFFFFF;
    }

    #vue-dingyi-paging ul li .curPage {
        background: #81C06F;
        color: #FFFFFF;
    }
</style>

<style>
</style>
<div style="width: 100%;height: 100vh;background: #eeeeee url('_images/new/login_bg.png') center no-repeat;display: flex;align-items: center;background-size: 100% 100vh;">
    <div style="margin: 0 auto;width: 527px;height: 600px;background: transparent;text-align: center;box-shadow: 0px 0px 30px #888888;">
        <div style="margin: 50px 100px;">
            <form action="" method="post" id="form">
                <div style="font-weight: bold;font-size: 18px;">博权云服务站注册</div>
                <div style="margin: 30px 0;border-bottom: 1px solid #000;overflow: auto;">
                    <label class="pull-left">手机号：</label>
                    <input type="text" class="pull-left input" style="background: transparent;width: calc(100% - 60px);
					border: 0;" name="mobile" />
                </div>
                <div style="margin: 30px 0;border-bottom: 1px solid #000;overflow: hidden;">
                    <label class="pull-left">验证码：</label>
                    <input type="text" class="pull-left input" style="background: transparent;width: calc(100% - 190px);border: 0;" name="verifycode" />
                    <button class="btn btn-primary" type="button" id="sms" onclick="sendsms()" style="display: inline-block;">获取验证码</button>
                </div>
                <div style="margin: 30px 0;border-bottom: 1px solid #000;overflow: auto;">
                    <label class="pull-left">服务站名称:</label>
                    <input type="text" class="pull-left input" style="background: transparent;width: calc(100% - 90px);
					border: 0;" name="gname" />
                </div>
                <div style="margin: 30px 0;border-bottom: 1px solid #000;overflow: auto;">
                    <label class="pull-left">服务站地址:</label>
                    <input type="text" class="pull-left input" style="background: transparent;width: calc(100% - 90px);
					border: 0;" name="address" />
                </div>
                <div style="margin: 30px 0;border-bottom: 1px solid #000;overflow: auto;">
                    <label class="pull-left">服务站负责人：</label>
                    <input type="text" class="pull-left input" style="background: transparent;width: calc(100% - 120px);
					border: 0;" name="rela_name" />
                </div>
                <div style="margin: 30px 0;border-bottom: 1px solid #000;overflow: auto;">
                    <label class="pull-left">密码：</label>
                    <input type="password" class="pull-left input" style="background: transparent;width: calc(100% - 50px);
					border: 0;" name="password" />
                </div>
                <div style="margin: 30px 0;border-bottom: 1px solid #000;overflow: auto;">
                    <label class="pull-left">确认密码：</label>
                    <input type="password" class="pull-left input" style="background: transparent;width: calc(100% - 70px);
					border: 0;" name="password2" />
                </div>
                <div style="clear: both;"></div>
                <button type="button" onclick="subForm()" class="bg-blue2" style="color: #FFFFFF;border: 0;width: 100%;height: 30px;line-height: 30px;">注 册
                </button>
            </form>
            <a style="float: right;padding:10px;color:#6d6666;" href="<?php echo url('user/login'); ?>">已有账号，去登录>></a>
        </div>
    </div>
</div>
<script>
    var subForm = function () {
        var data = $('#form').serializeArray();
        $.post('server_log', data, function (res) {
            alert(res.msg);
            if (res.code == 1) {
                location.reload();
            }
        })
    }
    var sencond = 60;
    function sendsms() {
        var data = {};
        data.mobile = $("input[name='mobile']").val();
        $.post('send_sms', data, function (res) {
            if (res.code == 1000) {
                changesencond();
            }
        })
    }
    function changesencond() {
        $("#sms").attr('disabled', 'disabled');
        setInterval(function () {
            $("#sms").text(sencond-- + '秒后再次获取');
            if (sencond < 0) {
                clearInterval();
                $("#sms").text('获取验证码');
                $("#sms").removeAttr('disabled');
            }
        }, 1000);
    }
</script> </body>
</html>
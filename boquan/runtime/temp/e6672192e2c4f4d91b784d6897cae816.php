<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:65:"F:\zm\my\boquan\public/../application/boquan\view\user\login.html";i:1520912297;s:58:"F:\zm\my\boquan\application\boquan\view\public\header.html";i:1520643971;s:58:"F:\zm\my\boquan\application\boquan\view\public\footer.html";i:1520643971;}*/ ?>
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
    <div style="margin: 0 auto;width: 500px;height: 400px;background: transparent;text-align: center;box-shadow: 0px 0px 30px #888888;">
        <div style="margin: 50px 100px;">
            <form action="" method="post">
                <div style="font-weight: bold;font-size: 18px;">博权云</div>
                <div style="margin: 30px 0;border-bottom: 1px solid #000;overflow: auto;">
                    <label class="pull-left">账号：</label>
                    <input type="text" class="pull-left input" style="background: transparent;width: calc(100% - 50px);
					border: 0;" name="mobile"/>
                </div>
                <div style="clear: both;"></div>
                <div style="margin: 30px 0;border-bottom: 1px solid #000;overflow: auto;">
                    <label class="pull-left">密码：</label>
                    <input type="password" class="pull-left input"
                           style="background: transparent;width: calc(100% - 50px);border: 0;" name="password"/>
                </div>
                <button class="bg-blue2" style="color: #FFFFFF;border: 0;width: 100%;height: 30px;line-height: 30px;">登
                    录
                </button>
            </form>
            <a style="color:#666060;padding:10px;float:right;" href="<?php echo url('user/reg'); ?>">没有账号，去注册>></a>
        </div>
    </div>
</div>
</body>
</html>                                           
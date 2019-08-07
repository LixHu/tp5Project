<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:61:"F:\zm\my\tp\public/../application/shop\view\guide\h5_reg.html";i:1521103475;}*/ ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>推荐</title>
    <meta http-equiv="x-ua-compatible" content="IE=edge">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <!--<meta name="apple-mobile-web-app-capable" content="yes">-->
    <!--<meta name="apple-touch-fullscreen" content="yes">-->
    <link rel="stylesheet" type="text/css" href="/static/lib/weui.min.css">
    <link rel="stylesheet" type="text/css" href="/static/css/jquery-weui.css">
    <link rel="stylesheet" type="text/css" href="/static/css/style_h5.css">
    <link rel="stylesheet" type="text/css" href="/static/css/font-awesome.min.css">
    <style>
        .weui-btn_primary {
            background-color: #f18b2d;
        }
        .weui-vcode-btn {
            color: #f18b2d;
        }
    </style>
    <!--[if IE]>
    <script src="http://libs.useso.com/js/html5shiv/3.7/html5shiv.min.js"></script>
    <![endif]-->
</head>
<body ontouchstart >
<div class="text-center" style="position:relative;">
    <img src="/static/images/h5_reg_bg.jpg" alt="" style="width: 100%;height: auto;">
    <img src="/static/images/logo.png" alt="" style="position: absolute;top: 50%;left: 50%;margin-left: -93px;margin-top: -122px;">
</div>
<div class="weui-cells font14 weui-cells_form">
    <div class="weui-cell weui-cell_select weui-cell_select-after">
        <div class="weui-cell__hd">
            <label for="" class="weui-label">注册类型</label>
        </div>
        <div class="weui-cell__bd">
            <select class="weui-select" name="role">
                <option value="1">用户</option>
                <option value="2">司机</option>
            </select>
        </div>
    </div>
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">手机号</label></div>
        <div class="weui-cell__bd">
            <input class="weui-input" type="text" name="mobile" placeholder="请输入手机号">
        </div>
    </div>
    <div class="weui-cell weui-cell_vcode">
        <div class="weui-cell__hd">
            <label class="weui-label">验证码</label>
        </div>
        <div class="weui-cell__bd">
            <input class="weui-input" type="verifycode" placeholder="请输入验证码">
        </div>
        <div class="weui-cell__ft">
            <button class="weui-vcode-btn" onclick="sendsms()">获取验证码</button>
        </div>
    </div>
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">密码</label></div>
        <div class="weui-cell__bd">
            <input class="weui-input" type="password" name="password" placeholder="请输入密码">
        </div>
    </div>
</div>
<div class="weui-btn-area" style="margin-bottom: 100px;">
    <a class="weui-btn weui-btn_primary" href="javascript:" id="showTooltips">注册</a>
</div>


<script src="/static/lib/jquery-2.1.4.js"></script>
<script src="/static/js/h5.js"></script>
<script src="/static/lib/fastclick.js"></script>
<script src="/static/js/jquery-weui.js"></script>
<script type="text/javascript">
    $(function () {
        FastClick.attach(document.body);
    });
    //返回顶部
    $('#backTop').click(function () {
        $('#content').animate({scrollTop: 0}, 300);
    });
    function sendsms() {
        var val = $("input[name='mobile']").val();
        if(val != ''){
            var data = {};
            data.mobile = val;
            $.post('sendsms',data,function(res){
                alert(res.msg);
            })
        }else{
            alert('请填写手机号');
        }
    }
</script>
</body>
</html>
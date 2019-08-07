<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:64:"F:\zm\my\boquan\public/../application/index\view\user\login.html";i:1520643972;s:57:"F:\zm\my\boquan\application\index\view\public\header.html";i:1520643972;s:57:"F:\zm\my\boquan\application\index\view\public\footer.html";i:1520643972;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="description" content="">
    <title>博权云服务平台-登录</title>
    <script src="_ago/lib/jquery-2.1.4.js"></script>
    <script src="_ago/lib/fastclick.js"></script>
    <script src="_ago/js/jquery-weui.js"></script>
    <link rel="stylesheet" href="_ago/lib/weui.min.css">
    <link rel="stylesheet" href="_ago/css/jquery-weui.css">
    <link rel="stylesheet" href="_ago/css/style.css">
    <link rel="stylesheet" href="_ago/demos/css/demos.css">

<body ontouchstart>

    <style>
        input::-webkit-input-placeholder {
            font-size: 0.75rem;
        }

        input:-ms-input-placeholder {
            font-size: 0.75rem;
        }
        .weui-label {
            width: 2.4rem;
        }

        .weui-cells:before {
            -webkit-transform: scaleY(.0);
            transform: scaleY(.0);
        }
    </style>
<header class="header">
    <a href="javascript:location.reload();">
        <img src="_ago/images/logo@2x.png" alt="" class="vertical-align-middle icon"/>
        <span class="header-title">博权云服务平台</span>
    </a>
</header>

<div class="space"></div>
<div class="body-content-margin">
    <form action="" id="myform" method="post">
    <div class="login-form">
        <div class="weui-cells weui-cells_form">
            <div class="weui-cell">
                <div class="weui-cell__hd">
                    <label class="weui-label">
                        <img src="_ago/images/phone.png" alt="" class="icon"/>
                    </label>
                </div>
                <div class="weui-cell__bd">
                    <input class="weui-input" type="text" name="mobile" placeholder="请输入手机号"/>
                </div>
            </div>
        </div>
        <div class="weui-cells weui-cells_form">
            <div class="weui-cell">
                <div class="weui-cell__hd">
                    <label class="weui-label">
                        <img src="_ago/images/password.png" alt="" class="icon"/>
                    </label>
                </div>
                <div class="weui-cell__bd" style="position: relative;">
                    <input class="weui-input" id="loginPassword" type="password" name="password" pattern="[0-9]*" placeholder="请输入密码"/>
                    <img src="_ago/images/no-pwd.png" width="30" height="30" data-src="_ago/images/yes-pwd.png" data-d-src="_ago/images/no-pwd.png" id="noPwd"
                         alt="" class="icon" style="position:absolute;right: 0;top: 0;">
                </div>
            </div>
        </div>
    </div>
    </form>
    <a href="javascript:;" onclick="sub()" class="weui-btn btn-primary2">登录</a>
    <a href="<?php echo url('user/reg'); ?>" class="weui-btn btn-primary">没有账号去注册</a>
    <div class="mt15 text-center">
        <a href="<?php echo url('user/forget'); ?>" class="color-blue2">忘记密码？</a>
    </div>

</div>
<div style="width: 100%;height: 2rem;"></div>
<div class="text-center">
    <div class="weui-loadmore weui-loadmore_line ">
        <span class="weui-loadmore__tips">第三方登录</span>
    </div>
    <a href="_ago/images/wechat@2x.png">
        <img src="_ago/images/wechat@2x.png" alt="" class="icon">
        <div style="font-size: 0.75rem;">微信</div>
    </a>
</div>
    </body>
</html>
<script src="_ago/lib/jquery-2.1.4.js"></script>
<script src="_ago/lib/fastclick.js"></script>
<script src="_ago/js/jquery-weui.js"></script>
<script>
    $(function () {
        FastClick.attach(document.body);
        //显示隐藏密码
        $('#noPwd').click(function () {
            if (this.src.indexOf('no') != '-1') {
                this.src = $(this).attr('data-src');
                $('#loginPassword').attr('type', 'text');
            } else {
                this.src = $(this).attr('data-d-src');
                $('#loginPassword').attr('type', 'password');
            }
        })
    });
    var sub = function(){
        var form = $("#myform").serialize();
        $.post('login_handle',form,function(res){
            res = JSON.parse(res);
            console.log(res);
            if (res.code == 1){
                // if(res.rid == 2){      //司机
                    location.href=res.url;
                // }
            }else{
                alert(res.msg);
            }
        })
    }
</script>

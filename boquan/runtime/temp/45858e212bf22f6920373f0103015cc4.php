<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:62:"F:\zm\my\boquan\public/../application/index\view\user\reg.html";i:1520643972;s:57:"F:\zm\my\boquan\application\index\view\public\header.html";i:1520643972;s:57:"F:\zm\my\boquan\application\index\view\public\footer.html";i:1520643972;}*/ ?>
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
    <form action="" id="myform">
        <div class="login-form">
            <div class="weui-cells weui-cells_form">
                <div class="weui-cell">
                    <div class="weui-cell__hd">
                        <label class="weui-label">
                            <img src="_ago/images/user.png" alt="" class="icon"/>
                        </label>
                    </div>
                    <div class="weui-cell__bd">
                        <input class="weui-input" type="text" name="nick_name" placeholder="请输入昵称"/>
                    </div>
                </div>
            </div>
            <div class="weui-cells weui-cells_form">
                <div class="weui-cell">
                    <div class="weui-cell__hd">
                        <label class="weui-label">
                            <img src="_ago/images/phone.png" alt="" class="icon"/>
                        </label>
                    </div>
                    <div class="weui-cell__bd">
                        <input class="weui-input" type="number" name="mobile" placeholder="请输入手机号"/>
                    </div>
                </div>
            </div>
            <div class="weui-cells weui-cells_form">
                <div class="weui-cell">
                    <div class="weui-cell__hd">
                        <label class="weui-label">
                            <img src="_ago/images/verification_code.png" alt="" class="icon"/>
                        </label>
                    </div>
                    <div class="weui-cell__bd" style="position: relative;">
                        <input class="weui-input" id="verification" name="verify" type="number" pattern="[0-9]*" placeholder="请输入验证码" />
                        <a href="javascript:void(0)" id="sendbtn" onclick="sendSms('<?php echo url('Sendmes/send_sms'); ?>')" class="weui-btn btn-primary2" style="position: absolute;right: 0;top: -0.4rem;font-size: 0.75rem;padding-left: 0.75rem;padding-right: 0.75rem;">获取验证码</a>
                        <a href="javascript:void(0)" id="sendbtn2" class="weui-btn btn-primary2" style="display: none;position: absolute;right: 0;top: -1.37rem;font-size: 0.75rem;padding-left: 0.75rem;padding-right: 0.75rem;">获取验证码</a>
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
                    <div class="weui-cell__bd">
                        <input class="weui-input" id="regPassword" name="password" type="password" placeholder="请输入密码" />
                    </div>
                </div>
            </div>
            <div class="weui-cells weui-cells_form">
                <div class="weui-cell">
                    <div class="weui-cell__hd">
                        <label class="weui-label">
                            <img src="_ago/images/password.png" alt="" class="icon" />
                        </label>
                    </div>
                    <div class="weui-cell__bd">
                        <input class="weui-input" id="confirmPassword" name="password2" type="password" placeholder="请再次输入密码" />
                    </div>
                </div>
            </div>
        </div>
        <a onclick="subform()" class="weui-btn btn-primary">注册</a>
    </form>
    <div class="mt15 text-right">
        <a href="<?php echo url('user/login'); ?>" class="color-blue2 ">已有账号？</a>
    </div>
</div>
    </body>
</html>
<script src="_ago/lib/jquery-2.1.4.js"></script>
<script src="_ago/lib/fastclick.js"></script>
<script src="_ago/js/jquery-weui.js"></script>
<script>
    $(function () {
        FastClick.attach(document.body);

    });
    var subform = function(){
        var form = $("#myform").serialize();
        $.post('reg_handle',form,function(res){
            if (res.code == 1){
                alert(res.msg);
                location.href="/index/user/login";
            }else{
                alert(res.msg);
            }
        })
    }
    var sendbtn = $('#sendbtn');
    var sendbtn2 = $('#sendbtn2');
    var wait=60;
    var sendSms = function(url){
        var data = {};
        data.mobile = $("input[name='mobile']").val();
        $.post(url,data,function(res){
            // if(res.data == 1){
                // 发送成功
                alert(res.msg)
                if(res.code == 1000){
                codetime();
                }
            // }

        })
    }
    function codetime() {
        if (wait == 0) {
            sendbtn.show();
            sendbtn2.hide();
            sendbtn2.text("获取验证码");
            wait = 60;
        } else {
            sendbtn.hide();
            sendbtn2.show();
            sendbtn2.text("已发送(" + wait+ 's' + ")");
            wait--;
            setTimeout(function() {
                codetime();
            },1000)
        }
    }
</script>

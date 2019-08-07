<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:66:"F:\zm\my\tp\public/../application/shop\view\guide\h5_homepage.html";i:1521111819;}*/ ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>捷律指南</title>
    <meta http-equiv="x-ua-compatible" content="IE=edge">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <!--<meta name="apple-mobile-web-app-capable" content="yes">-->
    <!--<meta name="apple-touch-fullscreen" content="yes">-->
    <link rel="stylesheet" type="text/css" href="/static/lib/weui.min.css">
    <link rel="stylesheet" type="text/css" href="/static/css/jquery-weui.css">
    <link rel="stylesheet" type="text/css" href="/static/css/style_h5.css">
    <link rel="stylesheet" type="text/css" href="/static/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="/static/css/weui2.css"/>
    <link rel="stylesheet" type="text/css" href="/static/css/icon.css"/>
    <style>

    </style>
    <!--[if IE]>
    <script src="http://libs.useso.com/js/html5shiv/3.7/html5shiv.min.js"></script>
    <![endif]-->
</head>
<body ontouchstart  style="background: #e8e8e8 !important;">
<div>
    <img src="/static/images/homepage.png" alt="" class="homepage-img">
</div>
<div class="font18" style="background: #ffffff;">
    <div class="homepage-head">
        <div style="flex: 1;border-right: 1px solid #d9d9d9;">
            <div>服务次数</div>
            <div class="homepage-num"><?php echo $fuwu; ?></div>
        </div>
        <div style="flex: 1">
            <div>司机排名</div>
            <div class="homepage-num"><?php echo $paiming; ?></div>
        </div>
    </div>
    <?php if(is_array($applist) || $applist instanceof \think\Collection || $applist instanceof \think\Paginator): $i = 0; $__LIST__ = $applist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
    <div class="homepage-con">
        <?php if(is_array($vo) || $vo instanceof \think\Collection || $vo instanceof \think\Paginator): $i = 0; $__LIST__ = $vo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
        <div style="flex: 1;">
            <div><?php echo $v['name']; ?>【<?php echo db('orders')->where('user_assess ='.$v['id'].' and did ='.$did)->count();?>】</div>
        </div> 
        <?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
    <?php endforeach; endif; else: echo "" ;endif; ?>
    <!-- <div class="homepage-con">
        <div style="flex: 1;">
            <div>服务次数【10】</div>
        </div>
        <div style="flex: 1">
            <div>司机排名【10】</div>
        </div>
    </div>
    <div class="homepage-con">
        <div style="flex: 1;">
            <div>服务次数【10】</div>
        </div>
        <div style="flex: 1">
            <div>司机排名【10】</div>
        </div>
    </div>
    <div class="homepage-con">
        <div style="flex: 1;">
            <div>服务次数【10】</div>
        </div>
        <div style="flex: 1">
            <div>司机排名【10】</div>
        </div>
    </div>
    <div class="homepage-con">
        <div style="flex: 1;">
            <div>服务次数【10】</div>
        </div>
        <div style="flex: 1">
            <div>司机排名【10】</div>
        </div>
    </div>
    <div class="homepage-con">
        <div style="flex: 1;">
            <div>服务次数【10】</div>
        </div>
        <div style="flex: 1">
            <div>司机排名【10】</div>
        </div>
    </div>
    <div class="homepage-con">
        <div style="flex: 1;">
            <div>服务次数【10】</div>
        </div>
        <div style="flex: 1">
            <div>司机排名【10】</div>
        </div>
    </div> -->

</div>

<script src="/static/lib/jquery-2.1.4.js"></script>
<script src="/static/js/h5.js"></script>
<script src="/static/lib/fastclick.js"></script>
<script src="/static/js/jquery-weui.js"></script>
<script type="text/javascript">
    $(function () {
        FastClick.attach(document.body);
    });

</script>
</body>
</html>
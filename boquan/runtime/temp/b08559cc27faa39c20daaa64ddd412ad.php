<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:66:"F:\zm\my\boquan\public/../application/boquan\view\index\index.html";i:1521183613;s:58:"F:\zm\my\boquan\application\boquan\view\public\header.html";i:1520643971;s:58:"F:\zm\my\boquan\application\boquan\view\public\footer.html";i:1520643971;}*/ ?>
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
    body {
        margin-top: 50px;
        background-color: #eeeeee;
    }

    .navbar-inverse {
        background-color: #27a9e6;
        border-color: #27a9e6;
        color: #ffffff;
    }

    .navbar-inverse .navbar-nav > li > a {
        color: #ffffff;
    }

    .navbar-inverse .navbar-brand {
        color: #ffffff !important;
    }

    @media (min-width: 1200px) {
        .navbar-header {
            float: left;
            margin-left: 72px;
        }
    }

    .navbar-inverse .navbar-toggle {
        border-color: #fff;
    }
</style>
<div id="wrapper">
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" data-href="<?php echo url('index/main'); ?>" href="javascript:void(0)">
                博权云 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo \think\Session::get('user')->gname; ?>
            </a>
        </div>
        <ul class="nav navbar-right top-nav">
            <li style="position:relative;width: 52px;height: 52px;line-height: 52px;text-align: center;">
                <a href="javascript:;" data-leftHref="boquan/System/system_info"
                   onclick="closableTab.addTab({'id': '20000', 'name': '通知', 'url': this.getAttribute('data-leftHref'), 'closable': true});">
                    <i class="fa fa-bell" style="font-size: 20px;color: #ffffff;"></i>
                    <?php if($mes != 0): ?>
                    <div style="position: absolute;right: 9px;top: 13px;width: 15px;height: 17px;font-size: 14px;color: #fff;background: #ff0000;border-radius: 100%;"><?php echo $mes; ?></div>
                    <?php endif; ?>
                </a>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="_images/self1.png" alt=""></a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="javascript:;"><i class="fa fa-fw fa-user"></i><?php echo \think\Session::get('user')->fw_name; ?></a>
                    </li>
                    <!--<li>-->
                        <!--<a href="#"><i class="fa fa-fw fa-envelope"></i> Inbox</a>-->
                    <!--</li>-->
                    <!--<li>-->
                        <!--<a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>-->
                    <!--</li>-->
                    <!--<li class="divider"></li>-->
                    <li>
                        <a href="<?php echo url('index/sign_out'); ?>"><i class="fa fa-fw fa-power-off"></i> 退出登录</a>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav side-nav">
                <?php if(is_array($menu) || $menu instanceof \think\Collection || $menu instanceof \think\Paginator): $i = 0; $__LIST__ = $menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <li>
                    <a href="javascript:;" data-toggle="collapse" data-target="#<?php echo $vo['con']; ?>"><i
                            class="<?php echo $vo['mimg']; ?>"></i> <?php echo $vo['mname']; ?> <i class="fa fa-fw fa-angle-right"></i></a>
                    <ul id="<?php echo $vo['con']; ?>" class="collapse">
                        <?php if(is_array($vo['child']) || $vo['child'] instanceof \think\Collection || $vo['child'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                            <li>
                                <a data-leftHref="<?php echo request()->module(); ?>/<?php echo $v['con']; ?>/<?php echo $v['method']; ?>" href="javascript:void(0)"
                                   onclick="closableTab.addTab({'id': '<?php echo $v['mid']; ?>', 'name': this.innerText, 'url': this.getAttribute('data-leftHref'), 'closable': true});">
                                    <i class="<?php echo $v['mimg']; ?>"></i><?php echo $v['mname']; ?>
                                </a>
                            </li>
                        <?php endforeach; endif; else: echo "" ;endif; if($vo['mname'] == '客户管理' and Session('user')->pid == 1): ?> <!--判断是客户管理 且为主机厂 显示客户审核列表 -->
                            <li>
                                <a data-leftHref="<?php echo request()->module(); ?>/clientall/custom_apply" href="javascript:void(0)"
                                   onclick="closableTab.addTab({'id': '99', 'name': this.innerText, 'url': this.getAttribute('data-leftHref'), 'closable': true});">
                                    <i class="fa fa-fw fa-circle-o"></i>客户审核
                                </a>
                            </li>
                        <?php endif; if($vo['mname'] == '系统管理' and Session('user')->pid == 0): ?> <!-- 判断是否为超级管理员和主机厂 -->
                            <li>
                                <a data-leftHref="<?php echo request()->module(); ?>/admin/setgroup" href="javascript:void(0)"
                                   onclick="closableTab.addTab({'id': '77', 'name': this.innerText, 'url': this.getAttribute('data-leftHref'), 'closable': true});">
                                    <i class="fa fa-fw fa-circle-o"></i><?php if(Session('user')->pid == 0): ?>主机厂<?php endif; ?>管理
                                </a>
                            </li>
                            <?php if(Session('user')->pid == 0): ?>
                                <li>
                                    <a data-leftHref="<?php echo request()->module(); ?>/data/database" href="javascript:void(0)"
                                       onclick="closableTab.addTab({'id': '78', 'name': this.innerText, 'url': this.getAttribute('data-leftHref'), 'closable': true});">
                                        <i class="fa fa-fw fa-circle-o"></i>数据库管理
                                    </a>
                                </li>
                            <?php endif; endif; ?>
                    </ul>
                </li>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </div>
    </nav>
    <div class="content-wrapper content-wrapper-new">
        <!-- Breadcrumbs-->
        <div class="breadcrumb header-tab">
            <div class="header-tab-border"></div>
            <div class="header-tab-item-home header-tab-active">
                <a data-leftHref="<?php echo url('index/main'); ?>" href="javascript:void(0)" onclick="closableTab.addTab({'id': '0', 'name': this.innerText, 'url': this.getAttribute('data-leftHref'), 'closable': true});">首页</a>
            </div>
        </div>
        <div id="iframe-content" class="iframe-content">
            <!--<div class="loading"></div>-->
            <iframe class="all-iframe" frameborder="0" src="<?php echo $url; ?>"></iframe>
        </div>
    </div>


</div>
<script>
    //给首页标签加active
    $('.header-tab-item-home').addClass('header-tab-active');
    //    $('.loading').animate({opacity:'0'},1000);
    //点击首页标签页
    $('.header-tab-item-home, .navbar-brand, .header-icon').click(function () {
        $("iframe").hide();
        $("iframe[src='<?php echo $url; ?>']").show();
        $("div[id^=tab_seed_]").removeClass("li-active");
        $('.header-tab-item-home').addClass('header-tab-active');
    })
    var closableTab = {
        //添加tab
        addTab: function (tabItem) {             //tabItem = {id,name,url,closable}
            if ($('.header-tab').html().indexOf(tabItem.name) == '-1') {        //标签里面没有这个标签，新建标签
                var id = "tab_seed_" + tabItem.id;
                var li_tab = '<div class="header-tab-item" id="' + id + '"><a onclick="closableTab.otherTab(this)" data-id="' + id + '" data-href="/' + tabItem.url + '" href="javascript:void(0)">' + tabItem.name;
                if (tabItem.closable) {
                    li_tab = li_tab + '</a><i class="fa fa-fw fa-close"  data-href="/' + tabItem.url + '" tabclose="' + id + '" onclick="closableTab.closeTab(this)"></i></li>';
                } else {
                    li_tab = li_tab + '</a></div>';
                }
                $('.header-tab').append(li_tab);
                $('.header-tab-item-home').removeClass('header-tab-active');
                $("div[id^=tab_seed_]").removeClass("li-active");
                $("#tab_seed_" + tabItem.id).addClass("li-active");
                closableTab.creatIframe('/' + tabItem.url);
            } else {
                $("div[id^=tab_seed_]").removeClass("li-active");
                $("#tab_seed_" + tabItem.id).addClass("li-active");
                $("iframe").hide();
                $("iframe[src='/" + tabItem.url + "']").show();
            }

        },
        //阻止冒泡
        cancelBubble: function (e) {
            var evt = e ? e : window.event;
            if (evt.stopPropagation) {        //W3C
                evt.stopPropagation();
            } else {       //IE
                evt.cancelBubble = true;
            }
        },
        //关闭tab,关闭iframe
        closeTab: function (obj) {
            closableTab.cancelBubble();
            var val = $(obj).attr('tabclose');
            var dataHref = $(obj).attr('data-href');
            $("#" + val).remove();
            if ($(obj).parent().next().length) { //如果这个标签不处在最后一个
                var href = $(obj).prev().attr('data-href');
                $("iframe[src='" + href + "']").remove();
            } else {
                $(".header-tab-item").last().addClass('li-active');
                $("iframe[src='" + dataHref + "']").eq(0).remove();
                var href = $(".header-tab-item").last().children().eq(0).attr('data-href');
                $("iframe[src='" + href + "']").eq(0).show();
                $(".sidenav-second-level a").parent().removeClass('li-active');
                $(".sidenav-second-level a[data-leftHref='" + href + "']").parent().addClass('li-active');
                if (!$('.header-tab-item').length) { //如果所有的标签都没有了的话
                    $(".sidenav-second-level").removeClass('show');
                    $('.header-tab-item-home').addClass('header-tab-active');
                    $("iframe[src='/boquan/index/main.htm']").show();
                } else {
                    console.log($(".sidenav-second-level a[data-lefthref='" + href + "']").parent().parent().html());
                    return false;
                    // if ($(".sidenav-second-level a[data-lefthref='" + href + "']").parent().parent().html().indexOf(dataHref) == '-1') { //如果最后一个左侧的li 不和 被关闭的li在同一个 class下
                    //     $(".sidenav-second-level").removeClass('show');
                    //     $(".sidenav-second-level a[data-lefthref='" + href + "']").parent().parent().addClass('show');
                    //     $(".sidenav-second-level a[data-lefthref='" + dataHref + "']").parent().parent().parent().removeClass('collapsed');
                    // }
                }
            }
        },
        //创建iframe
        creatIframe: function (href) {
            $('iframe').hide();
            $('#iframe-content').append('<iframe  class="all-iframe" frameborder="0" src=' + href + ' ></iframe>');
        },
        //给首页标签添加样式
        homeTab: function () {
            $('.header-tab-item-home').addClass('header-tab-active');
            if ($("div[id^=tab_seed_]").size() > 0) { //如果这个id的div存在，移除所有active样式
                $("div[id^=tab_seed_]").removeClass("li-active");
            }
        },
        otherTab: function (obj) {
            var href = $(obj).attr('data-href');
            var id = $(obj).attr('data-id');
            $("iframe").hide();
            $("iframe[src='" + href + "']").show();
            $("div[id^=tab_seed_]").removeClass("li-active");
            $('.header-tab-item-home').removeClass('header-tab-active');
            $("#" + id).addClass("li-active");
        }
    }
</script>
</body>
</html>

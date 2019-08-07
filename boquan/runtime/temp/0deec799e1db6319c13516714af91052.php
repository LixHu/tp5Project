<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:69:"F:\zm\my\boquan\public/../application/boquan\view\index\notpower.html";i:1521017812;s:58:"F:\zm\my\boquan\application\boquan\view\public\header.html";i:1520643971;}*/ ?>
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

    <meta charset="UTF-8">
    <title>Title</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
        }
        a{
            text-decoration: none;
            color: #000000;
        }
    </style>
<body>
<div style="position: relative;width: 100%;height: 100vh;background-size: 100% 100vh;background: #ffffff  url(_images/login_bg.png) no-repeat center;">
    <div style="position: absolute;left: 50%;top: 20%;transform: translate(-50%,-50%);padding: 20px;background: rgba(242,242,242,0.6)">您还没有操作权限，您可以申请主机厂或邀请员工</div>
    <a href="javascipt:;" id="app_host" style="position: absolute;left: 30%;top: 50%;transform: translate(-50%,-50%);width: 500px;height: 200px;line-height: 200px;font-size: 40px;text-align: center;background: rgba(249,249,249,0.82)">申请主机厂</a>
    <a href="javascipt:;" id="" style="position: absolute;right: 30%;top: 50%;transform: translate(50%,-50%);width: 500px;height: 200px;line-height: 200px;font-size: 40px;text-align: center;background: rgba(249,249,249,0.82)">邀请员工</a>
</div>
<div id="host_con" style="display:none;">
    <div class="" style="padding:10px;">
        <label class="layui-form-label">请选择要申请的主机厂：</label>
        <div style="padding:10px;">
            <select type="text" class="form-control" name="hostname" id="hostname">
                <option value="">请选择</option>
            <?php if(is_array($glist) || $glist instanceof \think\Collection || $glist instanceof \think\Paginator): $i = 0; $__LIST__ = $glist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <option value="<?php echo $vo['gid']; ?>"><?php echo $vo['gname']; ?></option>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </div>
    </div>
</div>
<script>
    $("#app_host").on('click',function(){
        layer.open({
            type:1,
            title:"申请主机厂",
            shadeClose:false,
            area:['400px','200px'],
            content:$("#host_con"),
            btn:['确定','取消'],
            yes:function(){
                var data = {};
                data.gid = $('#hostname').val();
                $.post('apphost',data,function(res){
                    alert(res.msg);
                    if(res.code == 1){
                        parent.location.reload();
                    }
                })
                return false;
            }
        })
    })
</script>
</body>
</html>
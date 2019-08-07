<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:75:"F:\zm\my\boquan\public/../application/boquan\view\clientall\add_custom.html";i:1521176914;s:58:"F:\zm\my\boquan\application\boquan\view\public\header.html";i:1520643971;s:58:"F:\zm\my\boquan\application\boquan\view\public\footer.html";i:1520643971;}*/ ?>
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
        background-color: #eeeeee;
    }

    .content {
        padding: 0 15px !important;
    }

    .small-box {
        margin-bottom: 0px;
        color: #FFFFFF;
    }

    .table-header-sort {
        cursor: pointer;
        color: black !important;
    }

    .tooltip>.tooltip-inner {
        background-color: #e5e5e5;
        color: #0c0c0c
    }

    .tooltip.top .tooltip-arrow {
        border-top-color: #e5e5e5;
    }

    #wait {
        background: rgba(255, 255, 255, 0.5) url("/resource/images/wait.gif")
        center no-repeat;
        position: fixed;
        width: 100%;
        height: 100%;
        z-index: 9000;
    }

    .dnone {
        display: none;
    }

    [v-cloak] {
        display: none
    }

    .iconfont {
        width: 50px !important;
    }

    .dropdown-menu>li a {
        transition: background-color ease .3s, color ease .3s, border-color ease
        .3s;
    }

    .dropdown-menu>li a:hover {
        background-color: #3c8dbc;
        color: white;
        border-color: #3c8dbc;
    }

    .dropdown-toggle {
        transition: background-color ease .3s, color ease .3s, border-color ease
        .3s;
    }

    .dropdown-toggle:hover {
        background-color: #3c8dbc;
        color: white;
        border-color: #3c8dbc;
    }

    .open .dropdown-toggle {
        background-color: #3c8dbc !important;
        color: white !important;
        border-color: #3c8dbc !important;
    }

    .btn-default1 {
        background-color: #f4f4f4;
        color: #444;
        border-color: #ddd;
    }

    .small-box .icon {
        top: -25px !important;
    }

    .small-box h3 {
        font-size: 30px !important;
        margin: 0 0 10px 0 !important;
        white-space: nowrap !important;
        padding: 0 !important;
        font-weight: normal !important;
    }

    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th,
    .table>thead>tr>td, .table>thead>tr>th {
        line-height: 2.4;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }
</style>
<!--<div class="" id="main">-->
<!--<section class="content" style="min-width: 760px !important;">-->
    <form id="mainForm" method="post"  id="myform">
        <!--<div class="box box-solid">-->
            <!--<div class="box-body">-->
        <div class="col-md-12 form-group" style="clear:both;padding: 10px;">
            <label class="col-md-4 col-sm-3" style="padding: 10px;text-align: right;">
                <span class="text-red">* </span>名称：</label>
            <div class="col-md-8 col-sm-7">
                <input type="text" class="form-control" id="client_name" name="client_name" >
            </div>
        </div>
        <div class="col-md-12 form-group" style="clear:both;">
            <label class="col-md-4 col-sm-3" style="padding: 10px;text-align: right;">
                <span class="text-red">* </span>联系方式：
            </label>
            <div class="col-md-8 col-sm-7" style="padding: 10px;">
                <input type="text" class="form-control" id="client_tel" name="client_tel"
                       onkeyup="this.value=this.value.replace(/\D/g,'')" placeholder="只允许数字" >
            </div>
        </div>
        <input type="hidden" name="id" value="">
        <div class="col-md-12 form-group" style="clear:both;">
            <label class="col-md-4 col-sm-3" style="padding: 10px;text-align: right;">
                <span class="text-red">* </span>联系地址：
            </label>
            <div class="col-md-8 col-sm-7" style="padding: 10px;">
                <input type="text" class="form-control" id="client_address" name="client_address">
            </div>
        </div>
        <div style="clear: both;text-align: right;margin-right:17%;" class="col-md-12 form-group">
            <button type="button" onclick="sub_form()" class="btn btn-primary">确认</button>
            <button type="button" class="btn btn-default">关闭</button>
        </div>
            <!--</div>-->
        <!--</div>-->
    </form>
<!--</section>-->
<!--</div>-->
<script>
    //js验证表单提交方法
    function sub_form(){
        var client_name = $('input[name="client_name"]').val();
        var client_tel = $('input[name="client_tel"]').val();
        var client_address = $('input[name="client_address"]').val();
        if($.trim(client_name) == ''){
            alert('请填写名称');
            return false;
        }
        if($.trim(client_tel) == ''){
            alert('请填写联系方式');
            return false;
        }
        if($.trim(client_address) == ''){
            alert('请填写区域');
            return false;
        }
        var data = {};
        data.client_name = client_name;
        data.client_tel = client_tel;
        data.client_address = client_address;
        $.post('add_custom',data,function (res) {
            console.log(res);
            alert(res.msg);
            if(res.code == 1){
                parent.layer.closeAll();
                parent.location.reload();
            }
        })
    }

</script>
</body>
</html>
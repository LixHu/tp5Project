<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:78:"F:\zm\my\boquan\public/../application/boquan\view\workorder\workorder_all.html";i:1520643971;s:58:"F:\zm\my\boquan\application\boquan\view\public\header.html";i:1520643971;s:58:"F:\zm\my\boquan\application\boquan\view\public\footer.html";i:1520643971;}*/ ?>
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

<script src="_js/jqPaginator.js" type="text/javascript"></script>
<link href="_font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="_css/select2.min.css">
<script src="_js/select2.full.js"></script>
<link href="http://cdn.bootcss.com/bootstrap-daterangepicker/2.1.25/daterangepicker.css" rel="stylesheet"/>
<script src="http://cdn.bootcss.com/bootstrap-daterangepicker/2.1.25/moment.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap-daterangepicker/2.1.25/daterangepicker.js"></script>
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
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

    .tooltip > .tooltip-inner {
        background-color: #e5e5e5;
        color: #0c0c0c
    }

    .tooltip.top .tooltip-arrow {
        border-top-color: #e5e5e5;
    }

    #wait {
        background: rgba(255, 255, 255, 0.5) url("") center no-repeat;

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

    .dropdown-menu > li a {
        transition: background-color ease .3s,
        color ease .3s,
        border-color ease .3s;
    }

    .dropdown-menu > li a:hover {
        background-color: #3c8dbc;
        color: white;
        border-color: #3c8dbc;
    }

    .dropdown-toggle {
        transition: background-color ease .3s,
        color ease .3s,
        border-color ease .3s;
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

    .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
        line-height: 2.4;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }
</style>
<div class="" id="main">
    <section class="content" style="min-width: 760px !important;">
        <div class="">
            <form id="mainForm" method="get" class="nice-validator n-default n-bootstrap"
                  novalidate="novalidate">
                <!--搜索条件-->
                <!--<div class="box box-solid">-->
                <!--<div class="box-body">-->
                <!--<div id="vue" class="row">-->
                <!--<div class="col-sm-12">-->
                <!--<div class="col-md-3 col-sm-6 col-xs-6">-->
                <!--<div class="small-box bg-blue2">-->
                <!--<div class="inner"><h3>0</h3>-->
                <!--<p>待接受工单</p></div>-->
                <!--<div class="icon">-->
                <!--<img src="_images/new/workOrderIcon.png" alt="" class="index-card-bg-img"/>-->
                <!--</div>-->
                <!--</div>-->
                <!--</div>-->
                <!--<div class="col-md-3 col-sm-6 col-xs-6">-->
                <!--<div class="small-box bg-red2">-->
                <!--<div class="inner"><h3>0</h3>-->
                <!--<p>超过1天的工单</p></div>-->
                <!--<div class="icon">-->
                <!--<img src="_images/new/workOrderIcon.png" alt="" class="index-card-bg-img"/>-->
                <!--</div>-->
                <!--</div>-->
                <!--</div>-->
                <!--</div>-->
                <!--</div>-->
                <!--</div>-->
                <!--</div>-->
                <div class="box box-solid">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6 col-sm-6"></div>
                            <div class="col-md-6 col-sm-6">
                                <div class="input-group">
                                    <input type="text" class="form-control keyword-search criteria"
                                           placeholder="请输入工单编号" v-model="wo_sn" id="keyword" name="keyword"
                                           maxlength="50">
                                    <span class="input-group-btn">
                                            <button class="btn btn-primary" type="button" id="btnSearch"
                                                    @click="search">搜 索</button>
                                            <button type="button" class="btn btn-default btnReset"
                                                    style="margin-left: 5px;" value="重置" @click="reset">重 置</button>
                                        </span>
                                    <span class="input-group-btn">
                                            <input id="isAdvanced" name="isAdvanced" value="1" type="hidden"
                                                   class="criteria">
                                            <!--<a class="btn" role="button" data-toggle="collapse" href="#collapseExample"-->
                                               <!--id="advanceIcon" aria-expanded="true">-->
                                                    <!--<span class="glyphicon glyphicon-plus"></span>-->
                                                <!--高级搜索-->
                                            <!--</a>-->
                                        </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box box-solid collapse" id="collapseExample" aria-expanded="true">
                    <div class="box-header with-border"><span style="font-weight: bold">高级搜索</span></div>
                    <div class="box-body">
                        <!--<div class="row">-->
                            <!--<div class="col-md-5 col-sm-6 form-group">-->
                                <!--<div class="input-group">-->
                                        <!--<span class="input-group-btn">-->
                                            <!--<span class="btn span-default no-padding"-->
                                                  <!--style="cursor:default;width: 90px;">客户/报修人：</span>-->
                                        <!--</span>-->
                                    <!--<select style="width: 100%" id="customerId" name="customerId" tabindex="-1"-->
                                            <!--class="select2-hidden-accessible" aria-hidden="true">-->
                                        <!--<option value="" selected=""></option>-->
                                    <!--</select>-->
                                <!--</div>-->
                            <!--</div>-->
                            <!--<div class="col-md-5 col-sm-6 form-group">-->
                            <!--<div class="input-group">-->
                            <!--<span class="input-group-btn">-->
                            <!--<span class="btn span-default no-padding"-->
                            <!--style="cursor:default;width: 90px;">服务类型：</span>-->
                            <!--</span>-->
                            <!--<select class="form-control criteria" id="serviceType" name="serviceType" v-model="server_type">-->
                            <!--<option value="">全部</option>-->
                            <!--<option value="保内免费">保内免费</option>-->
                            <!--<option value="保内收费">保内收费</option>-->
                            <!--<option value="保外免费">保外免费</option>-->
                            <!--<option value="保外收费">保外收费</option>-->
                            <!--</select>-->
                            <!--</div>-->
                            <!--</div>-->
                            <!--<div class="col-md-5  col-sm-6 form-group">-->
                            <!--<div class="input-group">-->
                            <!--<span class="input-group-btn">-->
                            <!--<span class="btn span-default no-padding"-->
                            <!--style="cursor:default;width: 90px;">服务内容：</span>-->
                            <!--</span>-->
                            <!--<select class="form-control criteria" id="serviceContent" name="serviceContent">-->
                            <!--<option value="">全部</option>-->
                            <!--<option value="安装">安装</option>-->
                            <!--<option value="维修">维修</option>-->
                            <!--<option value="保养">保养</option>-->
                            <!--<option value="巡检">巡检</option>-->
                            <!--<option value="检查">检查</option>-->
                            <!--</select>-->
                            <!--</div>-->
                            <!--</div>-->
                            <div class="col-md-5  col-sm-6 form-group">
                                <div class="input-group">
                                            <span class="input-group-btn">
                                                <span class="btn span-default no-padding"
                                                      style="cursor:default;width: 90px;">优先级：</span>
                                            </span>
                                    <select class="form-control criteria" v-model="pid" name="level">
                                        <option value="">全部</option>
                                        <option value="2">中</option>
                                        <option value="1">低</option>
                                        <option value="3">高</option>
                                    </select>
                                </div>
                            </div>
                            <!--<div class="col-md-5 col-sm-6 form-group">-->
                                <!--<div class="input-group">-->
                                        <!--<span class="input-group-btn">-->
                                            <!--<span class="btn span-default no-padding"-->
                                                  <!--style="cursor:default;width: 90px;">创建人：</span>-->
                                        <!--</span>-->
                                    <!--<select style="width: 100%" id="createUser" name="createUser" tabindex="-1"-->
                                            <!--class="select2-hidden-accessible" aria-hidden="true">-->
                                        <!--<option value=""></option>-->
                                        <!--<option value="" selected=""></option>-->
                                    <!--</select>-->
                                    <script>
                                    </script>
                                <!--</div>-->
                            <!--</div>-->
                            <!--<div class="col-md-5 col-sm-6 form-group">-->
                                <!--<div class="input-group">-->
                                        <!--<span class="input-group-btn">-->
                                            <!--<span class="btn span-default no-padding"-->
                                                  <!--style="cursor:default;width: 90px;">派单人：</span>-->
                                        <!--</span>-->
                                    <!--<select style="width: 100%" id="allotUser" name="allotUser" tabindex="-1"-->
                                            <!--class="select2-hidden-accessible" aria-hidden="true">-->
                                        <!--<option value="" selected=""></option>-->
                                    <!--</select>-->
                                <!--</div>-->
                            <!--</div>-->
                            <!--<div class="col-md-5 col-sm-6 form-group">-->
                            <!--<div class="input-group">-->
                            <!--<span class="input-group-btn">-->
                            <!--<span class="btn span-default no-padding"-->
                            <!--style="cursor:default;width: 90px;">工单状态：</span>-->
                            <!--</span>-->
                            <!--<select style="width: 100%" id="workOrderStatus" class=" form-control criteria">-->
                            <!--<option value="">全部</option>-->
                            <!--<option value="2">待指派</option>-->
                            <!--<option value="2">已指派</option>-->
                            <!--<option value="2">已接受</option>-->
                            <!--<option value="2">已完成</option>-->
                            <!--</select>-->
                            <!--</div>-->
                            <!--</div>-->
                            <div class="col-md-5 col-sm-6 form-group">
                                <div class="input-group">
                                  <span class="input-group-btn">
                                    <span class="btn span-default no-padding"
                                          style="cursor:default;width: 90px;">创建时间：</span>
                                  </span>
                                    <input type="text" class="form-control criteria" placeholder="请输入创建时间"
                                           name="createtime" value="" id="createtime"  readonly
                                           maxlength="50">
                                </div>
                            </div>
                            <div class="pull-right" style="padding-right: 20px">

                                <button type="button" class="btn btn-primary" @click="getData()">确定
                                </button>
                                <a class="btn btn-default" style="margin-left: 2px"
                                   href="javascript:;" @click="reset">重置</a>
                            </div>
                        </div>
                    </div>

                <div class="box box-solid">
                    <div class="box-body">
                        <div class="btn-group" id="auth_delete">
                            <a class="btn btn-default btn-sm" onclick="deleteWorkTask()"><i
                                    class="glyphicon glyphicon-trash"></i>&nbsp;&nbsp;删除</a>
                        </div>
                    </div>
                </div>

                <div class="box box-solid">
                    <div class="box-body no-padding">
                        <div class="table-responsive list">
                            <table class="table table-hover table-striped table-bordered" id="taskTable">
                                <thead>
                                <tr>
                                    <th><input type="checkbox" name="checkAll" id="checkSelect" value="全选"></th>
                                    <th>工单编号</th>
                                    <th id="tour_1" name="taskCustomer">报修人</th>
                                    <th name="taskCustomerLinkmanPhone">联系方式</th>
                                    <th name="taskCustomerAddress">地点</th>
                                    <!--<th name="taskProduct">服务类型</th>-->
                                    <th name="taskPlanTime">发动机匹配厂家</th>
                                    <!--<th name="taskLevel">-->
                                    <!--<a href="javascript:;" class="table-header-sort"-->
                                    <!--onclick="orderTask(this)" data-name="sortBy[level]"-->
                                    <!--name="level" data-sort="false">优先级&nbsp;-->
                                    <!--<i class="fa fa-sort"></i>-->
                                    <!--</a>-->
                                    <!--</th>-->
                                    <th name="taskServiceType">创建人</th>
                                    <th name="taskServiceContent"><a href="javascript:;" class="table-header-sort"
                                                                     onclick="orderTask(this)"
                                                                     data-name="sortBy[level]"
                                                                     name="level" data-sort="false">创建时间&nbsp;<i
                                            class="fa fa-sort"></i></a></th>
                                    <th name="taskAllotTime">工单状态</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <div class="loading" v-show="loading"></div>
                                <tr v-for="item in workorder">
                                    <td><input type="checkbox" class="checkSelect" name="checkSelect"
                                               :value="item.wo_id"></td>
                                    <td>
                                        <a :href="item.url">{{item.wo_sn}}</a>
                                    </td>
                                    <td>{{item.jour_name}}</td>
                                    <td>{{item.contact_info}}</td>
                                    <td>
                                        {{item.address}}
                                    </td>
                                    <!--<td name="taskServiceType">-->
                                    <!--<span v-if="item.server_type == 1">保内免费</span>-->
                                    <!--<span v-if="item.server_type == 2">保内收费</span>-->
                                    <!--<span v-if="item.server_type == 3">保外免费</span>-->
                                    <!--<span v-if="item.server_type == 4">保外收费</span>-->
                                    <!--</td>-->
                                    <td>{{item.math_ven}}</td>
                                    <!--<td name="taskLevel">-->
                                    <!--<span v-if="item.pid == 1">低</span>-->
                                    <!--<span v-if="item.pid == 2">中</span>-->
                                    <!--<span v-if="item.pid == 3">高</span>-->
                                    <!--</td>-->
                                    <td name="taskCreateUser">
                                        <a href="">{{item.add_name}}</a>
                                    </td>
                                    <td name="taskCreateTime">{{item.add_time}}</td>
                                    <td name="taskAllotTime">
                                        <span class="label " style="background-color: #69b5f0">
                                            {{item.status}}
                                        </span></td>
                                    <td>
                                        <button type="button" class="btn btn-small btn-primary"
                                                @click="dispath(item.wo_id)">派单
                                        </button>
                                    </td>
                                </tr>
                                <tr v-show="workorder.length == 0">
                                    <td colspan="19" style="text-align: center;">未找到相关数据</td>
                                </tr>
                                </tbody>
                            </table>
                        </div><!-- /.mail-box-messages -->
                    </div><!-- /.box-body -->
                    <div class="box-footer ">
                        <div class="col-lg-4 ">共 {{count}} 条记录&nbsp; 共 {{countpage}} 页 &nbsp; &nbsp;每页显示
                            <select id="sizeSelect" v-model="pagesize" @change="getData()">
                                <option value="1" selected="">1</option>
                                <option value="10" selected="">10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                            </select>条
                        </div>
                        <div class="col-lg-8" style="float: right;text-align: left;">
                            <div id="vue-dingyi-paging">
                                <ul>
                                    <li>
                                        <a class="pageLink" href="#" @click="setPage(page-1)">
                                            <</a>
                                    </li>
                                    <li v-for="n in countpage">
                                        <a class="pageLink" href="#" v-text="n" @click="setPage(n)" :class="{ curPage: n+1 == page }"></a>
                                    </li>
                                    <li><a class="pageLink" href="#" @click="setPage(page+1)">></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
</body>
</html>
<script>
    //分页
    $(document).ready(function () {
        //工单池版块选择时间
        $('#createtime').daterangepicker({
            applyClass: "btn-primary",
            locale: {
                format: 'YYYY-MM-DD',
                applyLabel: '确定',
                applyClass: "btn-primary",
                cancelLabel: '取消',
                fromLabel: '开始',
                toLabel: '结束',
                daysOfWeek: '日_一_二_三_四_五_六'.split('_'),
                monthNames: '1月_2月_3月_4月_5月_6月_7月_8月_9月_10月_11月_12月'.split('_'),
            },
            startDate: moment().subtract(6, 'days'),
            endDate: moment()
        });
        //点击高级搜索
        $("#advanceIcon").click(function () {
            if ($(this).children("span").attr("class") == "glyphicon glyphicon-plus") {
                //关闭
                $(this).children("span").removeClass("glyphicon-plus");
                $(this).children("span").addClass("glyphicon-minus");
                $('#isAdvanced').val(1);
            } else if ($(this).children("span").attr("class") == "glyphicon glyphicon-minus") {
                //展开
                $(this).children("span").removeClass("glyphicon-minus");
                $(this).children("span").addClass("glyphicon-plus");
                $('#isAdvanced').val(0);
            }
        });


        function orderTask(ele) {
            $("#sortSeachModel").attr("name", ele.dataset.name);
            if (ele.dataset.sort == 'true') {
                $("#sortSeachModel").val("false");
            } else if (ele.dataset.sort == 'false') {
                $("#sortSeachModel").val("true");
            }
            console.log($("#sortSeachModel"));
            $("#mainForm").trigger('submit');
        }

        $(".btnReset").click(function () {
            $("#collapseExample input").val("");
            $("#name").val("");
            $("#state").val("");
            showWait();
        });
        ////以上是高级搜索 调用的方法


        ////以下是复选框的选中
        $("#checkSelect").change(function () {
            if ($(this).is(':checked')) {
                $("input[name='checkSelect']").prop("checked", "checked");
            } else {
                $("input[name='checkSelect']").removeAttr("checked");
            }
        });
        $("input[name='checkSelect']").change(function () {
            var flag = true;
            $("input[name='checkSelect']").each(function () {
                if (!$(this).is(':checked')) {
                    flag = false;
                    return false;
                }
            });
            if (flag) {
                $("#checkSelect").prop("checked", "checked");
            } else {
                $("#checkSelect").removeAttr("checked");
            }
        });
        ////以上是复选框的选中
    })
    var vue = new Vue({
        el: "#main",
        data: {
            wo_sn: '',
            page: 1,
            count: 0,
            countpage: 0,       // 总页数
            server_type: '',
            pagesize: 10,
            workorder: [],
            loading: true,
            pid:''
        },
        methods: {
            search: function () {
                this.getData();
            },
            reset: function () {
                this.wo_sn = '';
                this.getData();
            },
            getData: function () {
                var $this = this;
                var data = {};
                data.status = 1;
                data.wo_sn = this.wo_sn;
                data.server_type = this.server_type;
                data.page = this.page;
                data.pagesize = this.pagesize;
                data.pid = this.pid;
                // data.createtime = $("#createtime").val();
                $this.loading = true;
                $.post('getWorkList', data, function (res) {
                    if (res.code == 1) {
                        console.log(res.data);
                        $this.count = res.count;
                        $this.countpage = res.countpage;
                        $this.workorder = res.data;   // 数据
                    } else {
                        //暂无数据
                        $this.count = 0;
                        $this.countpage = 0;
                        $this.workorder = [];
                    }
                    $this.loading = false;
                })
            },
            take_order: function (wo_id) {
                var $this = this,
                    data = {};
                data.wo_id = wo_id;
                $.post('set_take', data, function (res) {
                    alert(res.msg);
                    $this.getData();
                });
            },
            setPage: function(num) {
                //页码小于等于1
                console.log(num);
                if (num <= 1) {
                    this.page = 1;
                    this.getData();
                    return false;
                }
                //页码大于总页数
                if (num >= this.countpage) {
                    this.page = this.countpage;
                    this.getData();
                    return false;
                }
                //页码赋给当前页
                this.page = num;
                this.getData();
            },
            dispath: function (wo_id) {
                //跳转到 派单地址
                location.href = "/boquan/workorder/dispath?wid=" + wo_id;
            }
        }
    })
    vue.getData();
</script>
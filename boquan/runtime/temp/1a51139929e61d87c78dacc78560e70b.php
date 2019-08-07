<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:65:"F:\zm\my\boquan\public/../application/boquan\view\index\main.html";i:1521003454;s:58:"F:\zm\my\boquan\application\boquan\view\public\header.html";i:1520643971;s:58:"F:\zm\my\boquan\application\boquan\view\public\footer.html";i:1520643971;}*/ ?>
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
        padding: 0 30px;
    }
    .nav-tabs .nav-link {
        position: relative;
        border: 0;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
        color: #363d47;
        font-size: 18px;
        padding: .5rem 1rem .5rem 0;
    }

    .nav-tabs {
        border-bottom: 0;
        margin-top: 15px;
    }

    .tab-content {
        height: calc(100vh - 79px);
    }

    .nav-tabs .active span {
        position: absolute;
        top: 0px;
        width: 72px;
        height: 2px;
        background: #27a9e6;
    }

    .nav-tabs > li > a:hover {
        border-color: #ffffff;
    }

    .nav > li > a:focus, .nav > li > a:hover {
        border-color: #ffffff;
    }

    .nav > li > a:focus, .nav > li > a:hover {
        background-color: #ffffff;
    }

    .nav-tabs > li.active > a, .nav-tabs > li.active > a:focus, .nav-tabs > li.active > a:hover {
        border: 0;
    }

    .bg-blue {
        background-color: #23a7f1 !important;
    }
</style>
<link href="http://cdn.bootcss.com/bootstrap-daterangepicker/2.1.25/daterangepicker.css" rel="stylesheet"/>
<script src="http://cdn.bootcss.com/bootstrap-daterangepicker/2.1.25/moment.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap-daterangepicker/2.1.25/daterangepicker.js"></script>
<ul id="myTab" class="nav nav-tabs">
    <li class="nav-item active"><a class="nav-link" data-toggle="tab" href="#serviceStatistics"> <span></span> 服务统计 </a>
    </li>
    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#dynamicUpdate"> <span></span> 动态更新 </a></li>
    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#myWorkOrder"> <span></span> 我的工单 </a></li>
</ul>
<div id="myTabContent" class="tab-content">
    <div class="tab-pane fade in active" id="serviceStatistics">
        <div class="row" style="margin:20px 0 0 0;">
            <div class="col-xl-2-5 col-sm-6 mb-3">
                <div class="card text-white bg-red o-hidden h-100">
                    <div class="index-card-bg">
                        <img src="_images/stay.png" alt="" class="index-card-bg-img"/>
                    </div>
                    <div class="index-card-text">
                        <div class="index-card-num">
                            <?php echo $info['custom']; ?>
                        </div>
                        <div class="index-card-type">
                            接入客户
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2-5 col-sm-6 mb-3">
                <div class="card text-white bg-yellow o-hidden h-100">
                    <div class="index-card-bg">
                        <img src="_images/not.png" alt="" class="index-card-bg-img"/>
                    </div>
                    <div class="index-card-text">
                        <div class="index-card-num">
                            <?php echo $info['notcomple']; ?>
                        </div>
                        <div class="index-card-type">
                            未完成工单
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2-5 col-sm-6 mb-3">
                <div class="card text-white bg-green o-hidden h-100">
                    <div class="index-card-bg">
                        <img src="_images/not1.png" alt="" class="index-card-bg-img"/>
                    </div>
                    <div class="index-card-text">
                        <div class="index-card-num">
                            <?php echo $info['todaycomple']; ?>
                        </div>
                        <div class="index-card-type">
                            今日完成工单
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2-5 col-sm-6 mb-3">
                <div class="card text-white bg-blue o-hidden h-100">
                    <div class="index-card-bg">
                        <img src="_images/confirm.png" alt="" class="index-card-bg-img"/>
                    </div>
                    <div class="index-card-text">
                        <div class="index-card-num">
                            <?php echo $info['price']; ?>
                        </div>
                        <div class="index-card-type">
                            今日营收
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2-5 col-sm-6 mb-3">
                <div class="card text-white bg-orange">
                    <div class="index-card-bg">
                        <img src="_images/praise.png" alt="" class="index-card-bg-img"/>
                    </div>
                    <div class="index-card-text">
                        <div class="index-card-num">
                            <?php echo $info['satisfaction']; ?>
                        </div>
                        <div class="index-card-type">
                            近30天好评
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="index-title">
            工单状态统计
        </div>
        <div class="row" style="margin:20px 0;">
            <div class="col-xl-2-5 col-sm-6 mb-3 index-statistics">
                <div class="bg-fafafa o-hidden text-center index-statistics-bg">
                    <div class="index-statistics-text">
                        全部工单
                    </div>
                    <div class="index-statistics-num">
                        <?php echo $info['all_work']; ?>
                    </div>
                </div>
                <span class="index-statistics-icon hidden-xs">&gt;</span>
            </div>
            <div class="col-xl-2-5 col-sm-6 mb-3 index-statistics">
                <div class="bg-fafafa o-hidden text-center index-statistics-bg">
                    <div class="index-statistics-text">
                        待指派
                    </div>
                    <div class="index-statistics-num">
                        <?php echo $info['stay_zp']; ?>
                    </div>
                </div>
                <span class="index-statistics-icon hidden-xs">&gt;</span>
            </div>
            <div class="col-xl-2-5 col-sm-6 mb-3 index-statistics">
                <div class="bg-fafafa o-hidden text-center index-statistics-bg">
                    <div class="index-statistics-text">
                        已指派
                    </div>
                    <div class="index-statistics-num">
                        <?php echo $info['already_zp']; ?>
                    </div>
                </div>
                <span class="index-statistics-icon hidden-xs">&gt;</span>
            </div>
            <div class="col-xl-2-5 col-sm-6 mb-3 index-statistics">
                <div class="bg-fafafa o-hidden text-center index-statistics-bg">
                    <div class="index-statistics-text">
                        已接受
                    </div>
                    <div class="index-statistics-num">
                        <?php echo $info['already_js']; ?>
                    </div>
                </div>
                <span class="index-statistics-icon hidden-xs">&gt;</span>
            </div>
            <div class="col-xl-2-5 col-sm-6 mb-3 index-statistics">
                <div class="bg-fafafa o-hidden text-center index-statistics-bg">
                    <div class="index-statistics-text">
                        已完成
                    </div>
                    <div class="index-statistics-num">
                        <?php echo $info['comple']; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="index-title">
            工单趋势图
        </div>
        <div class="pull-right" style="margin-right: 50px;">
            <div class="input-group">
                <button type="button" class="btn btn-default pull-right" id="daterange-btn"><i
                        class="fa fa-calendar"></i> <span>时间</span> <i class="fa fa-caret-down"></i></button>
            </div>
        </div>
        <div id="serviceStatisticsChart" style="width: 100%;height:400px;margin-top: 30px;margin-bottom: 70px;"></div>
        <!--<div class="index-title">-->
            <!--服务人员工单统计-->
        <!--</div>-->
        <!--<table id="task-table" class="table table-select  table-striped table-bordered"-->
               <!--style="table-layout: fixed; margin:30px 0 50px 0;">-->
            <!--<thead>-->
            <!--<tr class="active">-->
                <!--<th>服务人员</th>-->
                <!--<th>未完成 <i value="allocatedCount" class="fa fa-caret-up active"></i> <i value="allocatedCount"-->
                                                                                        <!--class="fa fa-caret-down"></i>-->
                <!--</th>-->
                <!--<th>今日完成 <i value="allocatedCount" class="fa fa-caret-up"></i> <i value="allocatedCount"-->
                                                                                  <!--class="fa fa-caret-down"></i></th>-->
                <!--<th>本周完成 <i value="allocatedCount" class="fa fa-caret-up"></i> <i value="allocatedCount"-->
                                                                                  <!--class="fa fa-caret-down"></i></th>-->
                <!--<th>本月完成 <i value="allocatedCount" class="fa fa-caret-up"></i> <i value="allocatedCount"-->
                                                                                  <!--class="fa fa-caret-down"></i></th>-->
                <!--<th>本月营收 <i value="allocatedCount" class="fa fa-caret-up"></i> <i value="allocatedCount"-->
                                                                                  <!--class="fa fa-caret-down"></i></th>-->
                <!--<th>客户好评 <i value="allocatedCount" class="fa fa-caret-up"></i> <i value="allocatedCount"-->
                                                                                  <!--class="fa fa-caret-down"></i></th>-->
                <!--<th>客户差评 <i value="allocatedCount" class="fa fa-caret-up"></i> <i value="allocatedCount"-->
                                                                                  <!--class="fa fa-caret-down"></i></th>-->
            <!--</tr>-->
            <!--</thead>-->
            <!--<tbody>-->
            <!--<tr>-->
                <!--<td><a href="javascript:;">晓华</a></td>-->
                <!--<td>1</td>-->
                <!--<td>0</td>-->
                <!--<td>1</td>-->
                <!--<td>1</td>-->
                <!--<td>123.00</td>-->
                <!--<td>9</td>-->
                <!--<td>0</td>-->
            <!--</tr>-->
            <!--<tr>-->
                <!--<td><a href="javascript:;">晓华</a></td>-->
                <!--<td>1</td>-->
                <!--<td>0</td>-->
                <!--<td>1</td>-->
                <!--<td>1</td>-->
                <!--<td>123.00</td>-->
                <!--<td>9</td>-->
                <!--<td>0</td>-->
            <!--</tr>-->
            <!--<tr>-->
                <!--<td><a href="javascript:;">晓华</a></td>-->
                <!--<td>1</td>-->
                <!--<td>0</td>-->
                <!--<td>1</td>-->
                <!--<td>1</td>-->
                <!--<td>123.00</td>-->
                <!--<td>9</td>-->
                <!--<td>0</td>-->
            <!--</tr>-->
            <!--<tr>-->
                <!--<td><a href="javascript:;">晓华</a></td>-->
                <!--<td>1</td>-->
                <!--<td>0</td>-->
                <!--<td>1</td>-->
                <!--<td>1</td>-->
                <!--<td>123.00</td>-->
                <!--<td>9</td>-->
                <!--<td>0</td>-->
            <!--</tr>-->
            <!--<tr>-->
                <!--<td>暂无数据</td>-->
                <!--<td>暂无数据</td>-->
                <!--<td>暂无数据</td>-->
                <!--<td>暂无数据</td>-->
                <!--<td>暂无数据</td>-->
                <!--<td>暂无数据</td>-->
                <!--<td>暂无数据</td>-->
                <!--<td>暂无数据</td>-->
            <!--</tr>-->
            <!--</tbody>-->
        <!--</table>-->
    </div>
    <div class="tab-pane fade" id="dynamicUpdate">
        <div class="tab-content">
            <div id="tab_record" class="tab-pane tab-pane-supply active">
                <div class="tab-pane-wrap" style="padding: 20px 0px 20px;">
                    <div class="col-lg-8 col-md-8">
                        <div class="mailbox-controls" style="position: absolute; top: -4px; left: 100px; z-index: 100;">
                            <!--<div class="btn-group">-->
                            <!--<ul class="list-inline" style="position: relative; top: 4px;">-->
                            <!--<li><a href="javascript:;" filter="0" class="btn-filter text-sm active"> 全部</a></li>-->
                            <!--<li><a filter="1" href="javascript:;" class="btn-filter text-sm"> 工单备注</a></li>-->
                            <!--<li><a filter="3" href="javascript:;" class="btn-filter text-sm"> 工单日志</a></li>-->
                            <!--<li><a filter="2" href="javascript:;" class="btn-filter text-sm"> 所有位置</a></li>-->
                            <!--</ul>-->
                            <!--</div>-->
                            <div class="btn-group" style="position: relative;">
                                <input type="text" placeholder="按时间筛选" name="createTime" readonly="readonly" value=""
                                       id="createTime" maxlength="50" class="form-control criteria active"
                                       style="width: 200px;" />

                            </div>
                            <div class="btn-group" style="position: relative; top: 4px;">
                                <ul class="list-inline">
                                    <li><a @click="astime" href="javascript:;" id="btnActiveMessageSearch"
                                           class="text-sm">&nbsp;&nbsp;查询</a></li>
                                    <!--<li><a onclick="exportMyRecord();" href="javascript:;" id="btnExportMyRecord"-->
                                           <!--class="text-sm">&nbsp;&nbsp;导出</a></li>-->
                                </ul>
                            </div>
                            <div class="btn-group" style="position: relative; top: 4px;"></div>
                        </div>
                        <ul id="timeline" class="timeline">
                            <li class="time-label"><span id="lastTime" class="bg-red"> 最近更新 </span></li>
                            <li v-for="item in work_log"><i class="fa fa-bell-o bg-blue"></i>
                                <div class="timeline-item">
                                    <span class="time"><i class="fa fa-clock-o"></i>{{item.add_time}}</span>
                                    <h5 class="timline-header"></h5>
                                    <p style="font-size: 14px; white-space: pre-line;word-break: break-all;">
                                        {{item.desc}}
                                        <!--<br/>协同人：蔡婷婷，丁浩，李筱雪，李亚云-->
                                    </p>
                                    <div class="timeline-body"></div>
                                </div>
                            </li>
                        </ul>
                        <div id="divLoadMore" class="box-footer clearfix text-center"
                             style="border-top-width: 0px; padding: 0px 10px 10px; display: block;" v-show="last == ''">
                            <a href="javascript:void(0);" id="loadMore" @click="load_all" class="uppercase">加载更多</a>
                        </div>

                        <div id="noData" class="col-md-12" v-show="last">
                            <div class="box box-solid">
                                <div class="box-body"></div>
                                <div class="overlay text-center">
                                    已经是最后一页了
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <!--<div id="dynamicUpdateChartTop" style="width: 100%;height:300px;"></div>-->
                        <!--<div id="dynamicUpdateChartDown" style="width: 100%;height:300px;margin-top: 30px;"></div>-->
                    </div>
                </div>
                <div id="loading" class="col-md-8" style="display: none;"></div>

            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="myWorkOrder">
        <div class="col-lg-8 col-md-4" style="margin-top: 20px;">
            <div id="tab_task" class="tab-pane tab-pane-supply active">
                <table id="table_tk_content" class="table table-hover">
                    <thead>
                    <tr class="active">
                        <th>工单编号</th>
                        <th>客户</th>
                        <th>工单状态</th>
                        <th>计划时间</th>
                        <th>完成时间</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in my_work">
                        <td><a href="javascript:;">{{item.wo_sn}}</a></td>
                        <td>{{item.jour_name}}</td>
                        <td>{{item.status}}</td>
                        <td>{{item.plan_time}}</td>
                        <td>{{item.comple_time}}</td>
                    </tr>
                    </tbody>
                </table>
                <a href="javascript:;" class="showall" @click="get_all" v-show="is_all_show">显示全部</a>
            </div>
        </div>
        <div class="col-lg-4 col-md-4">
            <!--<div id="myWorkOrderChartTop" style="width: 100%;height:300px;"></div>-->
            <!--<div id="myWorkOrderChartDown" style="width: 100%;height:300px;margin-top: 30px;"></div>-->
        </div>


    </div>
</div>
<script>
    var content = new Vue({
        el:"#myTabContent",
        data:{
            work_log:[],
            page:1,
            last:'',
            data:{},
            is_all:2,
            is_all_show:true,
            my_work:[]
        },
        methods:{
            getStatus:function(){
                this.data = {'currpage':this.page};
                this.getlogdata();
            },
            load_all:function(){
                this.page++;
                this.getStatus();
            },
            get_all:function(){
                this.is_all = 1;
                this.is_all_show = false;
                this.getMyWork();
            },
            astime:function(){
                this.work_log = [];
                this.page = 1;
                this.data.time = $('#createTime').val();
                this.getlogdata();
            },
            getlogdata:function(){
                var _self = this;
                $.post('getworkstatus',_self.data,function(res){
                    if (res.code == 1){
                        _self.work_log.push.apply(_self.work_log,res.data);
                    }else{
                        _self.last = 1;
                    }
                })
            },
            getMyWork:function(){
                var $this = this,
                    data = {};
                data.is_all = this.is_all;
                $.post('getMyWork',data,function(res){
                    $this.my_work = res;
                })
            }
        }
    });
    localStorage.setItem('work','');
    content.getStatus();
    content.getMyWork();
    $(document).ready(function () {
        serviceStatisticsFun();
    });
    //解决tab切换前图表未获得宽度导致100%变成100px的情况
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        // 获取已激活的标签页的名称
        var activeTab = $(e.target)[0].hash;
        if (activeTab == "#serviceStatistics") {
            serviceStatisticsFun();
        }
        if (activeTab == "#dynamicUpdate") {
            dynamicUpdateChartTopFun();
            dynamicUpdateChartDownFun();
        }
        if (activeTab == "#myWorkOrder") {
            myWorkOrderChartTopFun();
            myWorkOrderChartDownFun();
        }
    });
    //服务统计版块时间段选择，用于图表
    function serviceStatisticsFun() {
        //定义locale汉化插件
        var locale = {
            "format": 'YYYY-MM-DD',
            "separator": " -222 ",
            "applyLabel": "确定",
            "cancelLabel": "取消",
            "fromLabel": "起始时间",
            "toLabel": "结束时间'",
            "customRangeLabel": "自定义",
            "weekLabel": "W",
            "daysOfWeek": ["日", "一", "二", "三", "四", "五", "六"],
            "monthNames": ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
            "firstDay": 1
        };
        //初始化显示最近7日时间
        $('#daterange-btn span').html(moment().subtract(6, 'days').format('YYYY-MM-DD') + ' - ' + moment().format('YYYY-MM-DD'));
        //把获取到的日期放到getAll里面获得这个时间段内所有的时间，用chart转化
        serviceStatisticsChartFun(getAll($('#daterange-btn span').html().split(' - ')[0], $('#daterange-btn span').html().split(' - ')[1]));
        //日期控件初始化
        $('#daterange-btn').daterangepicker({
                'locale': locale,
                applyClass: "btn-primary",
                //汉化按钮部分
                ranges: {
                    '今日': [moment(), moment()],
                    '昨日': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    '最近7日': [moment().subtract(6, 'days'), moment()],
                    '最近30日': [moment().subtract(29, 'days'), moment()],
                    '本月': [moment().startOf('month'), moment().endOf('month')],
                    '上月': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                startDate: moment().subtract(6, 'days'),
                endDate: moment()
            },
            function (start, end) {
                $('#daterange-btn span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
                serviceStatisticsChartFun(getAll(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD')));
            }
        );
    };
    //动态更新版块选择时间
    $('#createTime').daterangepicker({
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
    Date.prototype.format = function () {
        var s = '';
        var mouth = (this.getMonth() + 1) >= 10 ? (this.getMonth() + 1) : ('0' + (this.getMonth() + 1));
        var day = this.getDate() >= 10 ? this.getDate() : ('0' + this.getDate());
        s += this.getFullYear() + '-'; // 获取年份。
        s += mouth + "-"; // 获取月份。
        s += day; // 获取日。
        return (s); // 返回日期。
    };
    //获得时间段内所有的时间
    function getAll(begin, end) {
        var ab = begin.split("-");
        var ae = end.split("-");
        var db = new Date();
        db.setUTCFullYear(ab[0], ab[1] - 1, ab[2]);
        var de = new Date();
        de.setUTCFullYear(ae[0], ae[1] - 1, ae[2]);
        var unixDb = db.getTime();
        var unixDe = de.getTime();
        var all = '';
        for (var k = unixDb; k <= unixDe;) {
            all += "," + new Date(parseInt(k)).format();
            k = k + 24 * 60 * 60 * 1000;
        }
        if (all.indexOf(",") == 0) {
            all = all.substring(1);
        }
        return all;
    }
    //服务统计图表
    function serviceStatisticsChartFun(xAxisData) {
        var xAxisD = [];
        if (xAxisData.indexOf(',') > 0) {
            xAxisD = xAxisData.split(',');
        } else {
            xAxisD.push(xAxisData);
        }
        // 基于准备好的dom，初始化echarts实例
        var myChart = echarts.init(document.getElementById('serviceStatisticsChart'));

        myChart.setOption({
            color: ['#41b0e7', "#64e4d1"],
            title: {
                text: ''
            },
            tooltip: {
                trigger: 'axis'
            },
            legend: {
                data: ['新增工单', '完成工单']
            },
            grid: {
                left: '3%',
                right: '3%',
                bottom: '3%',
                containLabel: true
            },
            toolbox: {
                feature: {
                    saveAsImage: {}
                }
            },
            xAxis: {
                type: 'category',
                boundaryGap: false,
                data: xAxisD
            },
            yAxis: {},
            series: [
                {
                    name: '新增工单',
                    type: 'line',
                    data: []
                }, {
                    name: '完成工单',
                    type: 'line',
                    data: []
                }
            ]
        });
        myChart.showLoading();
        var data = {};
        data.param = xAxisData;
        $.post('getdaydate',data,function(res){
            myChart.hideLoading();
            // 填入数据
            myChart.setOption({
                series: [{
                    name: '新增工单',
                    type: 'line',
                    data: res.categories
                }, {
                    name: '完成工单',
                    type: 'line',
                    data: res.series
                }]
            });
        })

    }

    //获取当前指定的前几天的日期（如当前时间的前七天的日期）
    function getBeforeDate(n) {
        var n = n;
        var d = new Date();
        var year = d.getFullYear();
        var mon = d.getMonth() + 1;
        var day = d.getDate();
        if (day <= n) {
            if (mon > 1) {
                mon = mon - 1;
            } else {
                year = year - 1;
                mon = 12;
            }
        }
        d.setDate(d.getDate() - n);
        year = d.getFullYear();
        mon = d.getMonth() + 1;
        day = d.getDate();
        s = year + "-" + (mon < 10 ? ('0' + mon) : mon) + "-" + (day < 10 ? ('0' + day) : day);
        return s;
    }

    //动态更新版块 上图表
    function dynamicUpdateChartTopFun() {
        var myChart = echarts.init(document.getElementById('dynamicUpdateChartTop'));

        myChart.setOption({
            color: ['#3398DB'],
            tooltip: {
                trigger: 'axis',
                axisPointer: {            // 坐标轴指示器，坐标轴触发有效
                    type: 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                }
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            xAxis: [
                {
                    type: 'category',
                    data: ['已指派', '已接受', '进行中', '已完成'],
                    axisTick: {
                        alignWithLabel: true
                    }
                }
            ],
            yAxis: [
                {
                    type: 'value'
                }
            ],
            series: [
                {
                    name: '全部',
                    type: 'bar',
                    data: []
                }
            ]
        });


        myChart.showLoading();
        $.get('getdaydate').done(function (res) {
            myChart.hideLoading();
            myChart.setOption({
                series: [
                    {
                        name: '全部',
                        data: res.top
                    }
                ]
            });

        });

    }
    //动态更新版块 下图表
    function dynamicUpdateChartDownFun() {

        var xAxisDownD = [];
        var allData = getAll(getBeforeDate(6), getBeforeDate(0));
        xAxisDownD = allData.split(',');

        var myChart = echarts.init(document.getElementById('dynamicUpdateChartDown'));

        myChart.setOption({
            color: ['#41b0e7', "#64e4d1"],
            title: {},
            tooltip: {
                trigger: 'axis',
                axisPointer: {
                    type: 'shadow'
                }
            },
            legend: {
                data: ['新增', '完成']
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            xAxis: {
                type: 'value',
                boundaryGap: [0, 0.01]
            },
            yAxis: {
                type: 'category',
                data: xAxisDownD
            },
            series: [
                {
                    name: '新增',
                    type: 'bar',
                    data: []
                },
                {
                    name: '完成',
                    type: 'bar',
                    data: []
                }
            ]
        });


        myChart.showLoading();
        $.get('getdaydate').done(function (res) {
            myChart.hideLoading();
            myChart.setOption({
                series: [
                    {
                        name: '新增',
                        type: 'bar',
                        data: res.down.data1
                    },
                    {
                        name: '完成',
                        type: 'bar',
                        data: res.down.data2
                    }
                ]
            });

        });

    }


    //动态更新版块 上图表
    function myWorkOrderChartTopFun() {
        var myChart = echarts.init(document.getElementById('myWorkOrderChartTop'));

        myChart.setOption({
            color: ['#3398DB'],
            title: {
                text: '工单状态'
            },
            tooltip: {
                trigger: 'axis',
                axisPointer: {            // 坐标轴指示器，坐标轴触发有效
                    type: 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
                }
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            xAxis: [
                {
                    type: 'category',
                    data: ['已指派', '已接受', '进行中', '已完成'],
                    axisTick: {
                        alignWithLabel: true
                    }
                }
            ],
            yAxis: [
                {
                    type: 'value'
                }
            ],
            series: [
                {
                    name: '全部',
                    type: 'bar',
                    data: []
                }
            ]
        });


        myChart.showLoading();
        var data = {'currtpage':'1'}
        $.post('getdaydate',data,function (res) {
            myChart.hideLoading();
            myChart.setOption({
                series: [
                    {
                        name: '全部',
                        data: res.top
                    }
                ]
            });

        });

    }


    //动态更新版块 下图表
    function myWorkOrderChartDownFun() {

        var xAxisDownD = [];
        var allData = getAll(getBeforeDate(6), getBeforeDate(0));
        xAxisDownD = allData.split(',');

        var myChart = echarts.init(document.getElementById('myWorkOrderChartDown'));

        myChart.setOption({
            color: ['#41b0e7', "#64e4d1"],
            title: {
                text: '近七天工单'
            },
            tooltip: {
                trigger: 'axis',
                axisPointer: {
                    type: 'shadow'
                }
            },
            legend: {
                data: ['新增', '完成']
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            xAxis: {
                type: 'value',
                boundaryGap: [0, 0.01]
            },
            yAxis: {
                type: 'category',
                data: xAxisDownD
            },
            series: [
                {
                    name: '新增',
                    type: 'bar',
                    data: []
                },
                {
                    name: '完成',
                    type: 'bar',
                    data: []
                }
            ]
        });
        myChart.showLoading();
        var data ={"currentpage":"1"};
        $.post('getdaydate',data,function (res) {
            myChart.hideLoading();
            myChart.setOption({
                series: [
                    {
                        name: '新增',
                        type: 'bar',
                        data: res.down.data1
                    },
                    {
                        name: '完成',
                        type: 'bar',
                        data: res.down.data2
                    }
                ]
            });
        });
    }
</script>
</body>
</html>
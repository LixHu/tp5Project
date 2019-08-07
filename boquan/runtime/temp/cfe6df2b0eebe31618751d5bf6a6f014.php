<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:79:"F:\zm\my\boquan\public/../application/boquan\view\workorder\workorder_list.html";i:1521162655;s:58:"F:\zm\my\boquan\application\boquan\view\public\header.html";i:1520643971;s:58:"F:\zm\my\boquan\application\boquan\view\public\footer.html";i:1520643971;}*/ ?>
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

<script type="text/javascript" src="_js/vendor/modernizr.custom.js"></script>
<!-- STYLES -->
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="_css/vendor/normalize.css">
<link rel="stylesheet" type="text/css" href="_css/vendor/skeleton.css">
<link rel="stylesheet" type="text/css" href="_css/styles.css">
<link rel="stylesheet" type="text/css" href="_css/vendor/github.css">

<div class="row">
    <div class="twelve columns">
        <div class='tabs tabs_default'>
            <ul class='horizontal'>
                <li <?php if(empty($_GET['status'])): ?> class="active" <?php endif; ?>><a href="javascript:;" onclick="re('')">全部工单</a></li>
                <li <?php if(!empty($_GET['status']) and $_GET['status'] == 2): ?> class="active" <?php endif; ?>><a href="javascript:;" onclick="re(2)">待指派</a></li>
                <li <?php if(!empty($_GET['status']) and $_GET['status'] == 3): ?> class="active" <?php endif; ?>><a href="javascript:;" onclick="re(3)">已指派</a></li>
                <li <?php if(!empty($_GET['status']) and $_GET['status'] == 4): ?> class="active" <?php endif; ?>><a href="javascript:;" onclick="re(4)">已接受</a></li>
                <li <?php if(!empty($_GET['status']) and $_GET['status'] == 5): ?> class="active" <?php endif; ?>><a href="javascript:;" onclick="re(9)">进行中</a></li>
                <li <?php if(!empty($_GET['status']) and $_GET['status'] == 6): ?> class="active" <?php endif; ?>><a href="javascript:;" onclick="re(6)">已完成</a></li>
            </ul>
            <script>
                var re = function (st) {
                    location.href = '<?php echo url("workorder/workorder_list"); ?>?status='+st;
                }
            </script>
            <div>
                <div class="" id="main">
                    <section class="content" style="min-width: 760px !important;">
                        <div class="">
                            <form id="mainForm" method="get" class="nice-validator n-default n-bootstrap"
                                  novalidate="novalidate">
                                <div class="box box-solid">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6"></div>
                                            <div class="col-md-6 col-sm-6" style="text-align: right;">
                                                <div class="input-group">
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control keyword-search criteria"
                                                               placeholder="请输入工单编号" v-model="wo_sn" id="keyword"
                                                               name="keyword" style="width:500px;">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <button class="btn btn-primary" type="button" id="btnSearch"
                                                                @click="search">搜 索</button>
                                                            <button type="button" class="btn btn-default btnReset"
                                                                style="margin-left: 5px;" value="重置" @click="reset">重 置</button>
                                                    </div>
                                                </div>
                                                <script>

                                                </script>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="box box-solid collapse" id="collapseExample" aria-expanded="true">
                                    <div class="box-header with-border"><span style="font-weight: bold">高级搜索</span>
                                    </div>
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
                                                <input type="text" class="form-control criteria"
                                                       placeholder="请输入创建时间"
                                                       name="createtime" value="" id="createtime" readonly
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
                                            <!-- <button class="btn btn-default btn-sm"><i
                                                    class="glyphicon glyphicon-trash"></i>&nbsp;&nbsp;删除</button> -->
                                        </div>
                                    </div>
                                </div>

                                <div class="box box-solid">
                                    <div class="box-body no-padding">
                                        <div class="table-responsive list">
                                            <table class="table table-hover table-striped table-bordered"
                                                   id="taskTable">
                                                <thead>
                                                <tr>
                                                    <th><input type="checkbox" name="checkAll" id="checkSelect"
                                                               value="全选"></th>
                                                    <th>工单编号</th>
                                                    <th id="tour_1">报修人</th>
                                                    <th>联系方式</th>
                                                    <th>地点</th>
                                                    <!--<th name="taskProduct">服务类型</th>-->
                                                    <th>发动机匹配厂家</th>
                                                    <!--<th name="taskLevel">-->
                                                    <!--<a href="javascript:;" class="table-header-sort"-->
                                                    <!--onclick="orderTask(this)" data-name="sortBy[level]"-->
                                                    <!--name="level" data-sort="false">优先级&nbsp;-->
                                                    <!--<i class="fa fa-sort"></i>-->
                                                    <!--</a>-->
                                                    <!--</th>-->
                                                    <th>创建人</th>
                                                    <th>创建时间</th>
                                                    <th>工单状态</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" class="checkSelect" name="checkSelect"
                                                                   value="<?php echo $vo['wo_id']; ?>">
                                                        </td>
                                                        <td>
                                                            <a style="font-size: 15px; color:#2904fa;"
                                                                    href="<?php echo url('workorder/workorder_details',array('wid' => $vo['wo_id'])); ?>">
                                                                <?php echo $vo['wo_sn']; ?></a>
                                                        </td>
                                                        <td><?php if(!empty($vo['jour_name'])): ?><?php echo $vo['jour_name']; else: ?><?php echo $vo['cus_name']; endif; ?></td>
                                                        <td><?php if(!empty($vo['contact_info'])): ?><?php echo $vo['contact_info']; else: ?><?php echo $vo['cus_mobile']; endif; ?></td>
                                                        <td>
                                                            <?php if(!empty($vo['address'])): ?>
                                                            <?php echo $vo['address']; else: ?>
                                                            <?php echo $vo['cus_address']; endif; ?>
                                                        </td>
                                                        <?php // dump($vo);?>
                                                        <!--<td name="taskServiceType">-->
                                                        <!--<span v-if="item.server_type == 1">保内免费</span>-->
                                                        <!--<span v-if="item.server_type == 2">保内收费</span>-->
                                                        <!--<span v-if="item.server_type == 3">保外免费</span>-->
                                                        <!--<span v-if="item.server_type == 4">保外收费</span>-->
                                                        <!--</td>-->
                                                        <td><?php if(!empty($vo['math_ven'])): ?><?php echo $vo['math_ven']; else: ?>暂无信息<?php endif; ?></td>
                                                        <!--<td name="taskLevel">-->
                                                        <!--<span v-if="item.pid == 1">低</span>-->
                                                        <!--<span v-if="item.pid == 2">中</span>-->
                                                        <!--<span v-if="item.pid == 3">高</span>-->
                                                        <!--</td>-->
                                                        <td><?php if(!empty($vo['add_name'])): ?><?php echo $vo['add_name']; else: ?><?php echo $vo['add_name2']; endif; ?></td>
                                                        <td><?php echo $vo['add_time']; ?></td>
                                                        <td>
                                                            <p class="label " style="background-color: #69b5f0">
                                                                <?php echo $vo['status']; ?>
                                                            </p>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach; endif; else: echo "" ;endif; if(empty($list)): ?>
                                                        <tr>
                                                            <td colspan="19" style="text-align: center;">未找到相关数据</td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="box-footer ">
                                        <div class="col-lg-4 ">共 <?php echo count($list); ?>条记录&nbsp;
                                            共 <?php echo ceil(count($list)/$pagesize);?> 页 &nbsp; &nbsp;每页显示
                                            <select id="sizeSelect" onchange="getData()">
                                                <option value="10" <?php if($pagesize == 10): ?> selected <?php endif; ?>>10</option>
                                                <option value="20" <?php if($pagesize == 20): ?> selected <?php endif; ?>>20</option>
                                                <option value="50" <?php if($pagesize == 50): ?> selected <?php endif; ?>>50</option>
                                            </select>条
                                        </div>                                        </div>
                                </div>
                            </form>
                        </div>
                    </section>
                </div>
                <script>
                    var getData = function () {
                        location.href = '<?php echo url("workorder/workorder_list"); ?>?pagesize=' +$("#sizeSelect").val()
                    }
                    //分页
                    $(document).ready(function () {
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
                        //以上是高级搜索 调用的方法
                        //以下是复选框的选中
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
                </script>
            </div>
        </div>
    </div>
</div>
</body>
</html>
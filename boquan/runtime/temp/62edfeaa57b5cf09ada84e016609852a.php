<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:77:"F:\zm\my\boquan\public/../application/boquan\view\clientall\custom_apply.html";i:1521162669;s:58:"F:\zm\my\boquan\application\boquan\view\public\header.html";i:1520643971;s:58:"F:\zm\my\boquan\application\boquan\view\public\footer.html";i:1520643971;}*/ ?>
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
<div class="" id="main">
	<section class="content" style="min-width: 760px !important;">
		<div class="">
			<input type="hidden" id="sortSeachModel" name="sortBy[taskNo]" value="false"> <input type="hidden" id="workTaskId" name="id" value="">
			<div class="box box-solid">
				<div class="box-body">
					<div class="row">
						<div class="col-md-6 col-sm-6">
							<div class="btn-group" id="auth_delete">

								<a href="<?php echo url('Clientall/client_list'); ?>" class="btn btn-primary btn-sm checkbox-toggle">全部</a>
								<a href="<?php echo url('Clientall/ad_client'); ?>" class="btn btn-primary btn-sm checkbox-toggle" style="margin-left: 10px;">新建</a>
								<a href="javascript:del()" class="btn btn-default btn-sm" style="margin-left: 10px;">删除</a>

							</div>
							<!-- /.btn-group -->
						</div>

						<div class="col-md-6 col-sm-6">
							<form id="mainForm" action="search_service" method="get"
								class="nice-validator n-default n-bootstrap"
								novalidate="novalidate">
								<div class="input-group">
									<input type="text" class="form-control keyword-search criteria"
										placeholder="请输入客户名称" value="" id="keyword" name="keyword"
										maxlength="50"> <span class="input-group-btn">
										<button class="btn btn-primary" type="submit" id="btnSearch">搜
											索</button>
									</span>
								</div>
							</form>
						</div>
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
									<th><input type="checkbox" name="checkAll"
										id="checkSelect" value="全选"></th>
									<th>服务站名称</th>
									<!-- <th id="tour_1" name="taskCustomer">联系方式</th> -->
									<th name="taskCustomerLinkmanPhone">联系地址</th>
									<th name="taskProduct">状态</th>
									<!-- <th name="taskProduct">创建时间</th> -->
									<th name="taskPlanTime">操作</th>
								</tr>
							</thead>
							<tbody>
                                <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
								<tr>
									<td><input type="checkbox" class="checkSelect" name="checkSelect" value="<?php echo $vo['lid']; ?>"></td>
									<td><?php echo $vo['gname']; ?></td>
									<!-- <td></td> -->
									<td><?php echo $vo['address']; ?></td>
									<td><?php echo $vo['groupstatus']; ?></td>
									<!-- <td></td> -->
									<td>
										<a href="javascript:;" onclick="adopt(<?php echo $vo['lid']; ?>)" class="btn btn-primary btn-sm checkbox-toggle">通过</a>
										<a href="javascript:;" onclick="refuse(<?php echo $vo['lid']; ?>)" class="btn btn-primary btn-sm checkbox-toggle">拒绝</a>
									<!-- <a href="" onclick="savestatus()" class="btn btn-primary btn-sm checkbox-toggle">更改状态</a> -->
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
					<div class="col-lg-8 ">
                        <!-- <ul class="pagination pull-right" id="pagination1"></ul> -->
                    </div>
				</div>

			</div>

			
		</div>
	</section>
</div>
</body>
</html>

<script>
	var adopt = function(lid)
	{
		var data = {};
		data.id = lid;
		data.type = 1;
		$.post('appfuwu',data,function(res){
			alert(res.msg);
			if(res.code == 1){
				location.reload();
			}
		})
	}
	var refuse = function(lid)
	{
		var data = {};
		data.id = lid;
		data.type = 2;
		$.post('appfuwu',data,function(res){
			alert(res.msg);
			if(res.code == 1){
				location.reload();
			}
		})
	}
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
	//更改状态给个弹窗提示
	function savestatus(){
	alert('确定要更改状态吗？');
   }
		//批量删除
  	function del(){
  		//获取选中数据的id值
  		obj = document.getElementsByName("checkSelect");
		    var mid = [];
		    for(k in obj){
		        if(obj[k].checked)
		            mid.push(obj[k].value);
		    }
		//判断是否有选中数据
		if (mid == '') {
			alert('请先选择');
		}else{
			if(confirm('你确定要删除吗？')){
		  		$.post("<?php echo url('Clientall/del'); ?>",{id:mid},function(data){
	                if(data == 0){
	                    alert('删除失败');
	                    location.reload();
	                }else if(data == 1){
	                    location.reload();
	                }
	            },'json')
  			}
		}
  		
  	}


  	//搜索框没内容处理
    $('#btnSearch').click(function(){
    	var keyword = $('#keyword').val();
    	if (keyword == '') {
    		return false;
    	}
    })
</script>
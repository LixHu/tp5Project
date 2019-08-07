<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:73:"F:\zm\my\boquan\public/../application/boquan\view\system\system_info.html";i:1520643971;s:58:"F:\zm\my\boquan\application\boquan\view\public\header.html";i:1520643971;}*/ ?>
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
	background: #eeeeee;
}

.content {
	padding: 0 15px !important;
}

.edui1_iframeholder {
	width: 100% !important;
}

#edui1 {
	width: 100% !important;
}

#container {
	height: 300px;
}

.table-striped>tbody>tr:nth-of-type(odd) {
	background-color: #fff !important;
}
</style>
<section class="content" id="new">
	<form id="form1" method="post"
		class="form-horizontal nice-validator n-default n-bootstrap"
		novalidate="novalidate" antion="delmes">
		<div class="box box-solid">
			<div class="box-body">

				<div class="btn-group" id="auth_delete">
					<a href="javascript:delmes()" class="btn btn-primary btn-close"
					id="wiki-sub">
					<li class="fa fa-save"></li> &nbsp;&nbsp;删除
				</a>
				</div>
				<!-- /.btn-group -->

			</div>
		</div>
		<div class="box box-solid">
			<div class="box-body no-padding">
				<div class="table-responsive list">
					<table class="table table-hover table-striped table-bordered"
						id="taskTable">
						<thead>
							<tr>
								<th style="width: 20px;"><input type="checkbox"
									name="checkAll" id="checkSelect" value="全选"></th>
								<th style="width: 1%;"></th>
								<th>公告名称</th>
								<th style="width: 4%;">操作</th>
								
							</tr>
						</thead>
						<tbody>
							<?php if($res == false): if(is_array($message_list) || $message_list instanceof \think\Collection || $message_list instanceof \think\Paginator): $i = 0; $__LIST__ = $message_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
							<tr>
								<td><input type="checkbox" class="checkSelect"
									name="checkSelect" value="<?php echo $vo['id']; ?>"
									id="checkSelect_6e83e2f2-f111-11e7-9aa4-" style="margin-top: 13px;"></td>
								<td>
								<?php if($vo['status'] == 1): ?>
								<div style="border-radius: 100%; background: red;color: red;width: 8px; height: 8px; margin-top: 14px;"></div>
								<?php else: ?>
								<div style="border-radius: 100%; width: 10px; height: 10px; margin-top: 14px;"></div>
								<?php endif; ?>
								</td>
								<td>
									
									<div class="panel panel-default" style="margin-bottom: 0;">
									<div style="border-radius: 100%;"></div>
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion"
													href="#collapseC<?php echo $vo['id']; ?>" id="title" onclick="sbtn(<?php echo $vo['id']; ?>);"> <?php echo $vo['title']; ?> </a>
												<span style="width: 8%;float: right;margin-top: 0;margin-bottom: 0;font-size: 16px;"><?php echo date("Y-m-d",$vo['ad_time']); ?></span>

											</h4>
											
										</div>
										<div id="collapseC<?php echo $vo['id']; ?>" class="panel-collapse collapse ">
											<div class="panel-body"><?php echo $vo['content']; ?></div>
										</div>
										
									</div>
									
								</td>
								<td><a href="<?php echo url('edit_mes',['id'=>$vo['id']]); ?>" class="btn btn-primary btn-sm checkbox-toggle" style="margin-top: 4px;">编辑</a></td>

									
								
							</tr>
							<?php endforeach; endif; else: echo "" ;endif; else: ?>
							<tr>
								<td colspan="19" style="text-align: center;">未找到相关数据</td>
							</tr>
							<?php endif; ?>


						
						</tbody>
					</table><?php echo $page; ?>
				</div>
			</div>


		</div>


	</form>
</section>



<script type="text/javascript">
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

    //显示新建页面,隐藏文件库页面
    function newFile(id1, id2) {
        $('#' + id1).hide();
        $('#' + id2).show();
    }

   //隐藏新建页面,显示文件库页面
    function back(id1, id2) {
        $('#' + id1).show();
        $('#' + id2).hide();
        $("input,textarea").val("");
        UE.getEditor('container').setContent('', false);
        $("select").val(option[0]);
        $("input:radio,input:checkbox").attr("checked",false);
    }
    //获取所查看信息的id值，更新消息状态
  	function sbtn(id){
  		$.post("<?php echo url('System/savestatus'); ?>",{id:id})
  		
  	}

  	//批量删除
  	function delmes(){
  		//获取选中的数据id
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
		  		$.post("<?php echo url('System/delmes'); ?>",{id:mid},function(data){
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

</script>
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


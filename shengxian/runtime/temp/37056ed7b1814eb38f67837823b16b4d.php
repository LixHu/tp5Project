<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:83:"D:\phpStudy\WWW\my\shengxian\public/../application/admin\view\order\order_list.html";i:1511233310;s:80:"D:\phpStudy\WWW\my\shengxian\public/../application/admin\view\public\header.html";i:1511320558;s:80:"D:\phpStudy\WWW\my\shengxian\public/../application/admin\view\public\footer.html";i:1511233311;}*/ ?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="renderer" content="webkit">
<title></title>
<link rel="stylesheet" href="__CSS__/pintuer.css">
<link rel="stylesheet" href="__CSS__/admin.css">
<script src="__JS__/jquery.js"></script>
<script src="__JS__/pintuer.js"></script>
<!-- <link rel="stylesheet" type="text/css" href="__CSS__/css.css" /> -->
<!-- <link rel="stylesheet" type="text/css" href="__CSS__/public.css" /> -->
<!-- <link rel="stylesheet" type="text/css" href="__CSS__/page.css" /> -->
<!-- <link rel="stylesheet" href="__JS__/layui/css/layui.css" media="all"> -->


<script src="__JS__/layui/layui.js"></script>
<link rel="stylesheet" href="__JS__/layui/css/layui.css" media="all">
<script type="text/javascript">
    layui.use('layer',function(){
        var layer = layui.layer;
    })
</script>
</head>

<body>
<form method="post" action="" id="listform">
  <div class="panel admin-panel">
    <div class="panel-head"><strong class="icon-reorder"> 订单列表</strong> <a href="" style="float:right; display:none;">添加字段</a></div>
    <div class="padding border-bottom">
      <ul class="search" style="padding-left:10px;">
        <li> <a class="button border-main icon-plus-square-o" href="<?php echo url('order/addedit_order'); ?>">添加订单 </a> </li>
        <!-- <li>搜索：</li>
        <li>首页
          <select name="s_ishome" class="input" onchange="changesearch()" style="width:60px; line-height:17px; display:inline-block">
            <option value="">选择</option>
            <option value="1">是</option>
            <option value="0">否</option>
          </select>
          &nbsp;&nbsp;
          推荐
          <select name="s_isvouch" class="input" onchange="changesearch()"  style="width:60px; line-height:17px;display:inline-block">
            <option value="">选择</option>
            <option value="1">是</option>
            <option value="0">否</option>
          </select>
          &nbsp;&nbsp;
          置顶
          <select name="s_istop" class="input" onchange="changesearch()"  style="width:60px; line-height:17px;display:inline-block">
            <option value="">选择</option>
            <option value="1">是</option>
            <option value="0">否</option>
          </select>
        </li>-->
        <form action="" method="post">
             <li>
                <select name="status" class="input" style="width:200px; line-height:17px;" onchange="changesearch()">
                    <?php if(!empty($status)) $st = $status; else $st = '';if(is_array($order_status) || $order_status instanceof \think\Collection || $order_status instanceof \think\Paginator): $i = 0; $__LIST__ = $order_status;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <option value="<?php echo $vo['code']; ?>" <?php if($st != '' and $st == $vo['code']): ?>selected <?php endif; ?>><?php echo $vo['status']; ?></option>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
              </li>
            <li>
                <input type="text" placeholder="搜索手机号" name="keywords" class="input" style="width:250px; line-height:17px;display:inline-block" value="<?php if(!empty($keywords)) echo $keywords; ?>" />
                <button type="submit" class="layui-btn layui-btn-normal"><i class="layui-icon">&#xe615;</i>搜索</button>
            </li>
        </form>
      </ul>
    </div>
    <table class="table table-hover text-center">
      <tr>
        <th width="100" style="text-align:left; padding-left:20px;"></th>
        <th width="">订单编号</th>
        <th width="">用户编号</th>
        <th width="">订单状态</th>
        <th width="">配送状态</th>
        <th width="">手机号</th>
        <th width="">配送地址</th>
        <th width="">支付方式</th>
        <th width="">支付状态</th>
        <th width="">使用积分</th>
        <th width="">订单总价</th>
        <th width="">预计送达时间</th>
        <th width="">备注</th>
        <th width="">下单时间</th>
        <th width="310">操作</th>
      </tr>
      <?php if(is_array($order_list) || $order_list instanceof \think\Collection || $order_list instanceof \think\Paginator): $i = 0; $__LIST__ = $order_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
      <tr>
          <td><input type="checkbox" name="id[]" value="<?php echo $vo['order_id']; ?>"></td>
          <td><?php echo $vo['order_sn']; ?></td>
          <td><?php echo $vo['user_id']; ?></td>
          <td><?php echo order_status($vo['order_status'])['status'];?></td>
          <td><?php echo shipping_status($vo['shipping_status'])['status'];?></td>
          <td><?php echo $vo['mobile']; ?></td>
          <td><?php echo $vo['address']; ?></td>
          <td><?php echo get_pay_type($vo['pay_type'])['type'];?></td>
          <td><?php echo pay_status($vo['pay_status'])['status'];?></td>
          <td><?php echo $vo['intergral']; ?></td>
          <td><?php echo $vo['total_price']; ?></td>
          <td><?php if(!empty($vo['yj_delivery'])) echo  date('Y-m-d',$vo['yj_delivery']); else echo ''; ?></td>
          <td><?php echo $vo['leavmsg']; ?></td>
          <td><?php if(!empty($vo['add_time'])) echo  date('Y-m-d',$vo['add_time']); else echo ''; ?></td>
          <td><div class="button-group"> <a class="button border-main" href="<?php echo url('order/addedit_order','id='.$vo['order_id']); ?>"><span class="icon-edit"></span> 查看</a> <a class="button border-red" href="javascript:void(0)" onclick="return del(<?php echo $vo['order_id']; ?>)"><span class="icon-trash-o"></span> 删除</a> </div></td>
      </tr>
      <?php endforeach; endif; else: echo "" ;endif; ?>
      <tr>
        <td style="text-align:left; padding:19px 0;padding-left:20px;"><input type="checkbox" id="checkall"/>
          全选 </td>
        <td colspan="18" style="text-align:left;padding-left:20px;"><a href="javascript:void(0)" class="button border-red icon-trash-o" style="padding:5px 15px;" onclick="DelSelect()"> 删除</a>
      </tr>
      <tr>
        <td colspan="19"><?php echo $page; ?></td>
      </tr>
    </table>
  </div>
</form>
<script type="text/javascript">
//单个删除
function del(id){
 var  data = {"id":id};
	if(confirm("您确定要删除吗?")){
		$.post('/admin/order/del_order',data,function(msg){
      if(msg.code != -1){
          alert(msg.msg);
          window.history.go(0);
      }
    });
	}
}
//全选
$("#checkall").click(function(){
  $("input[name='id[]']").each(function(){
	  if (this.checked) {
		  this.checked = false;
	  }
	  else {
		  this.checked = true;
	  }
  });
})

//批量删除
function DelSelect(){
	var Checkbox=false;
  var check = [];
	$("input[name='id[]']").each(function(){
  	  if (this.checked==true) {
  		Checkbox=true;
      check.push(this.value);
	  }
	});
	if (Checkbox){
		var t=confirm("您确认要删除选中的内容吗？");
		if (t==false) return false;
    var data = {"id":check};
    $.post('/admin/order/del_order',data,function(msg){
      if(msg.code != -1){
          alert(msg.msg);
          window.history.go(0);
      }
    })
	}
	else{
		alert("请选择您要删除的内容!");
		return false;
	}
}

//批量排序
function sorts(){
	var Checkbox=false;
	 $("input[name='id[]']").each(function(){
	  if (this.checked==true) {
		Checkbox=true;
	  }
	});
	if (Checkbox){

		$("#listform").submit();
	}
	else{
		alert("请选择要操作的内容!");
		return false;
	}
}


//批量首页显示
function changeishome(o){
	var Checkbox=false;
	 $("input[name='id[]']").each(function(){
	  if (this.checked==true) {
		Checkbox=true;
	  }
	});
	if (Checkbox){

		$("#listform").submit();
	}
	else{
		alert("请选择要操作的内容!");

		return false;
	}
}

//批量推荐
function changeisvouch(o){
	var Checkbox=false;
	 $("input[name='id[]']").each(function(){
	  if (this.checked==true) {
		Checkbox=true;
	  }
	});
	if (Checkbox){


		$("#listform").submit();
	}
	else{
		alert("请选择要操作的内容!");

		return false;
	}
}

//批量置顶
function changeistop(o){
	var Checkbox=false;
	 $("input[name='id[]']").each(function(){
	  if (this.checked==true) {
		Checkbox=true;
	  }
	});
	if (Checkbox){

		$("#listform").submit();
	}
	else{
		alert("请选择要操作的内容!");

		return false;
	}
}


//批量移动
function changecate(o){
	var Checkbox=false;
	 $("input[name='id[]']").each(function(){
	  if (this.checked==true) {
		Checkbox=true;
	  }
	});
	if (Checkbox){

		$("#listform").submit();
	}
	else{
		alert("请选择要操作的内容!");

		return false;
	}
}

//批量复制
function changecopy(o){
	var Checkbox=false;
	 $("input[name='id[]']").each(function(){
	  if (this.checked==true) {
		Checkbox=true;
	  }
	});
	if (Checkbox){
		var i = 0;
	    $("input[name='id[]']").each(function(){
	  		if (this.checked==true) {
				i++;
			}
	    });
		if(i>1){
	    	alert("只能选择一条信息!");
			$(o).find("option:first").prop("selected","selected");
		}else{

			$("#listform").submit();
		}
	}
	else{
		alert("请选择要复制的内容!");
		$(o).find("option:first").prop("selected","selected");
		return false;
	}
}

</script>
</body>

</html>

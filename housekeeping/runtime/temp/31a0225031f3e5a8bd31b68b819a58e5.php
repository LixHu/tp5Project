<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:86:"D:\phpStudy\WWW\my\housekeeping\public/../application/admin\view\order\order_list.html";i:1511232378;s:83:"D:\phpStudy\WWW\my\housekeeping\public/../application/admin\view\public\header.html";i:1511232379;s:83:"D:\phpStudy\WWW\my\housekeeping\public/../application/admin\view\public\footer.html";i:1511232379;}*/ ?>
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
<link rel="stylesheet" href="__JS__/layui/css/layui.css" media="all">
<script type="text/javascript" src="__JS__/layui/layui.js"></script>
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
      <ul class="search" style="padding-left:10px;width: 3000px;">
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
        </li>
         <li>
            <select name="cid" class="input" style="width:200px; line-height:17px;" onchange="changesearch()">
              <option value="">请选择职位</option>
            </select>
          </li>
        <li>
          <input type="text" placeholder="请输入搜索关键字" name="keywords" class="input" style="width:250px; line-height:17px;display:inline-block" />
          <a href="javascript:void(0)" class="button border-main icon-search" onclick="changesearch()" > 搜索</a></li> -->
      </ul>
    </div>
    <table class="table table-hover text-center" style="">
      <tr>
        <th width="100" style="text-align:left; padding-left:20px;"></th>
        <th width="">订单编号</th>
        <th width="">家政类型</th>
        <th width="">是否为预约</th>
        <th width="">手机号</th>
        <th width="">用户</th>
        <th>地址</th>
        <th width="">订单价格</th>
        <th width="">订单状态</th>
        <th width="">支付状态</th>
        <th width="">开始时间</th>
        <th width="">添加时间</th>
        <th width="310">操作</th>
      </tr>
      <?php if(is_array($order_list) || $order_list instanceof \think\Collection || $order_list instanceof \think\Paginator): $i = 0; $__LIST__ = $order_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
        <tr>
          <td style="text-align:left; padding-left:20px;"><input type="checkbox" name="id[]" value="<?php echo $vo['order_id']; ?>" /></td>
          <td><?php echo $vo['order_sn']; ?></td>
          <td><?php echo $vo['position_name']; ?></td>
          <td><?php if($vo['is_reserve'] == 1): ?> 是<?php else: ?> 否<?php endif; ?></td>
          <td><?php echo $vo['mobile']; ?></td>
          <td><?php echo $vo['name']; ?></td>
          <td><button type="button" class="layui-btn view"  data-order="<?php echo $vo['order_id']; ?>">点击查看</button></td>
          <td><?php echo $vo['order_price']; ?></td>
          <td><?php echo $vo['order_status']; ?></td>
          <td><?php echo $vo['pay_status']; ?></td>
          <td><?php if(!empty($vo['start_time'])) echo date("Y-m-d H:i:s",$vo['start_time']);?></td>
          <td><?php if(!empty($vo['add_time'])) echo date("Y-m-d H:i:s",$vo['add_time']);?> </td>
          <td><div class="button-group"> <a class="button border-main" href="<?php echo url('order/addedit_order','id='.$vo['order_id']); ?>"><span class="icon-edit"></span> 修改</a> <a class="button border-red" href="javascript:void(0)" onclick="return del(<?php echo $vo['order_id']; ?>)"><span class="icon-trash-o"></span> 删除</a> </div></td>
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
<div style="display:none;" id="_add">
    <table class="layui-table">
        <tr>
            <th>姓名</th>
            <th>手机号</th>
            <th>地址</th>
        </tr>
        <tr id="tr">
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>
</div>
<script type="text/javascript">

//搜索
function changesearch(){

}
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
$(".view").on('click',function(){
    var id = {};
    id.id = $(this).data('order');
    console.log(id);
    $.post('order_address',id,function(msg){
        console.log(msg);
        $("#tr").children('td').eq(0).html(msg.name);
        $("#tr").children('td').eq(1).html(msg.mobile);
        $("#tr").children('td').eq(2).html(msg.add);
        layer.open({
            type:1,
            title:"地址信息",
            area:['700px','300px'],
            content:$('#_add')
        });
    })
})
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

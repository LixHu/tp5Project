<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:85:"D:\phpStudy\WWW\my\housekeeping\public/../application/admin\view\admin\role_list.html";i:1511232378;s:83:"D:\phpStudy\WWW\my\housekeeping\public/../application/admin\view\public\header.html";i:1511232379;s:83:"D:\phpStudy\WWW\my\housekeeping\public/../application/admin\view\public\footer.html";i:1511232379;}*/ ?>
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
    <div class="panel-head"><strong class="icon-reorder"> 角色权限管理</strong> <a href="" style="float:right; display:none;">添加字段</a></div>
    <div class="padding border-bottom">
      <ul class="search" style="padding-left:10px;">
        <li> <a class="button border-main icon-plus-square-o" href="<?php echo url('admin/add_role'); ?>"> 添加角色</a> </li>
        <form action="" method="post" >
          <li>
           <!--  <select name="pos" class="input" style="width:200px; line-height:17px;"">
              <option value="0">请选择职位</option>
                <option value=""  ></option>
            </select> -->
          </li>
        <li>
          <input type="text" placeholder="请输入搜索关键字" name="keywords" class="input" value="<?php if(!empty($keywords)){echo $keywords;} ?>" style="width:250px; line-height:17px;display:inline-block" />
          <input type="submit" class="button border-main icon-search" value="搜索" /> 
          </li>
      </ul>
    </div>
    <table class="table table-hover text-center">
      <tr>
        <th width="100" style="text-align:left; padding-left:20px;">角色id</th>
        <th>角色名称</th>
        <th>操作</th>
      </tr>
      	<?php if(is_array($role) || $role instanceof \think\Collection || $role instanceof \think\Paginator): $i = 0; $__LIST__ = $role;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
	        <tr>
	          <td style="text-align:left; padding-left:20px;"><input type="checkbox" name="id[]" value="<?php echo $vo['role_id']; ?>" /></td>
	          <td><?php echo $vo['role_name']; ?></td>
	          <td><div class="button-group"> <a class="button border-main" href="<?php echo url('admin/role','id='.$vo['role_id']); ?>"><span class="icon-edit"></span> 修改权限</a> <a class="button border-red" href="javascript:void(0)" onclick="return del()"><span class="icon-trash-o"></span> 删除</a> </div></td>
	        </tr>
	    <?php endforeach; endif; else: echo "" ;endif; ?>
      <tr>
        <td style="text-align:left; padding:19px 0;padding-left:20px;"><input type="checkbox" id="checkall"/>
          全选 </td>
        <td colspan="18" style="text-align:left;padding-left:20px;"><a href="javascript:void(0)" class="button border-red icon-trash-o" style="padding:5px 15px;" onclick="DelSelect()"> 删除</a> 
          </td>
      </tr>
      <tr>
        <td colspan="19"></td>
        <td></td>
      </tr>
    </table>
  </div>
</form>
<script type="text/javascript">


//单个删除
function del(id){
 var  data = {"id":id};
	if(confirm("您确定要删除吗?")){
		$.post('/admin/position/del_type',data,function(msg){
      if(msg.code != -1){
          alert(msg.msg);
          window.history.go(-1);
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
    $.post('/admin/position/del_type',data,function(msg){
      if(msg.code != -1){
          alert(msg.msg);
          window.history.go(-1);
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
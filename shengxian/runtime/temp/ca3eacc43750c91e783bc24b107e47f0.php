<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:82:"D:\phpStudy\WWW\my\shengxian\public/../application/admin\view\users\user_list.html";i:1511233311;s:80:"D:\phpStudy\WWW\my\shengxian\public/../application/admin\view\public\header.html";i:1511320558;s:80:"D:\phpStudy\WWW\my\shengxian\public/../application/admin\view\public\footer.html";i:1511233311;}*/ ?>
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
  <!-- <div class="panel admin-panel"> -->
    <div class="panel-head"><strong class="icon-reorder"> 会员列表</strong></div>
    <div class="padding border-bottom">
      <ul class="search" style="padding-left:10px;">
        <li> <a class="button border-main icon-plus-square-o" href="<?php echo url('users/addedit_user'); ?>"> 添加用户</a> </li>
      </ul>
    </div>
    <table class="layui-table">
      <tr>
        <th width="100" style="text-align:left; padding-left:20px;"></th>
        <th width="10%">用户账号</th>
        <th>头像</th>
        <th>手机号</th>
        <th>生日</th>
        <th>昵称</th>
        <th>会员</th>
        <th>余额</th>
        <th>积分</th>
        <!-- <th>账户</th> -->
        <th width="10%">最后一次登录时间</th>
        <th>注册时间</th>
        <th width="310">操作</th>
      </tr>
      <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
        <tr>
          <td style="text-align:left; padding-left:20px;"><input type="checkbox" name="id[]" value="<?php echo $vo['user_id']; ?>" /></td>
          <td><?php echo $vo['mobile']; ?></td>
          <td width="10%"><img src="<?php echo $vo['heard_img']; ?>" alt="" width="70" height="50" /></td>
          <td><?php echo $vo['mobile']; ?></td>
          <td><?php if(!empty($vo['birth_day'])) echo date("Y-m-d",$vo['birth_day']); else echo ''; ?></td>
          <td><?php echo $vo['nickname']; ?></td>
          <td><?php echo $vo['vip_lv']; ?></td>
          <td><?php echo $vo['balance']; ?></td>
          <td><?php echo $vo['integral']; ?>  &nbsp;&nbsp;&nbsp;<a class="button border-main" href="<?php echo url('users/addedit_integral','id='.$vo['user_id']); ?>"> 余额积分管理</a></td>
          <!-- <td></td> -->
          <td><?php if(!empty($vo['login_time'])) echo date("Y-m-d",$vo['login_time']); else echo ''; ?></td>
          <td><?php if(!empty($vo['add_time'])) echo date("Y-m-d",$vo['add_time']); else echo ''; ?></td>
          <td>
              <div class="layui-btn-group">
                  <a class="layui-btn layui-btn-normal" href="<?php echo url('users/addedit_user','id='.$vo['user_id']); ?>"><i class="layui-icon">&#xe642;</i> 修改</a>
                  <a class="layui-btn layui-btn-danger" href="javascript:void(0)" onclick="return del(<?php echo $vo['user_id']; ?>)"><i class="layui-icon">&#xe640;</i> 删除</a>
              </div>
              <button ty></button>
          </td>
        </tr>
     <?php endforeach; endif; else: echo "" ;endif; ?>
     <tr>
       <td colspan="12"><div class="pagelist"><?php echo $page; ?></div></td>
     </tr>
      <tr>
        <td style="text-align:left; padding:19px 0;padding-left:20px;"><input type="checkbox" id="checkall"/> 全选 </td>
        <td colspan="12" style="text-align:left;">
            <a href="javascript:void(0)" class="layui-btn layui-btn-danger" onclick="DelSelect()"><i class="layui-icon">&#xe640;</i> 删除</a>
         </td>
      </tr>
    </table>
  <!-- </div> -->
</form>
<script type="text/javascript">

//搜索
function changesearch(){

}

//单个删除
function del(id){
 var  data = {"id":id};
  if(confirm("您确定要删除吗?")){
    $.post('/admin/users/del_user',data,function(msg){
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
    $.post('/admin/users/del_user',data,function(msg){
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

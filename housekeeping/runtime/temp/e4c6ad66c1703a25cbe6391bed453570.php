<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:88:"D:\phpStudy\WWW\my\housekeeping\public/../application/admin\view\banner\addedit_pos.html";i:1509696249;s:83:"D:\phpStudy\WWW\my\housekeeping\public/../application/admin\view\public\header.html";i:1509943505;s:83:"D:\phpStudy\WWW\my\housekeeping\public/../application/admin\view\public\footer.html";i:1509349979;}*/ ?>
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

<form class="layui-form" action="" method="post" enctype="multipart/form-data">
    <div class="layui-form-item">
        <div class="layui-inline">
          <label class="layui-form-label">名称</label>
          <div class="layui-input-inline">
            <input type="text" name="pos_name" value="<?php if(!empty($info['pos_name'])) echo $info['pos_name']; ?>" lay-verify="required" autocomplete="off" class="layui-input">
          </div>
        </div>
     </div>
     <div class="layui-form-item">
         <div class="layui-inline">
           <label class="layui-form-label">描述</label>
           <div class="layui-input-inline">
             <input type="text" name="pos_desc" value="<?php if(!empty($info['pos_desc'])) echo $info['pos_desc']; ?>" lay-verify="required" autocomplete="off" class="layui-input">
           </div>
         </div>
     </div>
    <div class="layui-form-item">
        <div class="layui-inline">
            <button type="submit" class="layui-btn layui-btn-normal">提交</button>
        </div>
    </div>
</form>
<script type="text/javascript">
    layui.use(['form','upload'],function(){
        var $ = layui.jquery
        ,upload = layui.upload
        ,form = layui.form;
    });
</script>

</html>

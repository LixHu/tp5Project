<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:79:"/home/wwwroot/housekeeping/public/../application/admin/view/admin/add_role.html";i:1510050322;s:78:"/home/wwwroot/housekeeping/public/../application/admin/view/public/header.html";i:1510050325;s:78:"/home/wwwroot/housekeeping/public/../application/admin/view/public/footer.html";i:1510050325;}*/ ?>
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
<div class="panel admin-panel">
  <div class="panel-head" id="add"><strong><span class="icon-pencil-square-o"></span>权限管理</strong></div>
  <div class="body-content">
    <form method="post" class="form-x" action="" enctype="multipart/form-data">
      <div class="form-group">
        <div class="label">
          <label>添加角色：</label>
        </div>
        <div class="field">
          <input type="text" name="role_name" value="" class="input" />
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>权限管理：</label>
        </div>
        <div class="field">
          <?php if(is_array($left) || $left instanceof \think\Collection || $left instanceof \think\Paginator): $key = 0; $__LIST__ = $left;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($key % 2 );++$key;?>
              <div style="width: 200px;height:30px;">
                <input type="checkbox" name="leftid[]" value="<?php echo $vo['id']; ?>" /> <b><?php echo $vo['left_name']; ?></b> 
              </div>
              <?php if(!empty($vo['children'])): if(is_array($vo['children']) || $vo['children'] instanceof \think\Collection || $vo['children'] instanceof \think\Paginator): $k = 0; $__LIST__ = $vo['children'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($k % 2 );++$k;?>
                  <div style="display:inline-block;width: 200px;height:30px;">
                    <input type="checkbox" name="leftid[]" value="<?php echo $v['id']; ?>" /> <?php echo $v['left_name']; ?> 
                  </div>
                 <?php endforeach; endif; else: echo "" ;endif; endif; endforeach; endif; else: echo "" ;endif; ?>
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label></label>
        </div>
        <div class="field">
          <button class="button bg-main icon-check-square-o" type="submit"> 提交</button>
        </div>
      </div>
    </form>
  </div>
</div>

</body>

</html>
<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:78:"D:\phpStudy\WWW\my\shengxian\public/../application/admin\view\admin\index.html";i:1511233309;}*/ ?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="renderer" content="webkit">
    <title>生鲜管理后台</title>
    <link rel="stylesheet" href="__CSS__/pintuer.css">
    <link rel="stylesheet" href="__CSS__/admin.css">
    <script src="__JS__/jquery.js"></script>
    <script src="__JS__/layui/layui.js"></script>
    <link rel="stylesheet" href="__JS__/layui/css/layui.css" media="all">

</head>
<body style="background-color:#f2f9fd;">
<div class="header bg-main">
  <div class="logo margin-big-left fadein-top">
      <input type="hidden" id="admin_id" value="<?php echo \think\Session::get('admin')['admin_id']; ?>">
    <h1><img src="<?php echo \think\Session::get('admin')['heard_img']; ?>" class="radius-circle rotate-hover" height="50" alt="" />后台管理中心</h1>
  </div>
  <div class="head-l"><a href="<?php echo url('index/clearcache'); ?>" class="button button-little bg-blue"><span class="icon-wrench"></span> 清除缓存</a> &nbsp;&nbsp;<a class="button button-little bg-red" href="<?php echo url('Users/sign_out'); ?>"><span class="icon-power-off"></span> 退出登录</a> </div>
</div>
<div class="leftnav">
<a href="<?php echo url('admin/index'); ?>"> <div class="leftnav-title"><strong><span class="icon-list"></span>首页</strong></div></a>
  <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
    <h2><?php echo $vo['left_name']; ?></h2>
    <ul style="display:none">
      <?php if(is_array($vo['children']) || $vo['children'] instanceof \think\Collection || $vo['children'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['children'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
        <li><a href="<?php echo url('/admin'.$v['left_url']); ?>" target="right"><span class="icon-caret-right"></span><?php echo $v['left_name']; ?></a></li>
      <?php endforeach; endif; else: echo "" ;endif; ?>
    </ul>
  <?php endforeach; endif; else: echo "" ;endif; ?>
</div>
<script type="text/javascript">
$(function(){
  $(".leftnav h2").click(function(){
	  $(this).next().slideToggle(200);
	  $(this).toggleClass("on");
  })
  $(".leftnav ul li a").click(function(){
	    $("#a_leader_txt").text($(this).text());
  		$(".leftnav ul li a").removeClass("on");
		$(this).addClass("on");
  })
});
</script>
<div class="admin">
  <iframe scrolling="auto" rameborder="0" src="<?php echo url('admin/right'); ?>" name="right" width="100%" height="100%"></iframe>
</div>
<div class="" id="txsx">

</div>
  <script type="text/javascript">
      layui.use('layer',function(){
          var layer = layui.layer;
      })
      window.onload = function(){
          var data = {};
          data.admin_id = $("#admin_id").val();
          $.post('/admin/admin/tixing',data,function(msg){
             $("#txsx").html(msg);
          })
            var type = 'rb';
            layer.open({
              type: 1,
              title:"提醒事项",
              area:['250px','200px'],
              offset: type,
              content: $("#txsx"),
              btnAlign: 'c',
              btn:['确定'],
              shade: 0 ,
              yes: function(){
                $("#txsx").html('');
                layer.closeAll();
              }
            });
      }
      $('.fiexd').on('click', function(){
       var othis = $(this), method = othis.data('method');
       active[method] ? active[method].call(this, othis) : '';
      });
  </script>
</body>
</html>

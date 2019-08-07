<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:72:"D:\phpStudy\WWW\my\news\public/../application/admin\view\index\left.html";i:1511232954;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>首页左侧导航</title>
<link rel="stylesheet" type="text/css" href="__CSS__/public.css" />
<script type="text/javascript" src="__JS__/jquery.min.js"></script>
<script type="text/javascript" src="__JS__/public.js"></script>
<head></head>

<body id="bg">
	<!-- 左边节点 -->
	<div class="container">

		<div class="leftsidebar_box">
			<a href="/admin/index/right" target="main"><div class="line">
					<img src="__IMG__/coin01.png" />&nbsp;&nbsp;首页
				</div></a>
			<!-- <dl class="system_log">
			<dt><img class="icon1" src="__IMG__/coin01.png" /><img class="icon2"src="__IMG__/coin02.png" />
				首页<img class="icon3" src="__IMG__/coin19.png" /><img class="icon4" src="__IMG__/coin20.png" /></dt>
		</dl> -->
		<?php if(is_array($menu_list) || $menu_list instanceof \think\Collection || $menu_list instanceof \think\Paginator): $i = 0; $__LIST__ = $menu_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
			<dl class="system_log">
				<dt>
					<img class="icon1" src="__IMG__/coin03.png" /><img class="icon2" src="__IMG__/coin04.png" /> <?php echo $vo['menu_name']; ?><img class="icon3" src="__IMG__/coin19.png" /><img class="icon4" src="__IMG__/coin20.png" />
				</dt>
				<?php if(is_array($vo['child']) || $vo['child'] instanceof \think\Collection || $vo['child'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
					<dd>
						<img class="coin11" src="__IMG__/coin111.png" /><img class="coin22"	src="__IMG__/coin222.png" /><a class="cks" href="<?php echo url('admin/'.$v['menu_url']); ?>" target="main"><?php echo $v['menu_name']; ?></a><img class="icon5" src="__IMG__/coin21.png" />
					</dd>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</dl>
		<?php endforeach; endif; else: echo "" ;endif; ?>
		</div>

	</div>
</body>
</html>

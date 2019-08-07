<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:83:"D:\phpStudy\WWW\my\shengxian\public/../application/admin\view\goods\goods_attr.html";i:1511233310;s:80:"D:\phpStudy\WWW\my\shengxian\public/../application/admin\view\public\header.html";i:1511320558;s:80:"D:\phpStudy\WWW\my\shengxian\public/../application/admin\view\public\footer.html";i:1511233311;}*/ ?>
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


  

<link rel="stylesheet" type="text/css" href="__CSS__/bootstrap.min.css" />



<!--主要样式-->

<link rel="stylesheet" type="text/css" href="__CSS__/style.css" />



<script type="text/javascript" src="__JS__/jquery-1.7.2.min.js"></script>

<script type="text/javascript">

$(function(){

    $('.tree li:has(ul)').addClass('parent_li').find(' > span').attr('title', 'Collapse this branch');

    $('.tree li.parent_li > span').on('click', function (e) {

        var children = $(this).parent('li.parent_li').find(' > ul > li');

        if (children.is(":visible")) {

            children.hide('fast');

            $(this).attr('title', 'Expand this branch').find(' > i').addClass('icon-plus-sign').removeClass('icon-minus-sign');

        } else {

            children.show('fast');

            $(this).attr('title', 'Collapse this branch').find(' > i').addClass('icon-minus-sign').removeClass('icon-plus-sign');

        }

        e.stopPropagation();

    });

});

</script>
<body>
<div class="panel admin-panel"> 
	<div class="panel-head"><strong class="icon-reorder" style="display:inline;"> 商品属性</strong> </div>
    <ul class="search" style="padding-left:10px;">
        <li> <a class="button border-main icon-plus-square-o" style="width: 105px;height: 42px;" href="<?php echo url('goods/addedit_attr'); ?>"> 添加属性</a> </li>
     </ul>
	<div class="tree well">
		<ul>
			<li>

				<span><i class="icon-folder-open"></i> 商品分类</span> 

				<?php if(is_array($cat_list) || $cat_list instanceof \think\Collection || $cat_list instanceof \think\Paginator): $i = 0; $__LIST__ = $cat_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
					<ul>

						<li>

							<span><i class="icon-minus-sign"></i> <?php echo $vo['cat_name']; ?></span> 

							<ul>
								<?php if(is_array($vo['child']) || $vo['child'] instanceof \think\Collection || $vo['child'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
									<li>
									
										<span><i class="icon-leaf"></i> <?php echo $v['attr_name']; ?></span>  <a class="button border-main" href="<?php echo url('goods/addedit_attr','id='.$v['attr_id']); ?>">修改</a>

									</li>
								<?php endforeach; endif; else: echo "" ;endif; ?>

							</ul>

						</li>

					</ul>

				<?php endforeach; endif; else: echo "" ;endif; ?>
			</li>
		</ul>

	</div>
</div>
</body>

</html>
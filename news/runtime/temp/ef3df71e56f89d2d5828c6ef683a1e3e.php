<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:72:"D:\phpStudy\WWW\my\news\public/../application/admin\view\index\head.html";i:1511232954;s:73:"D:\phpStudy\WWW\my\news\public/../application/admin\view\public\head.html";i:1511232954;s:75:"D:\phpStudy\WWW\my\news\public/../application/admin\view\public\footer.html";i:1511232954;}*/ ?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="__CSS__/css.css" />
<link rel="stylesheet" type="text/css" href="__CSS__/public.css" />
<link rel="stylesheet" type="text/css" href="__CSS__/page.css" />
<link rel="stylesheet" href="__JS__/layui/css/layui.css" media="all">
<link rel="stylesheet" href="__CSS__/font_eolqem241z66flxr.css" media="all" />
<link rel="stylesheet" href="__CSS__/main.css" media="all" />
<!-- <script type="text/javascript" charset="utf-8" src="__JS__/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="__JS__/ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="__JS__/ueditor/lang/zh-cn/zh-cn.js"></script> -->
<script type="text/javascript" src="__JS__/jquery.min.js"></script>
<script src="__JS__/layui/layui.js"></script>
<!-- <script type="text/javascript" src="js/page.js" ></script> -->
<script type="text/javascript">
    layui.use('layer',function(){
        var layer = layui.layer;
    })
function previewImage(file)
{
    var MAXWIDTH = 260;
    var MAXHEIGHT = 180;
    var div = document.getElementById('preview');
    if (file.files && file.files[0])
    {
        div.innerHTML ='<img id=imghead>';
        var img = document.getElementById('imghead');
        img.onload = function(){
        var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
        img.width = rect.width;
        img.height = rect.height;
        //         img.style.marginLeft = rect.left+'px';
        img.style.marginTop = rect.top+'px';
        }
        var reader = new FileReader();
        reader.onload = function(evt){img.src = evt.target.result;}
        reader.readAsDataURL(file.files[0]);
    }
    else //兼容IE
    {
        var sFilter='filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src="';
        file.select();
        var src = document.selection.createRange().text;
        div.innerHTML = '<img id=imghead>';
        var img = document.getElementById('imghead');
        img.filters.item('DXImageTransform.Microsoft.AlphaImageLoader').src = src;
        var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
        status =('rect:'+rect.top+','+rect.left+','+rect.width+','+rect.height);
        div.innerHTML = "<div id=divhead style='width:"+rect.width+"px;height:"+rect.height+"px;margin-top:"+rect.top+"px;"+sFilter+src+"\"'></div>";
    }
}
function clacImgZoomParam( maxWidth, maxHeight, width, height ){
    var param = {top:0, left:0, width:width, height:height};
    if( width>maxWidth || height>maxHeight )
    {
        rateWidth = width / maxWidth;
        rateHeight = height / maxHeight;

        if( rateWidth > rateHeight )
        {
            param.width = maxWidth;
            param.height = Math.round(height / rateWidth);
        }else
        {
            param.width = Math.round(width / rateHeight);
            param.height = maxHeight;
        }
    }

    param.left = Math.round((maxWidth - param.width) / 2);
    param.top = Math.round((maxHeight - param.height) / 2);
    return param;
}

function previewImage2(file,num)
{
var MAXWIDTH = 260;
var MAXHEIGHT = 180;
var div = document.getElementById('preview'+num);
if (file.files && file.files[0])
{
    div.innerHTML ='<img id=imghead'+num+'>';
    var img = document.getElementById('imghead'+num);
    console.log(img);
    img.onload = function(){
    var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
    img.width = rect.width;
    img.height = rect.height;
    //         img.style.marginLeft = rect.left+'px';
    img.style.marginTop = rect.top+'px';
    }
    var reader = new FileReader();
    reader.onload = function(evt){img.src = evt.target.result;}
    reader.readAsDataURL(file.files[0]);
}
else //兼容IE
{
    var sFilter='filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src="';
    file.select();
    var src = document.selection.createRange().text;
    div.innerHTML = '<img id=imghead>';
    var img = document.getElementById('imghead');
    img.filters.item('DXImageTransform.Microsoft.AlphaImageLoader').src = src;
    var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
    status =('rect:'+rect.top+','+rect.left+','+rect.width+','+rect.height);
    div.innerHTML = "<div id=divhead style='width:"+rect.width+"px;height:"+rect.height+"px;margin-top:"+rect.top+"px;"+sFilter+src+"\"'></div>";
}
}
</script>

<style>

.pagelist {padding:10px 0; text-align:center;}
.pagelist span,.pagelist a{ border-radius:3px; border:1px solid #dfdfdf;display:inline-block; padding:5px 12px;}
.pagelist a{ margin:0 3px;}
.pagelist span.current{ background:#09F; color:#FFF; border-color:#09F; margin:0 2px;}
.pagelist a:hover{background:#09F; color:#FFF; border-color:#09F; }
.pagelist label{ padding-left:15px; color:#999;}
.pagelist label b{color:red; font-weight:normal; margin:0 3px;}
</style>
</head>

<body>

<body>
	<!-- 头部 -->
	<div class="head">
		<div class="headL">
			<img class="headLogo" src="__IMG__/headLogo.png" width="300" height="70"/>
		</div>
		<div class="headR">
			<p class="p1">
				欢迎您 <?php echo \think\Session::get('admin')['nickname']; ?>
			</p>
			<p class="p2">
				<a href="javascript:;" id="clear" class="resetPWD">清除缓存</a>&nbsp;&nbsp;
				<a href="javascript:;" id="cancel">退出</a>
			</p>
		</div>
		<!-- onclick="{if(confirm(&quot;确定退出吗&quot;)){return true;}return false;}" -->
	</div>
	<script type="text/javascript">
		$("#cancel").click(function(){
			if(window.parent.confirm('确定要退出吗')){
				window.parent.location.href="/admin/users/cancel";
			}
		})

		$("#clear").click(function(){
			window.parent.location.href="/admin/index/clear";
		})
	</script>

</body>
</html>

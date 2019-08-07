<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:78:"D:\phpStudy\WWW\my\news\public/../application/admin\view\admin\admin_list.html";i:1512465027;s:73:"D:\phpStudy\WWW\my\news\public/../application/admin\view\public\head.html";i:1511232954;s:75:"D:\phpStudy\WWW\my\news\public/../application/admin\view\public\footer.html";i:1511232954;}*/ ?>

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

	<div id="pageAll">
		<div class="pageTop">
			<div class="page">
				<img src="__IMG__/coin02.png" /><span><a href="#">首页</a>&nbsp;-&nbsp;<a
					href="#">网站管理</a>&nbsp;-</span>&nbsp;管理员管理
			</div>
		</div>

		<div class="page">
			<!-- banner页面样式 -->
			<div class="connoisseur">
				<div class="conform">
					<form action="" method="post">
						<!-- <div class="cfD">
							时间段：<input class="vinput" type="text" />&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;
							<input class="vinput vpr" type="text" /> 审核状态：<label><input
								type="radio" checked="checked" name="styleshoice1" />&nbsp;未审核</label> <label><input
								type="radio" name="styleshoice1" />&nbsp;待审核</label> <label><input
								type="radio" name="styleshoice1" />&nbsp;待约见</label> <label><input
								type="radio" name="styleshoice1" />&nbsp;已完成</label> <label class="lar"><input
								type="radio" name="styleshoice1" />&nbsp;已作废</label> 推荐状态：<label><input
								type="radio" checked="checked" name="styleshoice2" />&nbsp;未付款</label> <label><input
								type="radio" name="styleshoice2" />&nbsp;已付款</label>
						</div> -->
						<div class="cfD" style="float:left;">
							<input class="addUser" type="text" name="keyword" value="<?php if(!empty($keyword)) echo $keyword; else echo '' ?>" placeholder="输入用户名/手机号" />
							<button class="layui-btn layui-btn-normal"><i class="layui-icon">&#xe615;</i>搜索</button>
						</div>
						<div class="" style="float:right;">
							<button type="button" class="layui-btn layui-btn-normal" data-method="add" data-url="<?php echo url('admin/addedit_admin'); ?>"><i class="layui-icon">&#xe654;</i>添加管理员</button>
						</div>
					</form>
				</div>
				<!-- banner 表格 显示 -->
				<div class="conShow">
					<table class="layui-table">
						<tr>
							<td class="tdColor tdC"><input type="checkbox" id="checkall"></td>
							<td class="tdColor">头像</td>
							<td class="tdColor">用户名</td>
							<td class="tdColor">手机号</td>
							<td class="tdColor">身份名称</td>
							<td class="tdColor">添加时间</td>
							<td style="width:280px;" class="tdColor">操作</td>
						</tr>
                        <?php if(is_array($admin_list) || $admin_list instanceof \think\Collection || $admin_list instanceof \think\Paginator): $i = 0; $__LIST__ = $admin_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
    						<tr>
    							<td><input type="checkbox" name="id[]" value="<?php echo $vo['admin_id']; ?>"></td>
    							<td>
                                    <img src="<?php if(!empty($vo['head_img'])) echo $vo['head_img']; else echo '/static/img/default.jpg'; ?>" width="100" height="50" alt="">
    							</td>
    							<td><?php echo $vo['user_name']; ?></td>
    							<td><?php echo $vo['mobile']; ?></td>
    							<td><?php echo $vo['role_name']; ?></td>
    							<td><?php if(!empty($vo['add_time'])) echo date('Y-m-d',$vo['add_time']); else echo ''; ?></td>
    							<td>
                                    <div class="layui-btn-group">
                                        <a class="layui-btn layui-btn-normal" href="addedit_admin?id=<?php echo $vo['admin_id']; ?>">编辑</a>
										<button type="button" data-id="<?php echo $vo['admin_id']; ?>" data-method="del" class="layui-btn layui-btn-danger">删除</button>
    							    </div>
                                </td>
    						</tr>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
						<tr>
							<td colspan="15">
								<div class="pagelist"><?php echo $page; ?></div>
							</td>
						</tr>
						<tr>
							<td><button type="button" class="layui-btn layui-btn-danger" data-method="delAll">删除</button></td>
							<td colspan="15"></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</body>
<script type="text/javascript">
$('.layui-btn').on('click', function(){
	var othis = $(this), method = othis.data('method');
	active[method] ? active[method].call(this, othis) : '';
});
var active = {
	add:function(){
		location.href=$(this).data('url');
	},
	del:function(){
		var data = {};
		data.id = $(this).data('id');
		layer.confirm('确定要删除吗？',{
			btn:['确定','取消']
		},function(){
			$.post('del_admin',data,function(msg){
				msg = JSON.parse(msg);
				if(msg.code == 1){
					layer.msg(msg.msg,{icon:1});
					setTimeout("location.reload()",2000);
				}else{
					layer.msg(msg.msg,{icon:2});
				}
			})
		},function(){
			console.log('error');
		})
	},
	delAll:function(){
		var id = [];
		$.each($("input[name='id[]']"),function(k,v){
			if(v.checked){
				id.push(v.value);
			}
		})
		if(id.length < 1){
			layer.msg('请选择要删除的管理员',{icon:2});
			return false;
		}
		var data = {};
		data.id = id;
		layer.confirm('确定要删除吗？',{
			btn:['确定','取消']
		},function(){
			$.post('del_admin',data,function(msg){
				msg = JSON.parse(msg);
				if(msg.code == 1){
					layer.msg(msg.msg,{icon:1});
					setTimeout("location.reload()",2000);
				}else{
					layer.msg(msg.msg,{icon:2});
				}
			})
		},function(){

		})
	}
}
$("#checkall").click(function(){
	$.each($("input[name='id[]']"),function(k,v){
		v.checked = !v.checked;
	})
})
</script>

</body>
</html>


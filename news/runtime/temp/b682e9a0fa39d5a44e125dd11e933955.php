<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:72:"D:\phpStudy\WWW\my\news\public/../application/admin\view\ad\ad_list.html";i:1511417249;s:73:"D:\phpStudy\WWW\my\news\public/../application/admin\view\public\head.html";i:1511232954;s:75:"D:\phpStudy\WWW\my\news\public/../application/admin\view\public\footer.html";i:1511232954;}*/ ?>

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
					href="#">广告管理</a>&nbsp;-</span>&nbsp;广告列表
			</div>
		</div>

		<div class="page">
			<!-- banner页面样式 -->
			<div class="connoisseur">
				<div style="float:right;">
					<!-- <button type="button" class="layui-btn" data-method="add" data-url="<?php echo url('ad/addedit_ad'); ?>"><i class="layui-icon">&#xe654;</i>添加广告</button> -->
				</div>
				<div class="conform">
					 <form class="layui-form" action="" method="post" style="padding-top:10px;">
						<div class="layui-input-inline">
							<input type="text" class="layui-input" name="keyword" placeholder="话题名称"  value="<?php if(!empty($keyword)) echo $keyword; ?>">
						</div>
   						<div class="layui-input-inline">
							<select class="layui-input" name="col_id">
								<option value="">请选择</option>
								<?php if(is_array($col_list) || $col_list instanceof \think\Collection || $col_list instanceof \think\Paginator): $i = 0; $__LIST__ = $col_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
									<option value="<?php echo $vo['col_id']; ?>" <?php if($vo['col_id'] == $col_id and $col_id != ''): ?>selected <?php endif; ?>><?php echo $vo['col_name']; ?></option>
								<?php endforeach; endif; else: echo "" ;endif; ?>
							</select>
   						</div>
						<div class="layui-input-inline">
							<button lay-sbumit="" class="layui-btn"><i class="layui-icon">&#xe615;</i>搜索</button>
						</div>
					</form>
				</div>
				<div class="conShow" >
					<table class="layui-table" style="width:1700px;">
						<tr>
							<th width="66px" class="tdColor tdC" style="text-align:center;"><input type="checkbox" id="checkall"></th>
							<th class="tdColor" style="text-align:center;">分类</th>
							<th class="tdColor" style="text-align:center;">广告主</th>
							<th class="tdColor" style="text-align:center;">标题</th>
							<th class="tdColor" style="text-align:center;">浏览量</th>
							<th class="tdColor" style="text-align:center;">价格</th>
							<th class="tdColor" style="text-align:center;">库存</th>
							<th class="tdColor" style="text-align:center;">是否显示</th>
							<th class="tdColor" style="text-align:center;">是否申请推荐</th>
							<th class="tdColor" style="text-align:center;">申请推荐时长</th>
							<th class="tdColor" style="text-align:center;">推荐状态</th>
							<th class="tdColor" style="text-align:center;">推荐结束时间</th>
							<th class="tdColor" style="text-align:center;">发布时间</th>
							<th class="tdColor" style="text-align:center;">操作</th>
						</tr>
						<?php if(is_array($ad_list) || $ad_list instanceof \think\Collection || $ad_list instanceof \think\Paginator): $i = 0; $__LIST__ = $ad_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
							<tr>
								<td><input type="checkbox" name="id[]" value="<?php echo $vo['ad_id']; ?>"></td>
								<td><?php echo $vo['col_name']; ?></td>
								<td><?php echo $vo['user_name']; ?></td>
								<td><?php echo $vo['title']; ?></td>
								<td><?php echo $vo['see_count']; ?></td>
								<td><?php echo $vo['price']; ?></td>
								<td><?php echo $vo['stock']; ?></td>
								<td><div class="is_show" data-id="<?php echo $vo['ad_id']; ?>" data-status="<?php echo $vo['is_show']; ?>">
										<?php if($vo['is_show'] == 1): ?><img src="__IMG__/ok.png" alt=""> <?php else: ?><img src="__IMG__/no.png" alt=""> <?php endif; ?>
									</div>
								</td>
								<td><?php if($vo['is_groom']  == 1): ?> <img src="__IMG__/ok.png" alt=""><?php else: ?> <img src="__IMG__/no.png" alt=""> <?php endif; ?></td>
								<td><?php if(!empty($vo['t_name'])) echo $vo['t_name']; ?></td>
								<td><?php if($vo['groom_status']  == 1): ?> 推荐中<?php elseif($vo['groom_status'] == 3): ?>等待处理<?php elseif($vo['groom_status'] == 2): ?>拒绝推荐<?php elseif($vo['groom_status'] == 4): ?>已取消<?php else: ?>未申请<?php endif; ?></td>
								<td><?php if(!empty($vo['end_time'])): ?> <?php echo date("Y-m-d H:i",$vo['end_time']); endif; ?></td>
								<td><?php if(!empty($vo['add_time'])): ?> <?php echo date("Y-m-d H:i",$vo['add_time']); endif; ?></td>
								<td>
									<div class="layui-btn-group">
										<!-- <a href="addedit_ad?id=<?php echo $vo['ad_id']; ?>" class="layui-btn layui-btn-normal"><i class="layui-icon">&#xe615;</i>查看</a> -->
									 	<button data-method="<?php if($vo['is_groom']  == 1): ?>see1<?php else: ?>see<?php endif; ?>" data-id="<?php echo $vo['ad_id']; ?>" class="layui-btn layui-btn-normal"><i class="layui-icon">&#xe615;</i>查看</button>
										<button type="button" data-id="<?php echo $vo['ad_id']; ?>" data-method="del" class="layui-btn layui-btn-danger">删除</button>
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
				<!-- banner 表格 显示 end-->
			</div>
			<!-- banner页面样式end -->
		</div>

	</div>
<script type="text/javascript">
	layui.use('form',function(){
		var form = layui.form;
	})
	var active = {
		'add':function(){
			location.href=$(this).data('url');
		},del:function(){
			var data = {};
			data.id = $(this).data('id');
			layer.confirm('确定要删除吗？',{
				btn:['确定','取消']
			},function(){
				$.post('del_ad',data,function(msg){
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
				layer.msg('请选择要删除的用户',{icon:2});
				return false;
			}
			var data = {};
			data.id = id;
			layer.confirm('确定要删除吗？',{
				btn:['确定','取消']
			},function(){
				$.post('del_ad',data,function(msg){
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
		},
		see1:function(){
			var id = $(this).data('id');
			layer.open({
				type:2,
				title:"广告详情",
				area:['800px','600px'],
				closeBtn:1,
				shadeClose:true,
				btn:['确认推荐','拒绝','取消推荐','关闭'],
				content:'ad_info?id='+id,
				yes:function(){
					var data = {};
					data.id = id;
					data.status = 1;
					$.post('groom',data,function(msg){
						msg = JSON.parse(msg);
						if(msg.code == 1){
							layer.closeAll();
							layer.msg(msg.msg,{icon:1});
							setTimeout("location.reload()",2000);
						}else{
							layer.msg(msg.msg,{icon:2});
						}
					})
				},
				btn2:function(){
					var data = {};
					data.id = id;
					data.status = 2;
					$.post('groom',data,function(msg){
						msg = JSON.parse(msg);
						if(msg.code == 1){
							layer.closeAll();
							layer.msg(msg.msg,{icon:1});
							setTimeout("location.reload()",2000);
						}else{
							layer.msg(msg.msg,{icon:2});
						}
					})
				},
				btn3:function(){
					var data = {};
					data.id = id;
					data.status = 4;
					$.post('qx_groom',data,function(msg){
						msg = JSON.parse(msg);
						if(msg.code == 1){
							layer.closeAll();
							layer.msg(msg.msg,{icon:1});
							setTimeout("location.reload()",2000);
						}else{
							layer.msg(msg.msg,{icon:2});
						}
					})
				}
			})
		},
		see:function(){
			var id = $(this).data('id');
			layer.open({
				type:2,
				title:"广告详情",
				area:['800px','600px'],
				closeBtn:1,
				shadeClose:true,
				content:'ad_info?id='+id
			})
		}
	}
	$("#checkall").click(function(){
		$.each($("input[name='id[]']"),function(k,v){
			v.checked = !v.checked;
		})
	})
	$(".is_show").on('click',function(){
		var data = {};
		data.id = $(this).data('id');
		data.status = $(this).data('status');
		// console.log(data);
		$.post('update_ishow',data,function(msg){
			msg = JSON.parse(msg);
			// console.log(msg);
			if(msg.code == 1){
				layer.msg(msg.msg,{icon:1});
				setTimeout("location.reload()",2000);
			}else{
				layer.msg(msg.msg,{icon:2});
			}
		})
	})
	$(".layui-btn").on('click',function(){
		var othis = $(this), method = othis.data('method');
		active[method] ? active[method].call(this, othis) : '';
	})
</script>

</body>
</html>


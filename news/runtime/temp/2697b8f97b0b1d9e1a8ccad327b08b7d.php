<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:71:"D:\phpStudy\WWW\my\news\public/../application/admin\view\ad\ad_col.html";i:1511258913;s:73:"D:\phpStudy\WWW\my\news\public/../application/admin\view\public\head.html";i:1511232954;s:75:"D:\phpStudy\WWW\my\news\public/../application/admin\view\public\footer.html";i:1511232954;}*/ ?>

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
					href="#">广告管理</a>&nbsp;-</span>&nbsp;分类管理
			</div>
		</div>
		<div class="page">
			<!-- banner页面样式 -->
			<div class="banner">
				<div class="" style="float:left;width:750px;margin-top:10px;">
					<blockquote class="layui-elem-quote">
						分类名称不能超过4个字
					</blockquote>
				</div>
				<div style="float:right;padding:10px;">
					<button class="layui-btn" type="button" data-method="add" data-url="<?php echo url('ad/addedit_col'); ?>"><i class="layui-icon">&#xe654;</i>添加分类</button>
				</div>
				<!-- banner 表格 显示 -->
				<div class="banShow">
					<table class="layui-table">
						<tr>
							<td width="66px" class="tdColor tdC"><input type="checkbox" name="" id="checkall" value=""></td>
							<td class="tdColor">分类名称</td>
							<td class="tdColor">是否显示</td>
							<td class="tdColor">操作</td>
						</tr>
                        <?php if(is_array($col_list) || $col_list instanceof \think\Collection || $col_list instanceof \think\Paginator): $i = 0; $__LIST__ = $col_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
    						<tr>
    							<td><input type="checkbox" name="id[]" value="<?php echo $vo['col_id']; ?>"></td>
    							<td><?php echo $vo['col_name']; ?></td>
    							<td> <img src="<?php if($vo['is_show'] == 1): ?> __IMG__/ok.png<?php else: ?>__IMG__/no.png<?php endif; ?>" data-status="1" data-id="<?php echo $vo['col_id']; ?>" class="status"></td>
    							<td>
                                    <div class="layui-btn-group">
                                        <a href="addedit_col?id=<?php echo $vo['col_id']; ?>" class="layui-btn layui-btn-normal">编辑</a>
                                        <button type="button" data-id="<?php echo $vo['col_id']; ?>" data-method="del" class="layui-btn layui-btn-danger">删除</button>
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

    	var active = {
    		'add':function(){
    			location.href=$(this).data('url');
    		},del:function(){
    			var data = {};
    			data.id = $(this).data('id');
    			layer.confirm('确定要删除吗？',{
    				btn:['确定','取消']
    			},function(){
    				$.post('del_col',data,function(msg){
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
    				layer.msg('请选择要删除的分类',{icon:2});
    				return false;
    			}
    			var data = {};
    			data.id = id;
    			layer.confirm('确定要删除吗？',{
    				btn:['确定','取消']
    			},function(){
    				$.post('del_col',data,function(msg){
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
    	$(".layui-btn").on('click',function(){
    		var othis = $(this), method = othis.data('method');
    		active[method] ? active[method].call(this, othis) : '';
    	})
        $(".status").on('click',function(){
            var status = $(this).data('status'),
            data = {};
            if(status == 1){
                $(this).data('status',2);
                $(this).attr('src','__IMG__/no.png');
            }else{
                $(this).data('status',1);
                $(this).attr('src','__IMG__/ok.png');
            }
            data.status = status;
            data.id = $(this).data('id');
            $.post('update_status',data,function(msg){
                msg = JSON.parse(msg);
                if(msg.code == 1){
                    layer.msg(msg.msg,{icon:1});
                }else{
                    layer.msg(msg.msg,{icon:2});
                }
            })
        })

		$("#checkall").click(function(){
			$.each($("input[name='id[]']"),function(k,v){
				v.checked = !v.checked;
			})
		})
    </script>

</body>
</html>


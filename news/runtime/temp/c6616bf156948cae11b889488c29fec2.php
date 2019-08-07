<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:80:"D:\phpStudy\WWW\my\news\public/../application/admin\view\users\addedit_ader.html";i:1512460691;s:73:"D:\phpStudy\WWW\my\news\public/../application/admin\view\public\head.html";i:1511232954;s:75:"D:\phpStudy\WWW\my\news\public/../application/admin\view\public\footer.html";i:1511232954;}*/ ?>

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

<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
  <legend><?php echo $title; ?></legend>
</fieldset>
<form class="layui-form" action="" method="post" enctype="multipart/form-data">
    <div class="layui-form-item" style="width:350px;">
        <label class="layui-form-label"><font color="red">*</font>用户名:</label>
        <div class="layui-input-block">
            <input type="text" name="user_name" class="layui-input" lay-verify="required" value="<?php if(!empty($info['user_name'])) echo $info['user_name']; else echo '' ;?>" required>
        </div>
    </div>
    <div class="layui-form-item" style="width:350px;">
        <label class="layui-form-label">头像:</label>
        <div class="layui-input-block">
            <div id="preview3" style="float:left;">
                <img id="imghead3" width=100 height=100 border=0 src="<?php if(!empty($info['head_img'])) echo $info['head_img']; else echo '/static/img/default.jpg' ;?>">
            </div>
            <input type="button" data-method="upload" data-num="3" class="layui-btn" value="点击上传">
            <input type="file"  style="display:none;" id="image3" name="image1" style="float:left;" onchange="previewImage2(this,3)">
        </div>
    </div>
    <div class="layui-form-item" style="width:350px;">
        <label class="layui-form-label"><font color="red">*</font> 手机号:</label>
        <div class="layui-input-block">
            <input type="text" name="mobile" class="layui-input" lay-verify="required|phone" value="<?php if(!empty($info['mobile'])) echo $info['mobile']; else echo '' ;?>" required>
            <font color="red">手机号作为登录账号</font>
        </div>
    </div>
    <div class="layui-form-item" style="width:350px;">
        <label class="layui-form-label">昵称:</label>
        <div class="layui-input-block">
            <input type="text" name="nickname" class="layui-input" value="<?php if(!empty($info['nickname'])) echo $info['nickname']; else echo '' ;?>">
        </div>
    </div>
    <div class="layui-form-item" style="width:350px;">
        <label class="layui-form-label"><font color="red">*</font>身份:</label>
        <div class="layui-input-block">
            <!-- <input type="text" name="iden" class="layui-input" value="<?php if(!empty($info['iden'])) echo $info['iden']; else echo '' ;?>"> -->
            <?php if(!empty($info['iden'])) $ide = $info['iden']; else $ide = '';?>
            <select class="" name="iden">
                <option value="">请选择</option>
                <?php if(is_array($iden) || $iden instanceof \think\Collection || $iden instanceof \think\Paginator): $i = 0; $__LIST__ = $iden;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <option value="<?php echo $vo['iden_id']; ?>" <?php if($ide != '' and $ide == $vo['iden_id']): ?> selected <?php endif; ?>><?php echo $vo['iden_name']; ?>-<?php echo $vo['iden_power']; ?> </option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </div>
    </div>

    <div class="layui-form-item" style="width:350px;">
        <label class="layui-form-label"><font color="red">*</font>行业:</label>
        <div class="layui-input-block">
            <!-- <input type="text" name="iden" class="layui-input" value="<?php if(!empty($info['iden'])) echo $info['iden']; else echo '' ;?>"> -->
            <?php if(!empty($info['col_id'])) $col = $info['col_id']; else $col = '';?>
            <select class="" name="col_id">
                <option value="">请选择</option>
                <?php if(is_array($col_list) || $col_list instanceof \think\Collection || $col_list instanceof \think\Paginator): $i = 0; $__LIST__ = $col_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <option value="<?php echo $vo['col_id']; ?>" <?php if($col != '' and $col == $vo['col_id']): ?> selected <?php endif; ?>><?php echo $vo['col_name']; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </div>
    </div>
    <div class="layui-form-item" style="width:350px;">
        <label class="layui-form-label"><font color="red">*</font>公司名称:</label>
        <div class="layui-input-block">
            <input type="text" name="name" class="layui-input" value="<?php if(!empty($info['name'])) echo $info['name']; else echo '';?>">
        </div>
    </div>
    <div class="layui-form-item" style="width:350px;">
        <label class="layui-form-label"><font color="red">*</font>公司电话:</label>
        <div class="layui-input-block">
            <input type="text" name="tel" class="layui-input" value="<?php if(!empty($info['tel'])) echo $info['tel']; else echo '' ;?>">
        </div>
    </div>
    <div class="layui-form-item" style="width:350px;">
        <label class="layui-form-label"><font color="red">*</font>公司手机号:</label>
        <div class="layui-input-block">
            <input type="text" name="mobile1" class="layui-input" value="<?php if(!empty($info['mobile1'])) echo $info['mobile1']; else echo '' ;?>">
        </div>
    </div>
    <div class="layui-form-item" style="width:350px;">
        <label class="layui-form-label"><font color="red">*</font>具体地址:</label>
        <div class="layui-input-block">
            <input type="text" name="add" class="layui-input" value="<?php if(!empty($info['add'])) echo $info['add']; else echo '' ;?>">
        </div>
    </div>
    <div class="layui-form-item" style="width:350px;">
        <label class="layui-form-label">审核状态:</label>
        <div class="layui-input-block">
            <select name="aud_status">
                <?php $as = ''; if(!empty($info['aud_status'])) $as = $info['aud_status']; if(is_array($aud_status) || $aud_status instanceof \think\Collection || $aud_status instanceof \think\Paginator): $i = 0; $__LIST__ = $aud_status;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <option value="<?php echo $vo['code']; ?>" <?php if($as != '' and $as == $vo['code']): ?> selected <?php endif; ?>><?php echo $vo['status']; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </div>
    </div>

    <div class="layui-form-item" style="width:350px;">
        <label class="layui-form-label">公司图片:</label>
        <div class="layui-input-block">
            <div id="preview1" style="float:left;">
                <img id="imghead1" width=100 height=100 border=0 src="<?php if(!empty($info['com_img'])) echo $info['com_img']; else echo '/static/img/default.jpg' ;?>">
            </div>
            <input type="button" data-method="upload" data-num="1" class="layui-btn" value="点击上传">
            <input type="file"  style="display:none;" id="image1" name="image2" style="float:left;" onchange="previewImage2(this,1)">
        </div>
    </div>
    <div class="layui-form-item" style="width:350px;">
        <label class="layui-form-label">营业执照:</label>
        <div class="layui-input-block">
            <div id="preview2" style="float:left;">
                <img id="imghead2" width=100 height=100 border=0 src="<?php if(!empty($info['license_img'])) echo $info['license_img']; else echo '/static/img/default.jpg' ;?>">
            </div>
            <input type="button" data-method="upload" data-num="2" class="layui-btn" value="点击上传">
            <input type="file"  style="display:none;" id="image2" name="image3" style="float:left;" onchange="previewImage2(this,2)">
        </div>
    </div>
    <div class="layui-form-item" style="width:350px;">
        <label class="layui-form-label">密码:</label>
        <div class="layui-input-block">
            <input type="password" name="password" class="layui-input" value="">
            <!-- <font color="red">不填代表不修改密码</font> -->
        </div>
    </div>
    <div class="layui-form-item" style="width:350px;">
        <label class="layui-form-label">确认密码:</label>
        <div class="layui-input-block">
            <input type="password" name="password2" class="layui-input" value="">
        </div>
    </div>
    <div class="layui-form-item" style="width:350px;">
        <div class="layui-input-block">
            <button lay-submit="" class="layui-btn">提交</button>
        </div>
    </div>
</form>
<script type="text/javascript">
    layui.use('form',function(){
        var form = layui.form;
    })
    var active = {
        upload:function(){
            var num = $(this).data('num');
            $("#image"+num).click();
        }
    }
    $(".layui-btn").on('click',function(){
    	var othis = $(this), method = othis.data('method');
    	active[method] ? active[method].call(this, othis) : '';
    })
</script>

</body>
</html>


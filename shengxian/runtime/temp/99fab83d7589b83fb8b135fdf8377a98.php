<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:91:"D:\phpStudy\WWW\my\shengxian\public/../application/admin\view\application\website_conf.html";i:1511233309;s:80:"D:\phpStudy\WWW\my\shengxian\public/../application/admin\view\public\header.html";i:1511320558;s:80:"D:\phpStudy\WWW\my\shengxian\public/../application/admin\view\public\footer.html";i:1511233311;}*/ ?>
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

<script type="text/javascript">
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
</script>
<body>
<!-- <div class="panel admin-panel">
  <div class="panel-head"><strong><span class="icon-pencil-square-o"></span> 网站信息</strong></div>
  <div class="body-content">
    <form method="post" class="form-x" action="" enctype="multipart/form-data">
      <div class="form-group">
        <div class="label">
          <label>手机：</label>
        </div>
        <div class="field">
          <input type="text" class="input" name="mobile" value="<?php echo $conf['mobile']; ?>" />
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>电话：</label>
        </div>
        <div class="field">
          <input type="text" class="input" name="tel" value="<?php echo $conf['tel']; ?>" />
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>QQ：</label>
        </div>
        <div class="field">
          <input type="text" class="input" name="qq" value="<?php echo $conf['qq']; ?>" />
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>微信号：</label>
        </div>
        <div class="field">
          <input type="text" class="input" name="wechat" value="<?php echo $conf['wechat']; ?>" />
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>Email：</label>
        </div>
        <div class="field">
          <input type="text" class="input" name="email" value="<?php echo $conf['email']; ?>" />
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>地址：</label>
        </div>
        <div class="field">
          <input type="text" class="input" name="address" value="<?php echo $conf['address']; ?>" />
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
</div> -->
<form class="layui-form" action="" method="post" enctype="multipart/form-data">
    <div class="layui-form-item">
        <label class="layui-form-label" style="width:170px;">网站标题：</label>
        <div class="layui-input-inline">
            <input type="text" name="title" class="layui-input" lay-verify="required" value="<?php echo $conf['title']; ?>" required>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label" style="width:170px;">网站标题：</label>
        <div class="layui-input-block">
            <div class="field">
                <div id="preview" style="float:left;">
                  <img id="imghead" width=100 height=100 border=0 src="<?php echo $conf['logo_img']; ?>">
                </div>
              <input type="file" class="button margin-left" name="image1" style="float:left;" onchange="previewImage(this)">
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label" style="width:170px;">官方网站：</label>
        <div class="layui-input-inline">
          <input type="text" class="layui-input" name="website" value="<?php echo $conf['website']; ?>" />
        </div>
    </div><div class="layui-form-item">
        <label class="layui-form-label" style="width:170px;">官方微博：</label>
        <div class="layui-input-inline">
            <input type="text" name="micro_blog" class="layui-input" value="<?php echo $conf['micro_blog']; ?>">
        </div>
    </div><div class="layui-form-item">
        <label class="layui-form-label" style="width:170px;">手机：</label>
        <div class="layui-input-inline">
            <input type="text" name="mobile" class="layui-input" value="<?php echo $conf['mobile']; ?>" >
        </div>
    </div><div class="layui-form-item">
        <label class="layui-form-label" style="width:170px;">电话：</label>
        <div class="layui-input-inline">
            <input type="text" name="tel" class="layui-input" value="<?php echo $conf['tel']; ?>">
        </div>
    </div><div class="layui-form-item">
        <label class="layui-form-label" style="width:170px;">QQ：</label>
        <div class="layui-input-inline">
            <input type="text" name="qq" class="layui-input" value="<?php echo $conf['qq']; ?>">
        </div>
    </div><div class="layui-form-item">
        <label class="layui-form-label" style="width:170px;">微信号：</label>
        <div class="layui-input-inline">
            <input type="text" name="title" class="layui-input" value="<?php echo $conf['wechat']; ?>">
        </div>
    </div><div class="layui-form-item">
        <label class="layui-form-label" style="width:170px;">Email：</label>
        <div class="layui-input-inline">
            <input type="text" name="title" class="layui-input" value="<?php echo $conf['wechat']; ?>">
        </div>
    </div><div class="layui-form-item">
        <label class="layui-form-label" style="width:170px;">地址：</label>
        <div class="layui-input-inline">
            <input type="text" name="title" class="layui-input" value="<?php echo $conf['address']; ?>">
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit="">提交</button>
        </div>
    </div>
</form>
    <script type="text/javascript">
        layui.use('form',funnction(){
            var form = layui.form;
        })
    </script>
</body>

</html>

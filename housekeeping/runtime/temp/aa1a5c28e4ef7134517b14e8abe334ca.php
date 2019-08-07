<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:91:"D:\phpStudy\WWW\my\housekeeping\public/../application/admin\view\banner\addedit_banner.html";i:1509692805;s:83:"D:\phpStudy\WWW\my\housekeeping\public/../application/admin\view\public\header.html";i:1509943505;s:83:"D:\phpStudy\WWW\my\housekeeping\public/../application/admin\view\public\footer.html";i:1509349979;}*/ ?>
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
<form class="layui-form" action="" method="post" enctype="multipart/form-data">
    <div class="layui-form-item">
        <div class="layui-inline">
          <label class="layui-form-label">名称</label>
          <div class="layui-input-inline">
            <input type="text" name="bn_name" value="<?php if(!empty($info['bn_name'])) echo $info['bn_name']; ?>" lay-verify="required" autocomplete="off" class="layui-input">
          </div>
        </div>
     </div>
      <div class="layui-form-item">
        <div class="layui-inline">
          <label class="layui-form-label">位置</label>
          <div class="layui-input-inline">
            <select name="pos">
                <?php if(!empty($info['bn_pos'])) $bp = $info['bn_pos']; else $bp = '';?>
                <option value="0">请选择</option>
                <?php if(is_array($pos_list) || $pos_list instanceof \think\Collection || $pos_list instanceof \think\Paginator): $i = 0; $__LIST__ = $pos_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <option value="<?php echo $vo['pos_id']; ?>" <?php if($bp != '' and $bp == $vo['pos_id']): ?>selected <?php endif; ?>><?php echo $vo['pos_name']; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
          </div>
        </div>
    </div>
    <div class="layui-form-item">
      <div class="label">
        <label class="layui-form-label">logo：</label>
      </div>
      <div class="field">
          <div id="preview" style="float:left;">
            <img id="imghead" width=100 height=100 border=0 src="<?php if(!empty($info['bn_url'])) echo $info['bn_url']; ?>">
          </div>
        <input type="file" class="button margin-left" name="image1" style="float:left;" onchange="previewImage(this)">
      </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-inline">
            <button type="submit" class="layui-btn layui-btn-normal">提交</button>
        </div>
    </div>
</form>
<script type="text/javascript">
    layui.use(['form','upload'],function(){
        var $ = layui.jquery
        ,upload = layui.upload
        ,form = layui.form;
    });
</script>

</html>

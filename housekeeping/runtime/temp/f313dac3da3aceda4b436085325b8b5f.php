<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:88:"D:\phpStudy\WWW\my\housekeeping\public/../application/admin\view\users\addedit_user.html";i:1511232379;s:83:"D:\phpStudy\WWW\my\housekeeping\public/../application/admin\view\public\header.html";i:1511232379;s:83:"D:\phpStudy\WWW\my\housekeeping\public/../application/admin\view\public\footer.html";i:1511232379;}*/ ?>
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
<body>
<div class="panel admin-panel">
  <div class="panel-head" id="add"><strong><span class="icon-pencil-square-o"></span>添加/修改用户</strong></div>
  <div class="body-content">
    <form method="post" class="form-x" action="" enctype="multipart/form-data">
      <div class="form-group">
        <div class="label">
          <label>用户名：</label>
        </div>
        <div class="field">
          <input type="text" class="input w50" value="<?php if(!empty($info['username'])) echo $info['username']; ?>" name="username" data-validate="required:请输入姓名" />
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>头像：</label>
        </div>
        <div class="field">
            <div id="preview" style="float:left;">
              <img id="imghead" width=100 height=100 border=0 src="<?php if(!empty($info['top_img'])) echo $info['top_img']; else echo '/static/img/default.png';  ?>">
            </div>
          <input type="file" class="button margin-left" name="image1" style="float:left;" onchange="previewImage(this)">

        </div>
      </div>

      <div class="form-group">
        <div class="label">
          <label>手机号：</label>
        </div>
        <div class="field">
          <input type="text" class="input w50" value="<?php if(!empty($info['mobile'])) echo $info['mobile']; ?>" name="mobile" data-validate="required:请输入工作经验" />
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>会员卡：</label>
        </div>
        <div class="field">
        <?php if(!empty($info['vip_card'])) $card_num = $info['vip_card']; else $card_num = ''; ?>
        <select name="vip_card" class="input w50">
            <?php if(is_array($card) || $card instanceof \think\Collection || $card instanceof \think\Paginator): $i = 0; $__LIST__ = $card;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
              <option value="<?php echo $vo['id']; ?>" <?php if($card_num != '' and $vo['id'] == $card_num): ?> selected<?php endif; ?>><?php echo $vo['type']; ?></option>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </select>
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>余额：</label>
        </div>
        <div class="field">
          <input type="text" class="input w50" name="balance" value="<?php if(!empty($info['balance'])) echo $info['balance']; ?>"/>
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>密码：</label>
        </div>
        <div class="field">
          <input type="password" class="input w50" name="password" value="" />
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>确认密码：</label>
        </div>
        <div class="field">
          <input type="password" class="input w50" name="password2" value="" />
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
</div>

</body>

</html>

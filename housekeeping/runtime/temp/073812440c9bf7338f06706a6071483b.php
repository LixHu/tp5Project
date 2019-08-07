<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:85:"/home/wwwroot/housekeeping/public/../application/admin/view/position/addedit_pos.html";i:1510050324;s:78:"/home/wwwroot/housekeeping/public/../application/admin/view/public/header.html";i:1510050325;s:78:"/home/wwwroot/housekeeping/public/../application/admin/view/public/footer.html";i:1510050325;}*/ ?>
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
  <div class="panel-head" id="add"><strong><span class="icon-pencil-square-o"></span>增加员工</strong></div>
  <div class="body-content">
    <form method="post" class="form-x" action="" enctype="multipart/form-data">
      <div class="form-group">
        <div class="label">
          <label>姓名：</label>
        </div>
        <div class="field">
          <input type="text" class="input w50" value="<?php if(!empty($info['name'])) echo $info['name']; ?>" name="name" data-validate="required:请输入姓名" />
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>头像：</label>
        </div>
        <div class="field">
            <div id="preview" style="float:left;">
              <img id="imghead" width=100 height=100 border=0 src="<?php if(!empty($info['top_image'])) echo $info['top_image']; ?>">
            </div>
          <input type="file" class="button margin-left" name="image1" style="float:left;" onchange="previewImage(this)">
          <div class="tipss">图片尺寸：500*500</div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>家政类型：</label>
        </div>
        <div class="field">
          <select name="position" class="input w50">
            <option value="">请选择类型</option><?php $p = '';$t = '';$pt = '';$s = '';$ms = '';if(!empty($info['position'])) $p = $info['position']; if(is_array($position) || $position instanceof \think\Collection || $position instanceof \think\Paginator): $i = 0; $__LIST__ = $position;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
              <option value="<?php echo $vo['id']; ?>" <?php if($p == $vo['id'] and $p != ''): ?>selected<?php endif; ?>><?php echo $vo['position_name']; ?></option>
            <?php endforeach; endif; else: echo "" ;endif; ?>
          </select>
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>工作经验:</label>
        </div>
        <div class="field">
          <input type="text" class="input" style="width:50px;" value="<?php if(!empty($info['experience'])) echo $info['experience']; ?>" name="experience" data-validate="required:请输入工作经验" />年
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>要求工资：</label>
        </div>
        <div class="field">
          <input type="text" class="input" style="width:70px;display: inline-block;float:left;" value="<?php if(!empty($info['workprice'])) echo $info['workprice']; ?>" name="workprice" data-validate="required:请输入工资" />
          <select name="price_type" class="input w50" style="float: left;width: 70px;">
            <?php if(!empty($info['price_type'])) $pt = $info['price_type']; ?>
            <option value="1" <?php if($pt == 1 and $pt != ''): ?>selected <?php endif; ?>>/月</option>
            <option value="2" <?php if($pt == 2 and $pt != ''): ?>selected <?php endif; ?>>/日</option>
            <option value="3" <?php if($pt == 3 and $pt != ''): ?>selected <?php endif; ?>>/时</option>
          </select>
          <div class="tips"></div>
        </div>
      </div>

      <div class="form-group">
        <div class="label">
          <label>工作能力：</label>
        </div>
        <div class="field">
          <textarea class="input"  name="ability" style=" height:90px;"><?php if(!empty($info['ability'])) echo $info['ability']; ?></textarea>
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>特点：</label>
        </div>
        <div class="field">
          <textarea class="input" name="specialty" style=" height:90px;"><?php if(!empty($info['specialty'])) echo $info['specialty']; ?></textarea>
          <div class="tips"></div>
        </div>
      </div>
      <div class="clear"></div>
      <div class="form-group">
        <div class="label">
          <label>住址：</label>
        </div>
        <div class="field">
          <input type="text" class="input" name="address" value="<?php if(!empty($info['address'])) echo $info['address']; ?>" />
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>自我介绍：</label>
        </div>
        <div class="field">
          <textarea type="text" class="input" name="introduce" style="height:80px;"><?php if(!empty($info['introduce'])) echo $info['introduce']; ?></textarea>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>籍贯：</label>
        </div>
        <div class="field">
          <input type="text" class="input" name="origin_address" value="<?php if(!empty($info['origin_address'])) echo $info['origin_address']; ?>"/>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>民族：</label>
        </div>
        <div class="field">
          <input type="text" class="input w50" name="nation" value="<?php if(!empty($info['nation'])) echo $info['nation']; ?>"/>
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>婚姻：</label>
        </div>
        <div class="field">
          <input type="text" class="input w50" name="marriage" value="<?php if(!empty($info['marriage'])) echo $info['marriage']; ?>"/>
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>年龄：</label>
        </div>
        <div class="field">
          <input type="text" class="input w50" name="age" value="<?php if(!empty($info['age'])) echo $info['age']; ?>"  data-validate="number:年龄必须为数字" />
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>每月休息时间：</label>
        </div>
        <div class="field">
          <input type="text" class="input w50" name="rest_time" value="<?php if(!empty($info['rest_time'])) echo $info['rest_time']; ?>"  data-validate="number:请输入时间" />天
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>学历：</label>
        </div>
        <div class="field">
            <select name="status" class="input w50">
            <?php
                if(!empty($info['education'])) {
                    $s  = $info['education'];
                }
                $education_list = get_education();
            if(is_array($education_list) || $education_list instanceof \think\Collection || $education_list instanceof \think\Paginator): $i = 0; $__LIST__ = $education_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                  <option value="<?php echo $vo['code']; ?>" <?php if($s == $vo['code'] and $s != ''): ?> selected <?php endif; ?>><?php echo $vo['education']; ?></option>
                 <?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>状态：</label>
        </div>
        <div class="field">
            <select name="status" class="input w50">
            <?php if(!empty($info['status'])) $s  = $info['status']; ?>
              <option value="1" <?php if($s == 1 and $s != ''): ?> selected <?php endif; ?>></option>
              <option value="2" <?php if($s == 2 and $s != ''): ?> selected <?php endif; ?>>空闲</option>
              <option value="3" <?php if($s == 3 and $s != ''): ?> selected <?php endif; ?>>在职</option>
            </select>
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>预约状态：</label>
        </div>
        <div class="field">
            <select name="make_status" class="input w50" >
            <?php if(!empty($info['make_status'])) $ms = $info['make_status']; ?>
              <option value="1" <?php if($ms == 1 and $ms != ''): ?> selected <?php endif; ?>>空闲</option>
              <option value="3" <?php if($ms == 3 and $ms != ''): ?> selected <?php endif; ?>>已经被预约</option>
            </select>
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

<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:83:"D:\phpStudy\WWW\my\shengxian\public/../application/admin\view\goods\goods_list.html";i:1511233310;s:80:"D:\phpStudy\WWW\my\shengxian\public/../application/admin\view\public\header.html";i:1511320558;s:80:"D:\phpStudy\WWW\my\shengxian\public/../application/admin\view\public\footer.html";i:1511233311;}*/ ?>
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

<body>
    <div class="panel-head"><strong class="icon-reorder"> 商品列表</strong> <a href="" style="float:right; display:none;">添加字段</a></div>
    <div class="padding border-bottom">
      <ul class="search" style="padding-left:10px;">
        <li> <a class="button border-main icon-plus-square-o" href="<?php echo url('goods/addedit_goods'); ?>"> 添加商品</a> </li>
        <li>搜索：</li>
         <li>
           <!--
          &nbsp;&nbsp;
          推荐
          <select name="s_isvouch" class="input" onchange="changesearch()"  style="width:60px; line-height:17px;display:inline-block">
            <option value="">选择</option>
            <option value="1">是</option>
            <option value="0">否</option>
          </select>
          &nbsp;&nbsp;
          置顶
          <select name="s_istop" class="input" onchange="changesearch()"  style="width:60px; line-height:17px;display:inline-block">
            <option value="">选择</option>
            <option value="1">是</option>
            <option value="0">否</option>
          </select>
        </li>
        <if condition="$iscid eq 1">
          <li>
          </li> -->
        <!-- </if>
        <li>-->
            <form  action="<?php echo url('goods/goods_list'); ?>" method="post">
            <?php if(!empty($cat_id)) $cat = $cat_id; else  $cat ='';?>
              <select name="cat_id" class="input" style="width:200px; line-height:17px;display:inline-block;">
                <option value="">请选择分类</option>
                <?php if(is_array($cat_list) || $cat_list instanceof \think\Collection || $cat_list instanceof \think\Paginator): $i = 0; $__LIST__ = $cat_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <option value="<?php echo $vo['cat_id']; ?>" <?php if($cat != '' and $cat == $vo['cat_id']): ?>selected <?php endif; ?>><?php echo $vo['cat_name']; ?></option>
                <?php endforeach; endif; else: echo "" ;endif; ?>
              </select>
              <input type="text" placeholder="请输入搜索关键字" value="<?php if(!empty($keywords)) echo $keywords; else  echo ''; ?>" name="keywords" class="input" style="width:250px; line-height:17px;display:inline-block" />
              <button type="submit" class="button border-main icon-search"  > 搜索</button>
            </form>
        </li>
      </ul>
    </div>
    <table class="table table-hover text-center">
      <tr>
        <th width="100" style="text-align:left; padding-left:20px;"></th>
        <th>商品编号</th>
        <th>商品图片</th>
        <th>商品名称</th>
        <th>是否上架</th>
        <th>是否特价</th>
        <th>是否团购</th>
        <th>浏览次数</th>
        <th>是否推荐</th>
        <th>添加时间</th>
        <th>操作</th>
      </tr>
      <?php if(is_array($goods_list) || $goods_list instanceof \think\Collection || $goods_list instanceof \think\Paginator): $i = 0; $__LIST__ = $goods_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
        <tr>
          <td style="text-align:left; padding-left:20px;"><input type="checkbox" name="id[]" value="<?php echo $vo['goods_id']; ?>" /></td>
          <td><?php echo $vo['goods_id']; ?></td>
          <td><img src="<?php echo $vo['goods_img']; ?>" alt="" width="70" height="50" /></td>
          <td><?php echo $vo['goods_name']; ?></td>
          <td><a href="javascript:;" data-goods="<?php echo $vo['goods_id']; ?>" data-type="is_on_sale" data-status="<?php echo $vo['is_on_sale']; ?>" class="status"><?php if($vo['is_on_sale'] == 1): ?> <img src="__IMG__/yes.png" width="20" height="20"> <?php else: ?><img src="__IMG__/no.png"  width="20" height="20"> <?php endif; ?></a></td>
          <td><a href="javascript:;" data-goods="<?php echo $vo['goods_id']; ?>" data-type="is_tejia" data-status="<?php echo $vo['is_tejia']; ?>"  class="status"><?php if($vo['is_tejia'] == 1): ?> <img src="__IMG__/yes.png" width="20" height="20"> <?php else: ?><img src="__IMG__/no.png"  width="20" height="20"> <?php endif; ?></a></td>
          <td><a href="javascript:;" data-goods="<?php echo $vo['goods_id']; ?>" data-type="is_group" data-status="<?php echo $vo['is_group']; ?>" class="status"><?php if($vo['is_group'] == 1): ?> <img src="__IMG__/yes.png" width="20" height="20"> <?php else: ?><img src="__IMG__/no.png"  width="20" height="20"> <?php endif; ?></a></td>
          <td><?php echo $vo['click_count']; ?></td>
          <td><a href="javascript:;" data-goods="<?php echo $vo['goods_id']; ?>" data-type="is_recommend" data-status="<?php echo $vo['is_recommend']; ?>"  class="status"><?php if($vo['is_recommend'] == 1): ?> <img src="__IMG__/yes.png" width="20" height="20"> <?php else: ?><img src="__IMG__/no.png"  width="20" height="20"> <?php endif; ?></a></td>
          <td><?php  if(!empty($vo['add_time'])) echo date('Y-m-d H:i:s',$vo['add_time']); ?></td>
          <td><div class="button-group"> <a class="button border-main" href="<?php echo url('goods/addedit_goods','id='.$vo['goods_id']); ?>"><span class="icon-edit"></span> 查看</a> <a class="button border-red" href="javascript:void(0)" onclick="return del(<?php echo $vo['goods_id']; ?>)"><span class="icon-trash-o"></span> 删除</a> </div></td>
        </tr>
      <?php endforeach; endif; else: echo "" ;endif; ?>
        <tr>
        <td style="text-align:left; padding:19px 0;padding-left:20px;"><input type="checkbox" id="checkall"/>
          全选 </td>
        <td colspan="15" style="text-align:left;padding-left:20px;"><a href="javascript:void(0)" class="button border-red icon-trash-o" style="padding:5px 15px;" onclick="DelSelect()"> 删除</a> </tr>
      <tr>
        <td colspan="15"><?php echo $page; ?></td>
      </tr>
    </table>
<script type="text/javascript">
// 更改商品状态
$('.status').click(function(){
    var data = {};
    data.goodsid =$(this).data('goods');
    data.type = $(this).data('type');
    if($(this).data('status') == 0){
        data.status = 1;
    }else{
        data.status = 0;
    }
    $.post('update_status',data,function(msg){
        console.log(msg);
        if (msg.code == 1) {
            layer.msg('修改成功',{icon:1});
            setTimeout('window.history.go(0)',2000);
        }else{
            layer.msg(msg.msg,{icon:2});
        }
    });
});
//单个删除
function del(id){
 var  data = {"id":id};
	if(confirm("您确定要删除吗?")){
		$.post('/admin/goods/del_goods',data,function(msg){
      if(msg.code != -1){
          alert(msg.msg);
          window.history.go(0);
      }
    });
	}

}
//全选
$("#checkall").click(function(){
  $("input[name='id[]']").each(function(){
	  if (this.checked) {
		  this.checked = false;
	  }
	  else {
		  this.checked = true;
	  }
  });
})
//批量删除
function DelSelect(){
	var Checkbox=false;
  var check = [];
	$("input[name='id[]']").each(function(){
  	  if (this.checked==true) {
  		Checkbox=true;
      check.push(this.value);
	  }
	});
	if (Checkbox){
		var t=confirm("您确认要删除选中的内容吗？");
		if (t==false) return false;
    var data = {"id":check};
    $.post('/admin/goods/del_goods',data,function(msg){
      if(msg.code != -1){
          alert(msg.msg);
          window.history.go(0);
      }
    })
	}
	else{
		alert("请选择您要删除的内容!");
		return false;
	}
}


</script>
</body>

</html>

<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:83:"D:\phpStudy\WWW\my\shengxian\public/../application/admin\view\order\goods_list.html";i:1511233310;s:80:"D:\phpStudy\WWW\my\shengxian\public/../application/admin\view\public\header.html";i:1511320558;s:80:"D:\phpStudy\WWW\my\shengxian\public/../application/admin\view\public\footer.html";i:1511233311;}*/ ?>
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

<table class="layui-table table-center">
    <tr>
        <th></th>
        <th>商品名称</th>
        <th>商品图片</th>
        <th>价格</th>
        <th>会员价格</th>
        <th>数量</th>
    </tr>
    <?php if(is_array($goods_list) || $goods_list instanceof \think\Collection || $goods_list instanceof \think\Paginator): $i = 0; $__LIST__ = $goods_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
        <tr class="tabtr">
            <td><input type="checkbox" name="id[]" value="<?php echo $vo['goods_id']; ?>"></td>
            <td><?php echo $vo['goods_name']; ?></td>
            <td><img src="<?php echo $vo['goods_img']; ?>"  width="30" height="30" alt=""></td>
            <td><input type="text" name="price[]" value="<?php echo $vo['spec_price']; ?>" class="layui-input" style="width:100px;"></td>
            <td><input type="text" name="vip_price[]" value="<?php echo $vo['vip_price']; ?>" class="layui-input" style="width:100px;"></td>
            <td><input type="text" name="num[]" value="1" class="layui-input" style="width:100px;"></td>
        </tr>
    <?php endforeach; endif; else: echo "" ;endif; ?>
</table>
<div >
    <button type="button" class="layui-btn" id="colse">确认添加</button>
</div>
<script type="text/javascript">
    var index = parent.layer.getFrameIndex(window.name);
    //关闭iframe
    $('#colse').click(function(){
        var id = [],
        flag = false,
        tr = $('<tbody></tbody>');
        $.each($("input[name='id[]']"),function(k,v){
            $.each(parent.$("input[name='id[]']"),function(key,val){
                if(v.value == val.value){
                    layer.msg('商品已存在',{icon:2});
                    flag =  false;
                    return false;
                }else{
                    flag = true;
                    return true;
                }
            })
            if(v.checked == true){
                tr.append("<tr></tr>");
                tr.append($(".tabtr").eq(k).html());
                tr.append('<td><button type="button" class="layui-btn" data-method="del_goods">删除</button></td>');
                flag = true;
            }
        });
        if(flag){
            parent.$("#tab").append(tr);
            parent.$("input[type='checkbox']").attr('checked',true);
            parent.layer.msg('添加成功',{icon:1});
            parent.layer.close(index);
        }
    });
    layui.use('layer',function(){
        var layer = layui.layer;
    })
</script>

</html>

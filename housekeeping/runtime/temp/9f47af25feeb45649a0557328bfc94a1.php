<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:87:"D:\phpStudy\WWW\my\housekeeping\public/../application/admin\view\banner\banner_pos.html";i:1509696419;s:83:"D:\phpStudy\WWW\my\housekeeping\public/../application/admin\view\public\header.html";i:1509943505;s:83:"D:\phpStudy\WWW\my\housekeeping\public/../application/admin\view\public\footer.html";i:1509349979;}*/ ?>
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

<blockquote class="layui-elem-quote">图片位置管理</blockquote>
    <a href="<?php echo url('banner/addedit_pos'); ?>"><button type="button" class="layui-btn">添加位置</button></a>
<table class="layui-table" style="text-align:center;">
    <thead>
        <tr>
            <th style="width:70px;"><input type="checkbox" id="checkall" ></th>
            <th>位置名称</th>
            <th>描述</th>
            <th style="width:200px;">操作</th>
        </tr>
    </thead>
    <tbody>
        <form class="" action="" class="layui-form" method="post">
            <?php if(is_array($pos_list) || $pos_list instanceof \think\Collection || $pos_list instanceof \think\Paginator): $i = 0; $__LIST__ = $pos_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <tr>
                    <td>
                        <input type="checkbox" name="id[]" value="<?php echo $vo['pos_id']; ?>">
                    </td>
                    <td><?php echo $vo['pos_name']; ?></td>
                    <td><?php echo $vo['pos_desc']; ?></td>
                    <td>
                        <div class="layui-btn-group">
                          <a href="<?php echo url('banner/addedit_pos','id='.$vo['pos_id']); ?>"><button class="layui-btn layui-btn-normal" type="button" data-id='{}' data-method="edit">编辑</button></a>
                          <button class="layui-btn layui-btn-danger" type="button" data-method="del">删除</button>
                        </div>
                    </td>
                </tr>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </form>
        <tr>
            <td colspan="5"><button type="button" class="layui-btn layui-btn-danger" data-method="del_all">删除全部</button></td>
        </tr>
    </tbody>
</table>
<script type="text/javascript">

$('.layui-btn').on('click', function(){
    var othis = $(this), method = othis.data('method'),id = othis.data('id');
    active[method] ? active[method].call(this, othis) : '';
});
var active = {
    del:function(){
        var data = {};
        data.id = $(this).data('id');
        $.post('del_pos',data,function(msg){
            if(msg.code == 1){
                layer.msg(msg.msg,{icon:1});
                location=location;
            }else{
                layer.msg(msg.msg,{icon:2});
            }
        });
    },
    del_all:function(){
        var data = [];
        var val = $("input[name='id[]']");
        $.each(val,function(k,v){
            if(v.checked == true){
                data.push(v.value);
            }
        })
        $.post('del_pos',{"id":data},function(msg){
            if(msg.code == 1){
                layer.msg(msg.msg,{icon:1});
                location=location;
            }else{
                layer.msg(msg.msg,{icon:2});
            }
        })
    }
};
$("#checkall").click(function(){
    var input = $("input[name='id[]']");
    $.each(input,function(k,v){
        v.checked = !v.checked;
    })
});
    layui.use('form',function(){
        var form = layui.form;
        form.on('submit(formDemo)', function(data){
           layer.msg(JSON.stringify(data.field));
           return false;
         });
    })
</script>

</html>

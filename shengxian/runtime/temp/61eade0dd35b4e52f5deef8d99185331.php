<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:89:"D:\phpStudy\WWW\my\shengxian\public/../application/admin\view\shipping\shipping_area.html";i:1511233311;s:80:"D:\phpStudy\WWW\my\shengxian\public/../application/admin\view\public\header.html";i:1511320558;s:80:"D:\phpStudy\WWW\my\shengxian\public/../application/admin\view\public\footer.html";i:1511233311;}*/ ?>
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

<blockquote class="layui-elem-quote layui-quote-nm">管理配送区域</blockquote>
<body>
    <table class="layui-table">
        <tr>
            <th style="width:20%;"></th>
            <th style="width:60%;">省</th>
            <th style="width:20%;">管理</th>
        </tr>
        <?php if(is_array($province) || $province instanceof \think\Collection || $province instanceof \think\Paginator): $i = 0; $__LIST__ = $province;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <tr>
                <td><?php echo $vo['id']; ?></td>
                <td><?php echo $vo['name']; ?></td>
                <td><button type="button" class="layui-btn layui-btn-normal" data-id="<?php echo $vo['id']; ?>" data-method="edit_conf">管理</button></td>
            </tr>
        <?php endforeach; endif; else: echo "" ;endif; ?>
    </table>
</body>
<script type="text/javascript">
var active = {
    edit_conf:function(){
        console.log(id);
        layer.open({
          type: 2,
          area: ['900px', '680px'],
          fixed: false, //不固定
          maxmin: true,
          content: 'area_list?id='+id
        });
    },
};

$('.layui-btn').on('click', function(){
    var othis = $(this), method = othis.data('method');id=othis.data('id');
    active[method] ? active[method].call(this, othis) : '';
});
    // layui.use('form', function(){
    //   var form = layui.form;
    //
    //   //监听提交
    //   form.on('submit(formDemo)', function(data){
    //     layer.msg(JSON.stringify(data.field));
    //     return false;
    //   });
    // });
</script>

</html>

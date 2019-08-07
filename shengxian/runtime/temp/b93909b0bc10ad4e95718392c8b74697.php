<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:86:"D:\phpStudy\WWW\my\shengxian\public/../application/admin\view\order\addedit_order.html";i:1511413790;s:80:"D:\phpStudy\WWW\my\shengxian\public/../application/admin\view\public\header.html";i:1511320558;s:80:"D:\phpStudy\WWW\my\shengxian\public/../application/admin\view\public\footer.html";i:1511233311;}*/ ?>
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
<div class="panel admin-panel">
  <div class="panel-head" id="add"><strong><span class="icon-pencil-square-o"></span>添加订单</strong></div>
  <div class="body-content">
    <form method="post" class="form-x" action="" enctype="multipart/form-data">
      <div class="form-group">
        <div class="label">
          <label>订单编号：</label>
        </div>
        <div class="field">
          <input type="text" class="input w50" value="<?php if(!empty($info['order_sn'])) echo $info['order_sn']; ?>" name="order_sn" readonly />订单编号自动生成
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>手机号：</label>
        </div>
        <div class="field">
          <input type="text" class="input w50" id="mobile" name="mobile" value="<?php if(!empty($info['mobile'])) echo $info['mobile']; ?>"/>
          <input type="hidden" class="input w50" name="user_id" value="<?php if(!empty($info['user_id'])) echo $info['user_id']; ?>"/>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>用户名：</label>
        </div>
        <div class="field">
          <input type="text" class="input w50" name="user_name" value="<?php if(!empty($info['user_name'])) echo $info['user_name']; ?>"/>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>用户地址：</label>
        </div>
        <div class="field">
          <input type="text" class="input w50" name="address" value="<?php if(!empty($info['address'])) echo $info['address']; ?>"/>
        </div>
      </div>
      <div class="form-group" id="show" style="display:none;">
        <div class="label">
          <label>选择用户地址：</label>
        </div>
        <div class="field">
          <button type="button" class="layui-btn" data-method="get_user_address">选择用户地址</button>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>订单状态：</label>
        </div>
        <div class="field">
          <!-- <input type="text" class="input w50" name="origin_address" value="..."/> -->
          <?php if(!empty($info['order_status'])) $os = $info['order_status']; else $os = '';?>
          <select class="input w50" name="order_status">
              <?php if(is_array($order_status) || $order_status instanceof \think\Collection || $order_status instanceof \think\Paginator): $i = 0; $__LIST__ = $order_status;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <option value="<?php echo $vo['code']; ?>" <?php if($os != '' and $os == $vo['code']): ?> selected<?php endif; ?>><?php echo $vo['status']; ?></option>
              <?php endforeach; endif; else: echo "" ;endif; ?>
          </select>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>配送信息：</label>
        </div>
        <div class="field" style="display:inline-block;">
          <input type="text" class="input w50" name="shipping_id" value="配送名称"/>
          <?php if(!empty($info['shipping_status'])) $ss = $info['shipping_status']; else $ss = '';?>
          <select class="input w50" name="shipping_status">
              <?php if(is_array($shipping_status) || $shipping_status instanceof \think\Collection || $shipping_status instanceof \think\Paginator): $i = 0; $__LIST__ = $shipping_status;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <option value="<?php echo $vo['code']; ?>" <?php if($ss != '' and $ss == $vo['code']): ?> selected<?php endif; ?>><?php echo $vo['status']; ?></option>
              <?php endforeach; endif; else: echo "" ;endif; ?>
          </select>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>支付信息：</label>
        </div>
        <div class="field" style="display:inline-block;" >
          <input type="text" class="input w50" name="pay_name" value="支付名称"/>
          <?php if(!empty($info['pay_status'])) $ps = $info['pay_status']; else $ps = '';?>
          <select class="input w50" name="pay_status">
              <?php if(is_array($pay_status) || $pay_status instanceof \think\Collection || $pay_status instanceof \think\Paginator): $i = 0; $__LIST__ = $pay_status;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <option value="<?php echo $vo['code']; ?>" <?php if($ps != '' and $ps == $vo['code']): ?> selected<?php endif; ?>><?php echo $vo['status']; ?></option>
              <?php endforeach; endif; else: echo "" ;endif; ?>
          </select>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>商品信息：</label>
        </div>
        <div class="field">
            <table class="table table-hover text-center" id="tab">
                <tr>
                    <th><input type="checkbox" id="checkall" value="goods_id"></th>
                    <th>商品名称</th>
                    <th>商品图片</th>
                    <th>单价</th>
                    <th>会员价格</th>
                    <th>数量</th>
                    <th>操作</th>
                </tr>
                <?php if(!empty($info['goods'])): if(is_array($info['goods']) || $info['goods'] instanceof \think\Collection || $info['goods'] instanceof \think\Paginator): $i = 0; $__LIST__ = $info['goods'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <tr>
                            <td><input type="checkbox" name="id[]" value="<?php echo $vo['goods_id']; ?>" checked > </td>
                            <td><?php echo $vo['goods_name']; ?></td>
                            <td><img src="<?php echo $vo['goods_img']; ?>" width="30" height="30" alt=""></td>
                            <td><input type="text" class="layui-input" style="width:100px;" name="price[]" value="<?php echo $vo['price']; ?>"></td>
                            <td><input type="text" class="layui-input" style="width:100px;" name="vip_price[]" value="<?php echo $vo['vip_price']; ?>"></td>
                            <td><input type="text" class="layui-input" style="width:100px;" name="num[]" value="<?php echo $vo['num']; ?>"></td>
                            <td><button type="button" class="layui-btn" data-method="del_goods">删除</button></td>
                        </tr>
                    <?php endforeach; endif; else: echo "" ;endif; endif; ?>
            </table>
            <button type="button" class="layui-btn" data-method="get_goods_list" data-id="<?php echo $info['order_id']; ?>">添加商品</button>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>订单总金额：</label>
        </div>
        <div class="field">
          <input type="text" class="input w50" name="total_price" value="<?php if(!empty($info['total_price'])) echo $info['total_price']; ?>"/>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>留言信息：</label>
        </div>
        <div class="field">
          <input type="text" class="input w50" name="leavmsg" value="<?php if(!empty($info['leavmsg'])) echo $info['leavmsg']; ?>"/>
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
<div style="display:none;" id="address_list">
    <div id="c_list">

    </div>
    <button class="layui-btn" data-method="address">确认</button>
</div>
<script type="text/javascript">

    $('#mobile').blur(function(){
        $.get('address_list?mobile='+$(this).val(),function(msg){
            $('#c_list').html(msg);
            if(msg){
                $('#show').css('display','block');
            }
        })
    });
    var active = {
        get_user_address:function(){
            var that = this;
            layer.open({
              type: 1,
              title: '选择用户地址',
              closeBtn: 1,
              area: ['800px', '600px'],
              shadeClose: true,
              content: $("#address_list")
            });
        },
        get_goods_list:function(){
            console.log(1);
            var order_id = $(this).data('id');
            layer.open({
                type:2,
                title:'商品列表',
                area: ['800px','600px'],
                content:'goods_list?id='+order_id
            })

        },
        address:function(){
            $name = $("input[name='user_name']");
            $address = $("input[name='address']");
            $mobile = $("input[name='mobile']");
            $user_id = $("input[name='user_id']");
            $.each($("input[name='add_id']"),function(k,v){
                    if(v.checked == true){
                        $.get('get_address?id='+v.value,function(msg){
                            $name.val(msg.ad_name) ;
                            $address.val(msg.ad_address);
                            $mobile.val(msg.ad_mobile);
                            $user_id.val(msg.user_id);
                        });
                    }
            });
            layer.closeAll();
        },
        del_goods:function(){
            $(this).parents('tr').remove();
        }
    }
    $('.layui-btn').on('click', function(){
        var othis = $(this), method = othis.data('method');
        active[method] ? active[method].call(this, othis) : '';
      });
</script>
</body>

</html>

<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:89:"D:\phpStudy\WWW\my\housekeeping\public/../application/admin\view\order\addedit_order.html";i:1511232378;s:83:"D:\phpStudy\WWW\my\housekeeping\public/../application/admin\view\public\header.html";i:1511232379;s:83:"D:\phpStudy\WWW\my\housekeeping\public/../application/admin\view\public\footer.html";i:1511232379;}*/ ?>
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

<body>
<div class="panel admin-panel">
  <div class="panel-head" id="add"><strong><span class="icon-pencil-square-o"></span>增加员工</strong></div>
  <div class="body-content">
    <form method="post" class="form-x" action="" enctype="multipart/form-data">
      <div class="form-group">
        <div class="label">
          <label>订单编号：</label>
        </div>
        <div class="field">
          <input type="text" class="input w50" value="<?php if(!empty($info['order_sn'])) echo $info['order_sn']; ?>" name="order_sn" data-validate="" readonly />订单编号自动生成
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>家政类型:</label>
        </div>
        <div class="field">
          <select name="hk_type" class="input w50">
            <option value="0">请选择家政类型</option>
            <?php if(!empty($info['position_id'])) $poid = $info['position_id']; else $poid = '';if(is_array($position_list) || $position_list instanceof \think\Collection || $position_list instanceof \think\Paginator): $i = 0; $__LIST__ = $position_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
              <option value="<?php echo $vo['id']; ?>" <?php if($poid != '' and $poid == $vo['id']): ?> selected <?php endif; ?> ><?php echo $vo['position_name']; ?></option>
            <?php endforeach; endif; else: echo "" ;endif; ?>
          </select>
          <div class="tips"></div>
        </div>
      </div>
      <div class="clear"></div>
      <?php if(!empty($info['is_reserve']))$re = $info['is_reserve']; else $re = ''; ?>
      <div class="form-group">
        <div class="label">
          <label>是否预约：</label>
        </div>
        <div class="field">
          <select name="is_reserve" class="input w50">
            <option value="2" <?php if($re != '' and 2 == $re): ?> selected <?php endif; ?>>否</option>
            <option value="1" <?php if($re != '' and 1 == $re): ?> selected <?php endif; ?>>是</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>用户地址：</label>
        </div>
        <div class="field">
          <button type="button" id="add_list" class="layui-btn"> 选择用户地址</button>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>订单价格：</label>
        </div>
        <div class="field">
          <input type="text" class="input w50" name="order_price" value="<?php if(!empty($info['order_price'])) echo $info['order_price']; ?>"/>
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>订单状态：</label>
        </div>
        <div class="field">
            <?php if(!empty($info['order_status'])) $os = $info['order_status'] ; else $os = ''; ?>
          <select name="order_status" class="input w50">
            <option value="1" {if condition="$os neq '' and 1 eq $os"}>进行中</option>
            <option value="2" {if condition="$os neq '' and 2 eq $os"}>已完成</option>
          </select>
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>支付状态：</label>
        </div>
        <div class="field">

                <?php if(!empty($info['pay_status'])) $ps = $info['pay_status'] ; else $ps = ''; ?>
          <select name="pay_status" class="input w50">
            <option value="1" {if condition="$ps neq '' and 1 eq $ps"}>待支付</option>
            <option value="2" {if condition="$ps neq '' and 2 eq $ps"}>已支付</option>
          </select>
          <div class="tips"></div>
        </div>
      </div>
      <div class="form-group">
        <div class="label">
          <label>开始时间：</label>
        </div>
        <div class="field">
          <input type="text" class="input w50" name="start_time" value="<?php if(!empty($info['start_time'])) echo $info['start_time']; else echo '';?>" id="stime" />
          <div class="tips"></div>
        </div>
      </div>

      <div class="form-group">
        <div class="label">
          <label>需求：</label>
        </div>
        <div class="field">
          <input type="text" class="input w50" name="demand" value="<?php if(!empty($info['demand'])) echo $info['demand']; else echo '';?>"/>
          <div class="tips"></div>
        </div>
      </div>

      <div id="address_list" class="layui-table" style="display:none;text-align:center;">
          <table>
              <tr>
                  <th></th>
                  <th>姓名</th>
                  <th>手机号</th>
                  <th>省</th>
                  <th>市</th>
                  <th>区</th>
                  <th>具体地址</th>
              </tr>
              <?php if(is_array($add_list) || $add_list instanceof \think\Collection || $add_list instanceof \think\Paginator): $i = 0; $__LIST__ = $add_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                  <tr>
                      <td><input type="radio" name="ad_id"  value="<?php echo $vo['ad_id']; ?>"></td>
                      <td><?php echo $vo['name']; ?></td>
                      <td><?php echo $vo['mobile']; ?></td>
                      <td><?php echo $vo['province']; ?></td>
                      <td><?php echo $vo['city']; ?></td>
                      <td><?php echo $vo['area']; ?></td>
                      <td><?php echo $vo['add']; ?></td>
                  </tr>
              <?php endforeach; endif; else: echo "" ;endif; ?>
          </table>
          <font color="red" >注：选择地址后不用添加</font>
          <div>
                  <table class="layui-table" style="text-align:center;">
                      <tr>
                          <td colspan="2"><h2>添加订单地址</h2></td>
                      </tr>
                      <tr>
                          <td>姓名:</td>
                          <td><input type="text" name="name" class="input" value="<?php if(!empty($info['name'])) echo $info['name']; else echo ''; ?> "></td>
                      </tr>
                      <tr>
                          <td>手机号:</td>
                          <td><input type="text" name="mobile" class="input" value="<?php if(!empty($info['mobile'])) echo $info['mobile']; else echo ''; ?> "></td>
                      </tr>
                      <tr>
                          <td>具体地址:</td>
                          <td><input type="text" name="add" class="input" value="<?php if(!empty($info['add'])) echo $info['add']; else echo ''; ?>"></td>
                      </tr>
                      <tr>
                          <td colspan="2"><button type="button" class="layui-btn" id="close">确定</button></td>
                      </tr>
                  </table>
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
<script type="text/javascript">
layui.use(['layer','laydate'],function(){
    var layer = layui.layer,
    laydate = layui.laydate;
    laydate.render({
        elem:"#stime",
        type:'datetime'
    })

})
    $("#add_list").on('click',function(){
        layer.open({
            type: 1,
            title: '选择用户地址',
            area: ['630px', '360px'],
            shade: 0.8,
            closeBtn: 1,
            shadeClose: true,
            content: $("#address_list")
        })
    })
    $("#close").on('click',function(){
        layer.closeAll();
    })
</script>
</body>

</html>

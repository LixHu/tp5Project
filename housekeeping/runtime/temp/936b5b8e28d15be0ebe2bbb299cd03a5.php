<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:76:"/home/wwwroot/housekeeping/public/../application/admin/view/admin/right.html";i:1510103392;}*/ ?>
<!doctype html>
<html class="no-js">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Amaze UI Admin index Examples</title>
<meta name="description" content="这是一个 index 页面">
<meta name="keywords" content="index">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta name="renderer" content="webkit">
<meta http-equiv="Cache-Control" content="no-siteapp" />
<link rel="icon" type="image/png" href="__PUBLIC__/assets/i/favicon.png">
<link rel="apple-touch-icon-precomposed" href="__PUBLIC__/assets/i/app-icon72x72@2x.png">
<meta name="apple-mobile-web-app-title" content="Amaze UI" />
<link rel="stylesheet" href="__PUBLIC__/assets/css/amazeui.min.css"/>
<link rel="stylesheet" href="__PUBLIC__/assets/css/admin.css">
<script src="__PUBLIC__/assets/js/jquery.min.js"></script>
<script src="__PUBLIC__/assets/js/app.js"></script>
</head>
<body>
<!--[if lte IE 9]><p class="browsehappy">升级你的浏览器吧！ <a href="http://www.htmlsucai.com" target="_blank">升级浏览器</a>以获得更好的体验！</p><![endif]-->

</head>
<body>
<div class=" admin-content">
<div class="admin">
   <div class="admin-index">
      <dl data-am-scrollspy="{animation: 'slide-right', delay: 100}">
        <dt class="qs"><i class="am-icon-shopping-cart"></i></dt>
        <dd><?php echo $gcount; ?></dd>
        <dd class="f12">家政人员数量</dd>
      </dl>
      <dl data-am-scrollspy="{animation: 'slide-right', delay: 300}">
        <dt class="cs"><i class="am-icon-users"></i></dt>
        <dd><?php echo $ucount; ?></dd>
        <dd class="f12">会员数量</dd>
      </dl>
      <dl data-am-scrollspy="{animation: 'slide-right', delay: 600}">
        <dt class="hs"><i class="am-icon-area-chart"></i></dt>
        <dd><?php echo $ocount; ?></dd>
        <dd class="f12">今日订单数</dd>
      </dl>
      <dl data-am-scrollspy="{animation: 'slide-right', delay: 900}">
        <dt class="ls"><i class="am-icon-cny"></i></dt>
        <dd>455</dd>
        <dd class="f12">全部收入</dd>
      </dl>
    </div>
    <div class="admin-biaoge">
      <div class="xinxitj">信息概况</div>
      <table class="am-table">
        <!-- <thead>
          <tr>
            <th>团队统计</th>
            <th>全部会员</th>
            <th>全部未激活</th>
            <th>今日新增</th>
            <th>今日未激活</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>普卡</td>
            <td>普卡</td>
            <td><a href="#">4534</a></td>
            <td>+20</td>
            <td> 4534 </td>
          </tr>
        </tbody>
      </table>
      <table class="am-table">
        <thead>
          <tr>
            <th>团队统计</th>
            <th>全部会员</th>
            <th>全部未激活</th>
            <th>今日新增</th>
            <th>今日未激活</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>普卡</td>
            <td>普卡</td>
            <td>4534</td>
            <td>+50</td>
            <td> 4534 </td>
          </tr>
        </tbody>
      </table>
      <table class="am-table">
        <thead>
          <tr>
            <th>资金统计</th>
            <th>账户总收入</th>
            <th>账户总支出</th>
            <th>账户余额</th>
            <th>今日收入</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>普卡</td>
            <td>普卡</td>
            <td>4534</td>
            <td>+20</td>
            <td> 4534 </td>
          </tr>
        </tbody>
        -->
      </table>
    </div>
    <div class="shuju">
      <div class="shujuone">
        <dl>
          <dt>  </dt>
          <dt>   </dt>
          <dt>  </dt>
        </dl>
        <ul>
          <h2></h2>
          <li></li>
        </ul>
      </div>
      <div class="shujutow">
        <dl>
          <dt>  </dt>
          <dt>   </dt>
          <dt>  </dt>
        </dl>
        <ul>
          <h2></h2>
          <li></li>
        </ul>
      </div>
      <div class="slideTxtBox">
        <div class="hd">
          <ul>
            <!-- <li>其他信息</li> -->
            <!-- <li>工作进度表</li> -->
          </ul>
        </div>
        <div class="bd">
          <ul>
            <table width="100%" class="am-table">
              <tbody>
                <tr>
                  <td width="7%"  align="center">1 </td>
                  <!-- <td width="83%" >工作进度名称</td> -->
                  <!-- <td width="10%"  align="center"><a href="#">10%</a></td> -->
                </tr>
              </tbody>
            </table>
          </ul>
          <ul>
            <table class="am-table">
              <tbody>
                <tr>
                  <!-- <td>普卡</td>
                  <td>普卡</td>
                  <td><a href="#">4534</a></td>
                  <td>+20</td>
                  <td> 4534 </td> -->
                </tr>
              </tbody>
            </table>
          </ul>
        </div>
      </div>
      <script type="text/javascript">jQuery(".slideTxtBox").slide();</script>
</div>

    <div class="foods">
    	<ul>版权所有@2015</ul>
    	<dl><a href="" title="返回头部" class="am-icon-btn am-icon-arrow-up"></a></dl>
    </div>
</div>
</div>
</div>
<!--[if lt IE 9]>
<script src="http://libs.baidu.com/jquery/1.11.1/jquery.min.js"></script>
<script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
<script src="__PUBLIC__/assets/js/polyfill/rem.min.js"></script>
<script src="__PUBLIC__/assets/js/polyfill/respond.min.js"></script>
<script src="__PUBLIC__/assets/js/amazeui.legacy.js"></script>
<![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<script src="__PUBLIC__/assets/js/amazeui.min.js"></script>
<!--<![endif]-->



</body>
</html>

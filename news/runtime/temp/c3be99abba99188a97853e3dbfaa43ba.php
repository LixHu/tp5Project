<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:73:"D:\phpStudy\WWW\my\news\public/../application/admin\view\admin\index.html";i:1511243917;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<title>后台管理中心</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
</head>
<script type="text/javascript">
function SetWinHeight(obj){
	var win=obj;
	if (document.getElementById){
		if (win && !window.opera){
			if (win.contentDocument && win.contentDocument.body.offsetHeight)
			win.height = win.contentDocument.body.offsetHeight+40;
			else if(win.Document && win.Document.body.scrollHeight)
			win.height = win.Document.body.scrollHeight+40;
		}
	}
}
</script>
<frameset rows="100,*" cols="*" scrolling="No" framespacing="0" frameborder="no" border="0">
	<frame src="<?php echo url('admin/index/head'); ?>" name="headmenu" id="mainFrame" title="mainFrame"><!-- 引用头部 -->
	<!-- 引用左边和主体部分 -->
		<frameset rows="100*" cols="220,*" scrolling="No" framespacing="0" frameborder="no" border="0">
		 	<frame src="<?php echo url('admin/index/left'); ?>" name="leftmenu" id="mainFrame" title="mainFrame">
		 	<frame src="<?php echo url('admin/index/right'); ?>" name="main" scrolling="yes" noresize="noresize" id="rightFrame" title="rightFrame" style="overflow:scoll;">
		</frameset>
</frameset>
</html>

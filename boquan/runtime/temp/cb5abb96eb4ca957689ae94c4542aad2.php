<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:66:"F:\zm\my\boquan\public/../application/index\view\index\invite.html";i:1521086035;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>博全云</title>
    <script src="_ago/lib/jquery-2.1.4.js"></script>
</head>
<body>
    博全云邀请你进入<?php echo $ginfo->gname; ?>
    <button onclick="agree()">同意</button>
    <button onclick="refuse()">拒绝</button>
    <script>
        var agree = function () {
            var data = {};
            data = <?php echo $uinfo; ?>;
            data.type = 1;
            $.post('accept',data,function(res) {
                alert(res.msg);
                if(res.code == 1){
                    location.reload();
                }
            })
        }
    </script>
</body>
</html>
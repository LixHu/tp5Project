<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:72:"F:\zm\my\boquan\public/../application/boquan\view\system\admin_list.html";i:1521019431;s:58:"F:\zm\my\boquan\application\boquan\view\public\header.html";i:1520643971;s:58:"F:\zm\my\boquan\application\boquan\view\public\footer.html";i:1520643971;}*/ ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="renderer" content="webkit">
    <link rel="shortcut icon" href="_icon/favicon.ico" type="image/vnd.microsoft.icon">
    <link rel="icon" href="_icon/favicon.ico" type="image/vnd.microsoft.icon">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <title>博权云后台管理系统</title>
    <link href="_css/bootstrap.min.css" rel="stylesheet">
    <link href="_css/sb-admin.css" rel="stylesheet">
    <link href="_font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="_css/style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="_css/select2.min.css">
    <link href="_css/AdminLTE.min.css" rel="stylesheet" type="text/css"/>
    <script src="_js/jquery.js"></script>
    <script src="_js/bootstrap.min.js"></script>
    <!--<script src="_js/closable-tab-div.js"></script>-->
    <script src="_js/public.js"></script>
    <script src="_js/echarts.js"></script>
    <script src="_js/vue.min.js"></script>
    <link rel="stylesheet" href="_css/select2.min.css">
    <script src="_js/select2.min.js"></script>
    <!--<script src="_js/jqPaginator.js" type="text/javascript"></script>-->
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <link href="http://cdn.bootcss.com/bootstrap-daterangepicker/2.1.25/daterangepicker.css" rel="stylesheet"/>
    <script src="http://cdn.bootcss.com/bootstrap-daterangepicker/2.1.25/moment.min.js"></script>
    <script src="http://cdn.bootcss.com/bootstrap-daterangepicker/2.1.25/daterangepicker.js"></script>
    <![endif]-->
    <script src="_js/layer/layer.js"></script>
    <script src="_js/laydate/laydate.js"></script>
</head>
<body>
<style>
    #vue-dingyi-paging ul {
        list-style: none;
        margin-top: 10px;
    }

    #vue-dingyi-paging ul li {
        margin: 0 5px;
    }

    #vue-dingyi-paging ul li,
    .pageLink {
        display: inline-block;
        width: 40px;
        height: 40px;
        background: #F0F0F0;
        color: #ABABAB;
        border-radius: 3px;
        text-align: center;
        text-decoration: none;
        line-height: 40px;
    }

    #vue-dingyi-paging ul li .pageLink:hover {
        background: #ABABAB;
        color: #FFFFFF;
    }

    #vue-dingyi-paging ul li .curPage {
        background: #81C06F;
        color: #FFFFFF;
    }
</style>

<link rel="stylesheet" href="_css/all.css">
<div class="content" id="con" v-cloak>
    <div class="col-md-12 ">
        <div class="top">
            <div class="float_left">
                    <span class="word">
                        手机号:
                    </span>
                <div class="input">
                    <input type="text" v-model="uname">
                </div>
            </div>
            <div style="padding-top:20px;">
                <button type="button" class="btn btn-primary" @click="getData()">搜索</button>
                <button type="button" class="btn btn-primary" @click="add()">邀请员工</button>
                <!--<button type="button" class="btn btn-primary" @click=""></button>-->
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <table id="task-table" class="table table-select table-hover table-bordered text-center"
               style="table-layout: fixed; margin:30px 0 50px 0;">
            <thead>
            <tr class="active table-head">
                <th>员工姓名</th>
                <!-- <th>账户密码</th> -->
                <th>工号</th>
                <th>手机号</th>
                <th>角色权限</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
                <tr v-for="item in userdata">
                    <td>{{item.rela_name}}</td>
                    <td>{{item.job_num}}</td>
                    <td>{{item.mobile}}</td>
                    <!-- <td>{{item.rela_name}}</td> -->
                    <td>{{item.rname}}</td>
                    <td>
                        <div class="btn btn-group">
                            <button class="btn btn-primary" @click="edit(item.uid)">修改</button>
                            <button class="btn btn-danger" @click="del(item.uid)">删除</button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div style="display: none;padding: 10px;" id="content" class="col-md-12">
        <div style="padding:10px;">
            <div style="padding:10px;overflow: auto;">
                <label class="col-md-2">姓名：</label>
                    <div class="col-md-10">
                    <input type="text" name="account" class="form-control" v-model="rela_name"/>
                </div>
            </div>
            <div style="padding:10px;overflow: auto;">
                <label class="col-md-2">手机号：</label>
                <div class="col-md-10">
                    <input type="text" name="mobile" class="form-control" v-model="mobile" />
                </div>
            </div>
            <div style="padding:10px;overflow: auto;">
                <label class="col-md-2">角色：</label>
                <div class="col-md-10">
                    <select v-model="roleid" class="form-control">
                        <option value="">请选择</option>
                        <?php if(is_array($rolelist) || $rolelist instanceof \think\Collection || $rolelist instanceof \think\Paginator): $i = 0; $__LIST__ = $rolelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                            <option value="<?php echo $vo['rid']; ?>"><?php echo $vo['rname']; ?></option>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>
            </div>
            <div style="padding:10px;overflow: auto;">
                <label class="col-md-2">员工编号：</label>
                <div class="col-md-10">
                    <input type="text" name="account" class="form-control" v-model="job_num"/>
                </div>
            </div>
        </div>
        <div class="btn btn-group" style="float: right;">
            <button type="button" class="btn btn-primary" @click="SubRole">提交</button>
            <button type="button" class="btn btn-normal" @click="layer.closeAll();">取消</button>
        </div>
    </div>
    <!--<div style="display: none;padding: 10px;" id="content" class="col-md-12">-->
        <!--<div style="margin-top: 10px;">-->
            <!--<label class="col-md-2">账户：</label>-->
            <!--<div class="col-md-10">-->
                <!--<input type="text" name="account" class="form-control" v-model="account"/>-->
            <!--</div>-->
        <!--</div>-->
        <!--<div>-->
            <!--<label class="col-md-2" style="margin-top: 20px;">密码：</label>-->
            <!--<div class="col-md-10" style="margin-top: 20px;">-->
                <!--<input type="password" class="form-control" v-model="password" />-->
            <!--</div>-->
        <!--</div>-->
        <!--<div>-->
            <!--<label class="col-md-2" style="margin-top: 20px;">姓名：</label>-->
            <!--<div class="col-md-10" style="margin-top: 20px;">-->
                <!--<input type="text" class="form-control" v-model="rela_name" />-->
            <!--</div>-->
        <!--</div>-->
        <!--<div>-->
            <!--<label class="col-md-2" style="margin-top: 20px;">手机号：</label>-->
            <!--<div class="col-md-10" style="margin-top: 20px;">-->
                <!--<input type="text" class="form-control" v-model="mobile" />-->
            <!--</div>-->
        <!--</div>-->
        <!--<div>-->
            <!--<label class="col-md-2" style="margin-top: 20px;">角色：</label>-->
            <!--<div class="col-md-10" style="margin-top: 20px;">-->
                <!--<select name="role" class="form-control" v-model="roleid">-->
                    <!--<option value="">请选择角色</option>-->
                    <!--<?php if(is_array($rolelist) || $rolelist instanceof \think\Collection || $rolelist instanceof \think\Paginator): $i = 0; $__LIST__ = $rolelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>-->
                        <!--<option value="<?php echo $vo['rid']; ?>"><?php echo $vo['rname']; ?></option>-->
                    <!--<?php endforeach; endif; else: echo "" ;endif; ?>-->
                <!--</select>-->
            <!--</div>-->
        <!--</div>-->
        <!--<div class="btn btn-group" style="float: right;">-->
            <!-- <button type="button" class="btn btn-primary" @click="SubRole">提交</button>
            <button type="button" class="btn btn-normal" @click="layer.closeAll();">取消</button> -->
        <!--</div>-->
    <!--</div>-->
</div>
<script>
    var el = new Vue({
        el:"#con",
        data:{
            uname:'',
            userdata:[],
            account:'',
            password:'',
            roleid:'',
            uid:'',
            mobile:'',
            job_num:'',
            rela_name:''
        },
        methods:{
            getData:function(){
                var _self = this,
                    data = {};
                if(_self.uname){
                    data.mobile = _self.uname;
                }
                $.post('getSearch',data,function(res){
                    _self.userdata = res;
                })
            },
            add:function () {
                this.account = '';
                this.password = '';
                this.roleid = '';
                this.uid = '';
                this.mobile = '';
                this.rela_name = '';
                this.job_num = '';
                $("input[name='mobile']").removeAttr('readonly');
                layer.open({
                    type:1,
                    title:'邀请员工',
                    area:['600px','400px'],
                    shadeClose:true,
                    content:$("#content")
                })
            },
            edit:function (uid) {
                var $this = this,
                    data = {};
                $this.uid = uid;
                data.uid = uid;
                $("input[name='mobile']").attr('readonly','readonly');
                $.post('getInfo',data,function (res) {
                    if(res.code == 1){
                        $this.account = res.data.user_name;
                        $this.password = '';
                        $this.rela_name = res.data.rela_name;
                        $this.mobile = res.data.mobile;
                        $this.roleid = res.data.rid;
                        $this.job_num = res.data.job_num;
                    }
                })
                layer.open({
                    type:1,
                    title:'添加账户',
                    area:['600px','400px'],
                    shadeClose:true,
                    content:$("#content")
                })
            },
            del:function (uid) {
                layer.confirm('确定要删除吗',{
                    btn:['确定','取消']
                },function () {
                    var data = {};
                    data.uid = uid;
                    $.post("delUser",data,function (res) {
                        if(res.code == 1){
                            layer.msg(res.msg,{icon:1});
                            $this.getData();
                        }else{
                            layer.msg(res.msg,{icon:2});
                        }
                    })
                })
            },
            SubRole:function () {
                var data = {};
                data.uid = this.uid;
                data.user_name = this.account;
                data.password = this.password;
                data.rela_name = this.rela_name;
                data.mobile = this.mobile;
                data.job_num = this.job_num;
                data.roleid = this.roleid;
                var $this = this;
                $.post("SubRole",data,function (res) {
                    if(res.code == 1){
                        layer.msg(res.msg,{icon:1});
                        setTimeout(function () {
                            $this.getData();
                            layer.closeAll();
                            $this.account = '';
                            $this.password = '';
                            $this.mobile = '';
                            $this.job_num = '';
                            $this.roleid = '';
                            $this.uid = '';
                            location.reload();
                        },2000);
                    }else{
                        layer.msg(res.msg,{icon:2});
                    }
                })
            }
        }
    })
    el.getData();
</script>
</body>
</html>
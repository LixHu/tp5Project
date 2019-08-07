<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:69:"F:\zm\my\boquan\public/../application/boquan\view\admin\setgroup.html";i:1521083380;s:58:"F:\zm\my\boquan\application\boquan\view\public\header.html";i:1520643971;s:58:"F:\zm\my\boquan\application\boquan\view\public\footer.html";i:1520643971;}*/ ?>
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
                        账户名称:
                    </span>
                <div class="input">
                    <input type="text" v-model="gname" >
                </div>
            </div>
            <!--<div class="float_left">-->
                    <!--<span class="status">-->
                        <!--用户状态：-->
                    <!--</span>-->
                <!--<div class="_status">-->
                    <!--<select v-model="status" @change="getData()">-->
                        <!--<option value="">请选择</option>-->
                        <!--<option value="1">启用</option>-->
                        <!--<option value="2">禁用</option>-->
                    <!--</select>-->
                <!--</div>-->
            <!--</div>-->
            <div class="float_left" style="padding-top:20px;">
                <button type="button" class="btn btn-primary" @click="getData()">搜索</button>
                <button type="button" class="btn btn-primary" @click="add()">添加</button>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <table id="task-table" class="table table-select table-hover table-bordered text-center"
               style="table-layout: fixed; margin:30px 0 50px 0;">
            <thead>
            <tr class="active table-head">
                <th>公司名称</th>
                <th>简介</th>
                <th>负责人</th>
                <!--<th>密码</th>-->
                <!--<th>联系人</th>-->
                <!--<th>手机号</th>-->
                <th>电话</th>
                <th>地址</th>
                <!--<th>账户状态</th>-->
                <th>操作</th>
            </tr>
            </thead>
            <tbody v-for="item in groupdata">
            <tr>
                <td>{{item.gname}}</td>
                <td>{{item.gdesc}}</td>
                <td>{{item.rela_name?item.rela_name:'暂无'}}</td>
                <!--<td>*******</td>-->
                <!--<td>{{item.contacts}}</td>-->
                <!--<td>{{item.mobile}}</td>-->
                <td>{{item.tel}}</td>
                <td>{{item.address}}</td>
                <!--<td>-->
                    <!--<span v-if="item.groupstatus == 1">启用</span>-->
                    <!--<span v-if="item.groupstatus == 0">禁用</span>-->
                <!--</td>-->
                <td>
                    <button type="button" @click="appoint(item.gid)" class="btn btn-primary">添加负责人</button>
                    <button type="button" @click="edit(item.gid)" class="btn btn-primary">编辑</button>
                    <button type="button" @click="del(item.gid)" class="btn btn-danger">删除</button>
                </td>
            </tr>
            <?php if(Session('user')->pid == 0): ?>
                <tr v-for="item in item.child">
                    <td>├ {{item.gname}}</td>
                    <td>{{item.gdesc}}</td>
                    <td>{{item.rela_name?item.rela_name:'暂无'}}</td>
                    <!--<td>*******</td>-->
                    <!--<td>{{item.contacts}}</td>-->
                    <!--<td>{{item.mobile}}</td>-->
                    <td>{{item.tel}}</td>
                    <td>{{item.address}}</td>
                    <!--<td>-->
                    <!--<span v-if="item.groupstatus == 1">启用</span>-->
                    <!--<span v-if="item.groupstatus == 0">禁用</span>-->
                    <!--</td>-->
                    <td>
                        <button type="button" @click="edit(item.gid)" class="btn btn-primary">编辑</button>
                        <button type="button" @click="del(item.gid)" class="btn btn-danger">删除</button>
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="add" style="display: none;">
        <div class="padding-10">
            <form action="" id="myForm" method="post">
                <div class="padding-10">
                    <div style="display: inline-block;width: 14%;">
                        <label for="gname" >公司名称 :<font color="red">*</font>：</label>
                    </div>
                    <div style="display: inline-block;width: 80%;">
                        <input type="hidden" name="gid" v-model="gid">
                        <input type="text" id="gname" name="gname" v-model="gname1" class="form-control" placeholder="请输入公司名称" />
                    </div>
                </div>

                <div class="padding-10">
                    <div style="display: inline-block;width: 14%;">
                        <label for="gname" >公司简介 :<font color="red">*</font>：</label>
                    </div>
                    <div style="display: inline-block;width: 80%;">
                        <input type="text" id="gdesc" name="gdesc" v-model="gdesc" class="form-control"
                               placeholder="请输入公司简介" />
                    </div>
                </div>
                <!--<div class="padding-10">-->
                    <!--<div style="display: inline-block;width: 14%;">-->
                        <!--<label for="chager" >管理员账户:<font color="red">*</font>：</label>-->
                    <!--</div>-->
                    <!--<div style="display: inline-block;width: 80%;">-->
                        <!--<input type="text" id="chager" name="chager" v-model="chager" class="form-control" placeholder="请输入管理员账户" />-->
                    <!--</div>-->
                <!--</div>-->
                <!--<div class="padding-10">-->
                    <!--<div style="display: inline-block;width: 14%;">-->
                        <!--<label for="password" >密码:<font color="red">*</font>：</label>-->
                    <!--</div>-->
                    <!--<div style="display: inline-block;width: 80%;">-->
                        <!--<input type="password" id="password" name="password" v-model="password" class="form-control" placeholder="请输入密码" />-->
                    <!--</div>-->
                <!--</div>-->
                <!--<div class="padding-10">-->
                    <!--<div style="display: inline-block;width: 14%;">-->
                        <!--<label for="contacts" >联系人:<font color="red">*</font>：</label>-->
                    <!--</div>-->
                    <!--<div style="display: inline-block;width: 80%;">-->
                        <!--<input type="text" id="contacts" name="contacts" v-model="contacts" class="form-control" placeholder="请输入联系人" />-->
                    <!--</div>-->
                <!--</div>-->
                <!--<div class="padding-10">-->
                    <!--<div style="display: inline-block;width: 14%;">-->
                        <!--<label for="mobile" >手机:<font color="red">*</font>：</label>-->
                    <!--</div>-->
                    <!--<div style="display: inline-block;width: 80%;">-->
                        <!--<input type="text" id="mobile" name="mobile" v-model="mobile" class="form-control" placeholder="请输入手机" />-->
                    <!--</div>-->
                <!--</div>-->
                <div class="padding-10">
                    <div style="display: inline-block;width: 14%;">
                        <label for="tel" >电话：<font color="red">*</font></label>
                    </div>
                    <div style="display: inline-block;width: 80%;">
                        <input type="text" id="tel" name="tel" class="form-control" v-model="tel" placeholder="请输入电话" />
                    </div>
                </div>
                <div class="padding-10">
                    <div style="display: inline-block;width: 14%;">
                        <label for="address" >地址：<font color="red">*</font>：</label>
                    </div>
                    <div style="display: inline-block;width: 80%;">
                        <input type="text" id="address" name="address" class="form-control" v-model="address" placeholder="请输入地址" />
                    </div>
                </div>
                <div class="padding-10">
                    <div style="display: inline-block;width: 10%;margin-left: 110px;">
                        <button class="btn btn-primary" type="button" @click="SubForm()">确定</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div id="appoint" class="padding-10" style="display: none;">
        <div class="padding-10">
            <div style="display: inline-block;width: 14%;">
                <label for="tel" >负责人姓名：<font color="red">*</font></label>
            </div>
            <div style="display: inline-block;width: 80%;">
                <input type="text" id="name" name="name" class="form-control" v-model="name" placeholder="请输入负责人姓名" />
            </div>
        </div>
        <div class="padding-10">
            <div style="display: inline-block;width: 14%;">
                <label for="tel" >负责人手机号：<font color="red">*</font></label>
            </div>
            <div style="display: inline-block;width: 80%;">
                <input type="text" id="fzmobile" name="fzmobile" class="form-control" v-model="fzmobile" placeholder="请输入负责人手机号" />
            </div>
        </div>

        <div class="padding-10">
            <div style="display: inline-block;width: 14%;">
                <label for="tel" >负责人工号：<font color="red">*</font></label>
            </div>
            <div style="display: inline-block;width: 80%;">
                <input type="text" id="job_num" name="job_num" class="form-control" v-model="job_num" placeholder="请输入负责人工号" />
            </div>
        </div>
    </div>
</div>
<script>
    var el = new Vue({
        el:"#con",
        data:{
            status:'',
            gname:'',
            gdesc:'',
            groupdata:[],
            groupstatus:1,
            gname1:'',
            // chager:'',
            // password:'',
            // contacts:'',
            // mobile:'',
            name:'',
            fzmobile:'',
            job_num:'',
            tel:'',
            address:'',
            gid:''
        },
        methods:{
            SubForm:function () {
                var form = $("#myForm").serializeArray();
                $.post('AddGroup',form,function (res) {
                    if(res.code == 1){
                        layer.msg(res.msg,{icon:1});
                        setTimeout(function () {
                            layer.closeAll();
                            location.reload();
                        },2000);
                    }else{
                        layer.msg(res.msg,{icon:2});
                    }
                })
            },
            appoint:function (id) {
                var _self = this;
                layer.open({
                    type:1,
                    title:'添加',
                    shadeClose:false,
                    area:['800px','350px'],
                    content:$("#appoint"),
                    btn:['提交','取消'],
                    yes:function () {
                        var data = {};
                        data.gid = id;
                        data.name = _self.name;
                        data.mobile = _self.fzmobile;
                        data.job_num = _self.job_num;
                        $.post('Appoint',data,function (res) {
                            if (res.code == 1){
                                layer.msg(res.msg,{icon:1});
                                setTimeout(function () {
                                    location.reload();
                                },2000)
                            }
                        })
                        return false;
                    }
                })
            },
            getData:function(){
                var _self = this,
                    data = {};
                if(_self.gname){
                    data.gname = _self.gname;
                }
                if(_self.status) {
                    data.status = _self.status;
                }
                $.post('getGroupList',data,function(res){
                    console.log(res);
                    _self.groupdata = res.data;
                })
            },
            add:function () {
                this.gname1 = '';
                this.gdesc = '';
                // this.chager = '';
                // this.password = '';
                // this.contacts = '';
                // this.mobile = '';
                this.address = '';
                this.tel = '';
                this.gid = '';
                // $("#chager").removeAttr('readonly');
                // $("#password").removeAttr('readonly');
                layer.open({
                    type:1,
                    title:'添加',
                    shadeClose:false,
                    area:['800px','350px'],
                    shadeClose:true,
                    content:$(".add")
                })
            },
            changeStatus:function (gid,status) {
                var data = {},
                $this = this;
                data.gid = gid;
                data.status = status;
                $.post('ChangeStatus',data,function (res) {

                })
            },
            edit:function(gid) {
                var data = {},
                    $this = this;
                data.gid = gid;
                $.post("getGroupInfo",data,function(res){
                    if(res.code == 1){
                        var rdata = res.data;
                        $this.gname1 = rdata.gname;
                        $this.gid = rdata.gid;
                        $this.gdesc = rdata.gdesc;
                        // $this.chager = rdata.user_name;
                        // $this.contacts = rdata.contacts;
                        $this.tel = rdata.tel;
                        // $this.mobile = rdata.mobile;
                        $this.address = rdata.address;
                        // $("#chager").attr('readonly',true);
                        // $("#password").attr('readonly',true);
                        layer.open({
                            type:1,
                            title:'添加',
                            shadeClose:false,
                            area:['800px','350px'],
                            shadeClose:true,
                            content:$(".add")
                        })
                    }
                })
            },
            del:function (gid) {
                var data = {};
                data.gid = gid;
                layer.confirm('确定要删除吗？',{
                    btn:['确定','取消']
                },function () {
                    $.post('DelGroup',data,function (res) {
                        layer.msg(res.msg);
                        setTimeout(function () {
                            location.reload();
                        },2000)
                    })
                })
            }
        }
    })
    el.getData();
</script>
</body>
</html>

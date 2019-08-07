<?php

// +----------------------------------------------------------------------

// | ThinkPHP [ WE CAN DO IT JUST THINK ]

// +----------------------------------------------------------------------

// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.

// +----------------------------------------------------------------------

// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )

// +----------------------------------------------------------------------

// | Author: liu21st <liu21st@gmail.com>

// +----------------------------------------------------------------------



return [

    // +----------------------------------------------------------------------

    // | 应用设置

    // +----------------------------------------------------------------------



    // 应用命名空间

    'app_namespace'          => 'app',

    // 应用调试模式

    'app_debug'              => true,

    // 应用Trace

    'app_trace'              => false,

    // 应用模式状态

    'app_status'             => '',

    // 是否支持多模块

    'app_multi_module'       => true,

    // 入口自动绑定模块

    'auto_bind_module'       => false,

    // 注册的根命名空间

    'root_namespace'         => [],

    // 扩展函数文件

    'extra_file_list'        => [THINK_PATH . 'helper' . EXT],

    // 默认输出类型

    'default_return_type'    => 'html',

    // 默认AJAX 数据返回格式,可选json xml ...

    'default_ajax_return'    => 'json',

    // 默认JSONP格式返回的处理方法

    'default_jsonp_handler'  => 'jsonpReturn',

    // 默认JSONP处理方法

    'var_jsonp_handler'      => 'callback',

    // 默认时区

    'default_timezone'       => 'PRC',

    // 是否开启多语言

    'lang_switch_on'         => false,

    // 默认全局过滤方法 用逗号分隔多个

    'default_filter'         => '',

    // 默认语言

    'default_lang'           => 'zh-cn',

    // 应用类库后缀

    'class_suffix'           => false,

    // 控制器类后缀

    'controller_suffix'      => false,



    // +----------------------------------------------------------------------

    // | 模块设置

    // +----------------------------------------------------------------------



    // 默认模块名

    'default_module'         => 'admin',

    // 禁止访问模块

    'deny_module_list'       => ['common'],

    // 默认控制器名

    'default_controller'     => 'Admin',

    // 默认操作名

    'default_action'         => 'index',

    // 默认验证器

    'default_validate'       => '',

    // 默认的空控制器名

    'empty_controller'       => 'Error',

    // 操作方法后缀

    'action_suffix'          => '',

    // 自动搜索控制器

    'controller_auto_search' => false,



    // +----------------------------------------------------------------------

    // | URL设置

    // +----------------------------------------------------------------------



    // PATHINFO变量名 用于兼容模式

    'var_pathinfo'           => 's',

    // 兼容PATH_INFO获取

    'pathinfo_fetch'         => ['ORIG_PATH_INFO', 'REDIRECT_PATH_INFO', 'REDIRECT_URL'],

    // pathinfo分隔符

    'pathinfo_depr'          => '/',

    // URL伪静态后缀

    'url_html_suffix'        => 'html',

    // URL普通方式参数 用于自动生成

    'url_common_param'       => true,

    // URL参数方式 0 按名称成对解析 1 按顺序解析

    'url_param_type'         => 0,

    // 是否开启路由

    'url_route_on'           => true,

    // 路由使用完整匹配

    'route_complete_match'   => false,

    // 路由配置文件（支持配置多个）

    'route_config_file'      => ['route'],

    // 是否强制使用路由

    'url_route_must'         => false,

    // 域名部署

    'url_domain_deploy'      => false,

    // 域名根，如thinkphp.cn

    'url_domain_root'        => '',

    // 是否自动转换URL中的控制器和操作名

    'url_convert'            => true,

    // 默认的访问控制器层

    'url_controller_layer'   => 'controller',

    // 表单请求类型伪装变量

    'var_method'             => '_method',

    // 表单ajax伪装变量

    'var_ajax'               => '_ajax',

    // 表单pjax伪装变量

    'var_pjax'               => '_pjax',

    // 是否开启请求缓存 true自动缓存 支持设置请求缓存规则

    'request_cache'          => false,

    // 请求缓存有效期

    'request_cache_expire'   => null,

    // 全局请求缓存排除规则

    'request_cache_except'   => [],



    // +----------------------------------------------------------------------

    // | 模板设置

    // +----------------------------------------------------------------------



    'template'               => [

        // 模板引擎类型 支持 php think 支持扩展

        'type'         => 'Think',

        // 模板路径

        'view_path'    => '',

        // 模板后缀

        'view_suffix'  => 'html',

        // 模板文件名分隔符

        'view_depr'    => DS,

        // 模板引擎普通标签开始标记

        'tpl_begin'    => '{',

        // 模板引擎普通标签结束标记

        'tpl_end'      => '}',

        // 标签库标签开始标记

        'taglib_begin' => '{',

        // 标签库标签结束标记

        'taglib_end'   => '}',

    ],



    // 视图输出字符串内容替换

    'view_replace_str'       => [
        "__CSS__" => '/static/css',
        "__JS__"  => '/static/js',
        "__IMG__" => '/static/images',
        "__ADMIN__" => '/admin/',
        "__PUBLIC__" => '/static',
        "__JQ__" => '/static/jquery',
        "__IMGE__" => '/static/img',
    ],

    // 默认跳转页面对应的模板文件

    'dispatch_success_tmpl'  => APP_PATH . 'admin' . DS . 'view/tips.html',

    'dispatch_error_tmpl'    => APP_PATH . 'admin' . DS . 'view/tips.html',



    // +----------------------------------------------------------------------

    // | 异常及错误设置

    // +----------------------------------------------------------------------



    // 异常页面的模板文件

    'exception_tmpl'         => THINK_PATH . 'tpl' . DS . 'think_exception.tpl',



    // 错误显示信息,非调试模式有效

    'error_message'          => '页面错误！请稍后再试～',

    // 显示错误信息

    'show_error_msg'         => false,

    // 异常处理handle类 留空使用 \think\exception\Handle

    'exception_handle'       => '',



    // +----------------------------------------------------------------------

    // | 日志设置

    // +----------------------------------------------------------------------



    'log'                    => [

        // 日志记录方式，内置 file socket 支持扩展

        'type'  => 'File',

        // 日志保存目录

        'path'  => LOG_PATH,

        // 日志记录级别

        'level' => [],

    ],



    // +----------------------------------------------------------------------

    // | Trace设置 开启 app_trace 后 有效

    // +----------------------------------------------------------------------

    'trace'                  => [

        // 内置Html Console 支持扩展

        'type' => 'Html',

    ],



    // +----------------------------------------------------------------------

    // | 缓存设置

    // +----------------------------------------------------------------------



    'cache'                  => [

        // 驱动方式

        'type'   => 'File',

        // 缓存保存目录

        'path'   => CACHE_PATH,

        // 缓存前缀

        'prefix' => '',

        // 缓存有效期 0表示永久缓存

        'expire' => 0,

    ],



    // +----------------------------------------------------------------------

    // | 会话设置

    // +----------------------------------------------------------------------



    'session'                => [

        'id'             => '',

        // SESSION_ID的提交变量,解决flash上传跨域

        'var_session_id' => '',

        // SESSION 前缀

        'prefix'         => 'think',

        // 驱动方式 支持redis memcache memcached

        'type'           => '',

        // 是否自动开启 SESSION

        'auto_start'     => true,

    ],



    // +----------------------------------------------------------------------

    // | Cookie设置

    // +----------------------------------------------------------------------

    'cookie'                 => [

        // cookie 名称前缀

        'prefix'    => '',

        // cookie 保存时间

        'expire'    => 0,

        // cookie 保存路径

        'path'      => '/',

        // cookie 有效域名

        'domain'    => '',

        //  cookie 启用安全传输

        'secure'    => false,

        // httponly设置

        'httponly'  => '',

        // 是否使用 setcookie

        'setcookie' => true,

    ],



    //分页配置

    'paginate'      => [

        'type'      => 'bootstrap5',

        'var_page'  => 'page',

        'list_rows' => 15,

    ],


    // +----------------------------------------------------------------------

    // | 短信验证码设置

    // +----------------------------------------------------------------------

    'sms' => [
        'akid'     => 'LTAITprNFnX4ieDk'   ,               //Access Key ID
        'aks'      => 'cAoFKpXIuyU4jYVpNuQwTx1EU0epmg',
        'qm'       => '虎不虎',
        'template' => 'SMS_107105138'
    ],
    // +----------------------------------------------------------------------

    // | 支付宝设置

    // +----------------------------------------------------------------------

    'alipay_config'   => [
        'appid' =>'2017010604888586',                   //商户密钥

        'rsaPrivateKey' =>'MIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQD3b+oFjYv9Uj1WWT40fP1nvDVSols85bkDmZ+eWzy56pfeE2KDG6akCqikTR/Xz50p15tfogdniS8KZhuUE0FRyPr6YLeCrHXSFzArI52VFdFsqZUz8o2MEXEMzWXSq0pSKLgeCVInEiPHrCUKvHsVxGKYZATvXuFbiMDZtYujhNJzwE63rWqkI2OCDbS50SC0/R12eB6K5S9zK8cuiW2g8x0MnKwCwjO9xlpT4ZR/X/6JyqNZx5FZy2xIOWRuXxSlHINh60Dr7cZJ5OtuM+MMMJJ+YUY2bMzye5VjEmpq7SNFLIGq7qD8oP6taTxRABWCmfStCjeCsWd78EQnaNgJAgMBAAECggEBAOvxxskGwW+MpTqanMt2SDlL6djjQnceYz8AlYluXMi335r/BxgYHN4d39PUS0ICEk6c7ubRXZgn4zhaR3/6oHW5XUG1SigMBcmRHPh13MUV6f5g8wp3BuyCkTdxAOBTP+p6M59IqhLhpEa5axUCx6fo/U9tSJts8R3UmHjBOedwVyktpJL+mx5tIvGQHIu7LB7U6f6wqimGQPIxzj/Y2WWoYogzeNNJyT7cjHhhnMernvLIxKiv1zcSH8EbuCr2J72dmPUSvMuo+aL/Pj1zhLEEkWMvD4xxrf4gwBY54tjOm8hbKLeygxrzGDk8qyOyNI9b/SYHgJUQzx9YQKwHBrUCgYEA/weere4HD9TAAU9a+fL0Q5gtwgRzL4lMtLX4+wU5yxVQXlVOdJ+7wGVeNERoN4rbH2BUx1vSf4oev5j1EHlXwN7biJbZtFEqoLTj2nRah1Cx0+aS6cuH+dzltJZJTk8Au6eJ+WrNu088pflNR3pUfbvGLypAJssQYuqD+3MFJHsCgYEA+GDmUQPGE8X2EnlXY/HfZE/iblgOq+fMa627MP43RsIUHA9EzoKgerVHSzDnqeft0P2a2C4x9bGJFMVGdglxrTeqwIGOBD58hL87H9wSqLTudy89/ZhB0QQycaN296GhSA6Jojbl8y9/sIz+GIRoawhnury03AniXznlgZ+w+EsCgYEA73XYKLg3KUY6gwBgDBF0CYP6cxJ6lUf2Hjg/cHOXsHhy3iB7akYRpLWJnsockQpwdSWedRJitB6cgIq+kJlfLFoVCEucXxNXU06GI7jcx/GdB7qYd64EHziq9sWmT0EfDxRhGTCPvDDKYY2UYmkarHSDwgWJ9uL0n+xTwOZfDcECgYBgd9I8eQi/uU1/k11b1h97qIM7dDwOjHMbB1kDCFmTw+FnnI6O3rFRt4K/M3lmxkvZtgYkHJ0O3ittw8lAIx7hthM9vZPZFiPqsxNVpnYgzFUqOVEMY8x8T/L/rAuS1lX71JmkRUo+j546hihSgWrE13jiUFS2eahQb/4xwEJNzQKBgGSP2qI42+cEe75wlAUms3+lemsps3FFSa0C/nDqWMpBzBIKkQAoI1HE2nm9qsCe2j3L5ioK450x3bg96DFGwwGbvXBGENJ8PUEI/taYnFcww5LQ+geV04o+HVXocLQBOsUp7FCNkrkGhjHhhOSNn8ShsTeqYtk7qJeNsU/s35vX',                           //私钥

        'alipayrsaPublicKey'=>'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA92/qBY2L/VI9Vlk+NHz9Z7w1UqJbPOW5A5mfnls8ueqX3hNigxumpAqopE0f18+dKdebX6IHZ4kvCmYblBNBUcj6+mC3gqx10hcwKyOdlRXRbKmVM/KNjBFxDM1l0qtKUii4HglSJxIjx6wlCrx7FcRimGQE717hW4jA2bWLo4TSc8BOt61qpCNjgg20udEgtP0ddngeiuUvcyvHLoltoPMdDJysAsIzvcZaU+GUf1/+icqjWceRWctsSDlkbl8UpRyDYetA6+3GSeTrbjPjDDCSfmFGNmzM8nuVYxJqau0jRSyBqu6g/KD+rWk8UQAVgpn0rQo3grFne/BEJ2jYCQIDAQAB',                       //公钥(自己的程序里面用不到)

        // 'partner'=>'2088421540577515',                  //(商家的参数,新版本的好像用不到)

        'input_charset'=>strtolower('utf-8'),           //编码

        'notify_url' =>'http://shengxian.181.021mc.net/index/pay/alipay_res',   //回调地址(支付宝支付成功后回调修改订单状态的地址)

        'payment_type' =>1,                             //(固定值)

        'seller_id' =>'',                               //收款商家账号

        'charset'    => 'utf-8',                        //编码

        'sign_type' => 'RSA2',                          //签名方式

        'version'   =>"1.0",                            //固定值

        'url'       => 'https://openapi.alipay.com/gateway.do',//固定值

        'method'    => 'alipay.trade.app.pay',          //固定值

    ],

];

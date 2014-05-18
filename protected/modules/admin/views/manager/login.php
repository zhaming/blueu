<!DOCTYPE html>
<html lang="zh-cn">
    <head>
        <meta charset="utf-8" />
        <title>管理后台</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="/statics/favicon.ico">
        <!--
        <link rel="apple-touch-icon" href="img/apple-touch-icon.png">
        <link rel="apple-touch-icon" sizes="72x72" href="img/apple-touch-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="114x114" href="img/apple-touch-icon-114x114.png">
        -->
        
        <!-- basic styles -->
        <link href="/statics/css/bootstrap.min.css" rel="stylesheet" />
        <link href="/statics/css/font-awesome.min.css" rel="stylesheet" />

        <!--[if IE 7]>
        <link href="/statics/css/font-awesome-ie7.min.css" rel="stylesheet" />
        <![endif]-->

        <!-- page specific plugin styles -->
        <!-- fonts -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" rel="stylesheet" />

        <!-- ace styles -->
        <link href="/statics/css/ace.min.css" rel="stylesheet" />
        <link href="/statics/css/ace-rtl.min.css" rel="stylesheet" />

        <!--[if lte IE 8]>
        <link href="/statics/css/ace-ie.min.css" rel="stylesheet" />
        <![endif]-->

        <!-- inline styles related to this page -->

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

        <!--[if lt IE 9]>
        <script src="/statics/js/html5shiv.js"></script>
        <script src="/statics/js/respond.min.js"></script>
        <![endif]-->
    </head>

    <body class="login-layout">
        <div class="main-container">
            <div class="main-content">
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                        <div class="login-container">
                            <div class="center">
                                <h1>
                                    <span class="red">Blueu</span>
                                    <span class="white">后台管理</span>
                                </h1>
                                <h4 class="blue">&copy; xxx公司</h4>
                            </div>

                            <div class="space-6"></div>

                            <div class="position-relative">
                                <div id="login-box" class="login-box visible widget-box no-border">
                                    <div class="widget-body">
                                        <div class="widget-main">
                                            <h4 class="header blue lighter bigger"><i class="icon-coffee green"></i>请输入您的账户信息</h4>

                                            <div class="space-6"></div>

                                            <form action="/admin/manager/login" method="post">
                                                <fieldset>
                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <input type="text" name="username" class="form-control" placeholder="用户名" />
                                                            <i class="icon-user"></i>
                                                        </span>
                                                    </label>

                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <input type="password" name="password" class="form-control" placeholder="密码" />
                                                            <i class="icon-lock"></i>
                                                        </span>
                                                    </label>

                                                    <div class="space"></div>

                                                    <div class="clearfix">
                                                        <label class="inline">
                                                            <input type="checkbox" class="ace" />
                                                            <span class="lbl">记住密码</span>
                                                        </label>
                                                        <button type="submit" class="width-35 pull-right btn btn-sm btn-primary"><i class="icon-key"></i>登录</button>
                                                    </div>

                                                    <div class="space-4"></div>
                                                </fieldset>
                                            </form>
                                        </div>

                                        <div class="toolbar clearfix">
                                            <div>
                                                <a onclick="show_box('forgot-box'); return false;" class="link forgot-password-link"><i class="icon-arrow-left"></i>忘记密码</a>
                                            </div>

                                            <div>
                                                <a onclick="show_box('signup-box'); return false;" class="link user-signup-link">注册<i class="icon-arrow-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="forgot-box" class="forgot-box widget-box no-border">
                                    <div class="widget-body">
                                        <div class="widget-main">
                                            <h4 class="header red lighter bigger"><i class="icon-key"></i>找回密码</h4>
                                            <div class="space-6"></div>
                                            <p>输入您的邮箱地址以接收密码重置邮件</p>
                                            <form>
                                                <fieldset>
                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <input type="email" name="email" class="form-control" placeholder="邮箱" />
                                                            <i class="icon-envelope"></i>
                                                        </span>
                                                    </label>

                                                    <div class="clearfix">
                                                        <button type="button" class="width-35 pull-right btn btn-sm btn-danger"><i class="icon-lightbulb"></i>发送</button>
                                                    </div>
                                                </fieldset>
                                            </form>
                                        </div>
                                        <div class="toolbar center">
                                            <a onclick="show_box('login-box'); return false;" class="link back-to-login-link">返回登录<i class="icon-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>

                                <div id="signup-box" class="signup-box widget-box no-border">
                                    <div class="widget-body">
                                        <div class="widget-main">
                                            <h4 class="header green lighter bigger">
                                                <i class="icon-group blue"></i>
                                                New User Registration
                                            </h4>

                                            <div class="space-6"></div>
                                            <p> Enter your details to begin: </p>
                                            <form>
                                                <fieldset>
                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <input type="email" class="form-control" placeholder="Email" />
                                                            <i class="icon-envelope"></i>
                                                        </span>
                                                    </label>

                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <input type="text" class="form-control" placeholder="Username" />
                                                            <i class="icon-user"></i>
                                                        </span>
                                                    </label>

                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <input type="password" class="form-control" placeholder="Password" />
                                                            <i class="icon-lock"></i>
                                                        </span>
                                                    </label>
                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <input type="password" class="form-control" placeholder="Repeat password" />
                                                            <i class="icon-retweet"></i>
                                                        </span>
                                                    </label>
                                                    <label class="block">
                                                        <input type="checkbox" class="ace" />
                                                        <span class="lbl">接受<a href="#">用户协议</a></span>
                                                    </label>
                                                    <div class="space-24"></div>
                                                    <div class="clearfix">
                                                        <button type="reset" class="width-30 pull-left btn btn-sm"><i class="icon-refresh"></i>重置</button>
                                                        <button type="button" class="width-65 pull-right btn btn-sm btn-success">注册<i class="icon-arrow-right icon-on-right"></i></button>
                                                    </div>
                                                </fieldset>
                                            </form>
                                        </div>
                                        <div class="toolbar center">
                                            <a onclick="show_box('login-box'); return false;" class="link back-to-login-link"><i class="icon-arrow-left"></i>返回登陆</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- basic scripts -->

        <!--[if !IE]> -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
        <!-- <![endif]-->

        <!--[if IE]>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <![endif]-->

        <!--[if !IE]> -->
        <script type="text/javascript">
            window.jQuery || document.write("<script src='/statics/js/jquery-2.0.3.min.js'>" + "<" + "/script>");
        </script>
        <!-- <![endif]-->

        <!--[if IE]>
        <script type="text/javascript">
            window.jQuery || document.write("<script src='/statics/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
        </script>
        <![endif]-->

        <script type="text/javascript">
            if ("ontouchend" in document)
                document.write("<script src='/statics/js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
        </script>

        <!-- inline scripts related to this page -->
        <script type="text/javascript">
            function show_box(id) {
                jQuery('.widget-box.visible').removeClass('visible');
                jQuery('#' + id).addClass('visible');
            }
        </script>
    </body>
</html>
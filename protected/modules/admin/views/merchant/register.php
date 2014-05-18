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
                                <div id="signup-box" class="signup-box widget-box no-border visible">
                                    <div class="widget-body">
                                        <div class="widget-main">
                                            <h4 class="header green lighter bigger"><i class="icon-group blue"></i>&nbsp;&nbsp;<?php echo Yii::t('admin','Merchant register'); ?></h4>
                                            <?php if (!empty($message)) { ?>
                                            <div class="alert alert-block alert-danger">
                                                <p>
                                                    <strong>
                                                        <?php echo $message; ?>
                                                    </strong>
                                                </p>
                                            </div>
                                            <?php } ?>
                                            <form action="/admin/merchant/register" method="post">
                                                <fieldset>
                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <input type="text" name="merchant[username]" value="<?php echo $merchant['username'] ?>" class="form-control" placeholder="<?php echo Yii::t('admin','Username'); ?>" />
                                                            <i class="icon-user"></i>
                                                        </span>
                                                    </label>
                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <input type="password" name="merchant[password]" value="<?php echo $merchant['password'] ?>" class="form-control" placeholder="<?php echo Yii::t('admin','Password'); ?>" />
                                                            <i class="icon-lock"></i>
                                                        </span>
                                                    </label>
                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <input type="password" name="merchant[repassword]" value="<?php echo $merchant['repassword'] ?>" class="form-control" placeholder="<?php echo Yii::t('admin','Repeat password'); ?>" />
                                                            <i class="icon-retweet"></i>
                                                        </span>
                                                    </label>
                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <input type="text" name="merchant[name]" value="<?php echo $merchant['name'] ?>" class="form-control" placeholder="<?php echo Yii::t('admin','Name'); ?>" />
                                                            <i class="icon-user-md"></i>
                                                        </span>
                                                    </label>
                                                    <label class="block">
                                                        <input type="checkbox" class="ace" />
                                                        <span class="lbl">&nbsp;&nbsp;<?php echo Yii::t('admin','Accept'); ?><a target="_blank" href="/agreement/merchant"><?php echo Yii::t('admin','Agreement'); ?></a></span>
                                                    </label>
                                                    <div class="clearfix">
                                                        <button type="reset" class="width-30 pull-left btn btn-sm"><i class="icon-refresh"></i><?php echo Yii::t('admin','Reset'); ?></button>
                                                        <button type="submit" class="width-65 pull-right btn btn-sm btn-success"><?php echo Yii::t('admin','Register'); ?>&nbsp;&nbsp;<i class="icon-arrow-right icon-on-right"></i></button>
                                                    </div>
                                                </fieldset>
                                            </form>
                                        </div>
                                        <div class="toolbar center">
                                            <a href="/admin/manager/login" class="link back-to-login-link"><i class="icon-arrow-left"></i>&nbsp;&nbsp;<?php echo Yii::t('admin','Return login'); ?></a>
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
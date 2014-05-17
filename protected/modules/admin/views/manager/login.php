
<!doctype html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <title>管理后台</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="img/favicon.ico">
    <link rel="apple-touch-icon" href="img/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="img/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="img/apple-touch-icon-114x114.png">
    <style type="text/css">
    body {
        padding-top: 180px;
        padding-bottom: 40px;
    }
    .sidebar-nav {
        padding: 9px 0;
    }
    #form-login {
        width: 500px;
        margin: 20px 0 120px;
    }
	.fixed_ie{
	/*坑爹的出现样式名中出现span就有问题*/
		width:200px;
	}
.login_div{
	width:600px;
	margin:0px auto;
}
<!--[if IE]><![endif]-->


    </style>
</head>
<body data-spy="scroll" data-target=".subnav" data-offset="50">
<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
      <div class="container-fluid">
        <a class="brand" href="#">网站管理后台</a>
      </div>
    </div>
</div>
<div class="login_div">
        <?php $this->widget('application.modules.admin.widgets.AlterMsgWidget'); ?>
        <form action="" method="post" class="form-horizontal well">
            <fieldset>
                <legend>管理员登录</legend>
                <div class="control-group">
                    <label class="control-label" for="username">用户名</label>
                    <div class="controls">
                        <div class="input-prepend">
                            <span class="add-on"><i class="icon-user"></i></span>
                            <input name="LoginForm[name]" type="text" class="fixed_ie"  autofocus>
                        </div>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="password">密码</label>
                    <div class="controls">
                        <div class="input-prepend">
                            <span class="add-on"><i class="icon-lock"></i></span>
                            <input name="LoginForm[pass]" type="password" class="fixed_ie">
                        </div>
                    </div>
                </div>
<!--                 <div class="control-group">
                    <div class="controls">
                      <label class="checkbox">
                        <input name="LoginForm[rememberme]" type="checkbox" checked="checked" >记住密码
                      </label>
                    </div>
                </div> -->
                <div class="form-actions">
                    <input type="submit" name="Submit" value="登录" class="btn btn-primary">
                    <div align="right"><a href="/user/resetpassword">找回密码</a></div>
                    <div class="clear"></div>
                </div>
            </fieldset>
        </form>
</div>
</body>
</html>

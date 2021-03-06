<div class="login-box widget-box no-border visible">
    <div class="widget-body">
        <div class="widget-main">
            <h4 class="header blue lighter bigger">
                <i class="icon-coffee green"></i>&nbsp;&nbsp;<?php echo Yii::t('admin', 'Login'); ?>
            </h4>
            <?php if (!empty($message)) { ?>
                <div class="alert alert-block alert-danger">
                    <p>
                        <strong>
                            <?php echo $message; ?>
                        </strong>
                    </p>
                </div>
            <?php } ?>
            <form action="/admin/manager/login" method="post">
                <fieldset>
                    <label class="block clearfix">
                        <span class="block input-icon input-icon-right">
                            <input type="text" name="user[username]" value="<?php echo $user['username'] ?>" class="form-control" placeholder="<?php echo Yii::t('admin', 'Email'); ?>" />
                            <i class="ace-icon fa fa-envelope"></i>
                        </span>
                    </label>
                    <label class="block clearfix">
                        <span class="block input-icon input-icon-right">
                            <input type="password" name="user[password]" value="<?php echo $user['password'] ?>" class="form-control" placeholder="<?php echo Yii::t('admin', 'Password'); ?>" />
                            <i class="ace-icon glyphicon glyphicon-lock"></i>
                        </span>
                    </label>
                    <div class="space"></div>
                    <div class="clearfix">
                        <label class="inline">
                            <input type="checkbox" name="user[rememberme]" value="1" <?php if ($user['rememberme'] == 'on') { ?> checked<?php } ?> class="ace" />
                            <span class="lbl">&nbsp;&nbsp;<?php echo Yii::t('admin', 'Remember me'); ?></span>
                        </label>
                        <button type="submit" class="width-35 pull-right btn btn-sm btn-primary"><i class="ace-icon fa fa-key"></i><?php echo Yii::t('admin', 'Login'); ?></button>
                    </div>
                </fieldset>
            </form>
        </div>
        <div class="toolbar clearfix">
            <div>
                <a href="/admin/manager/findpwd" class="link forgot-password-link"><i class="ace-icon fa fa-arrow-left"></i>&nbsp;<?php echo Yii::t('admin', 'Forgot password'); ?></a>
            </div>

            <div>
                <a href="/admin/merchant/register" class="link user-signup-link"><?php echo Yii::t('admin', 'Merchant register'); ?>&nbsp;<i class="ace-icon fa fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
</div>
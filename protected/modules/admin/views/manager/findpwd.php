<div class="forgot-box widget-box no-border visible">
    <div class="widget-body">
        <div class="widget-main">
            <h4 class="header red lighter bigger">
                <i class="icon-key"></i><?php echo Yii::t('admin', 'Forgot password'); ?>
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
            <form action="/admin/manager/findpwd" method="post">
                <fieldset>
                    <label class="block clearfix">
                        <span class="block input-icon input-icon-right">
                            <input type="text" name="username" class="form-control" placeholder="<?php echo Yii::t('admin', 'Email'); ?>" />
                            <i class="icon-envelope"></i>
                        </span>
                    </label>
                    <div class="clearfix">
                        <button type="submit" class="width-35 pull-right btn btn-sm btn-danger"><i class="icon-lightbulb"></i>发送</button>
                    </div>
                </fieldset>
            </form>
        </div>
        <div class="toolbar center">
            <a href="/admin/manager/login" class="link back-to-login-link"><?php echo Yii::t('admin', 'Return login'); ?>&nbsp;&nbsp;<i class="icon-arrow-right"></i></a>
        </div>
    </div>
</div>
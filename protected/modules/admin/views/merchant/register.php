<div id="signup-box" class="signup-box widget-box no-border visible">
    <div class="widget-body">
        <div class="widget-main">
            <h4 class="header green lighter bigger"><i class="ace-icon fa fa-group blue"></i>&nbsp;&nbsp;<?php echo Yii::t('admin', 'Merchant register'); ?></h4>
            <?php if (!empty($message)) { ?>
                <div class="alert alert-block alert-danger">
                    <p>
                        <strong>
                            <?php echo $message; ?>
                        </strong>
                    </p>
                </div>
            <?php } ?>
            <div class="space-6"></div>
            <p><?php echo Yii::t('admin', 'Enter your details to begin:'); ?>
            <form action="/admin/merchant/register" method="post">
                <fieldset>
                    <label class="block clearfix">
                        <span class="block input-icon input-icon-right">
                            <input type="text" name="merchant[username]" value="<?php echo $merchant['username'] ?>" class="form-control" placeholder="<?php echo Yii::t('admin', 'Email'); ?>" />
                            <i class="ace-icon fa fa-envelope-o"></i>
                        </span>
                    </label>
                    <label class="block clearfix">
                        <span class="block input-icon input-icon-right">
                            <input type="password" name="merchant[password]" value="<?php echo $merchant['password'] ?>" class="form-control" placeholder="<?php echo Yii::t('admin', 'Password'); ?>" />
                            <i class="ace-icon fa fa-key"></i>
                        </span>
                    </label>
                    <label class="block clearfix">
                        <span class="block input-icon input-icon-right">
                            <input type="password" name="merchant[repassword]" value="<?php echo $merchant['repassword'] ?>" class="form-control" placeholder="<?php echo Yii::t('admin', 'Repeat password'); ?>" />
                            <i class="ace-icon fa fa-retweet"></i>
                        </span>
                    </label>
                    <label class="block clearfix">
                        <span class="block input-icon input-icon-right">
                            <input type="text" name="merchant[name]" value="<?php echo $merchant['name'] ?>" class="form-control" placeholder="<?php echo Yii::t('admin', 'Name'); ?>" />
                            <i class="ace-icon fa fa-user"></i>
                        </span>
                    </label>
                    <label class="block">
                        <input type="checkbox" class="ace" />
                        <span class="lbl">&nbsp;&nbsp;<?php echo Yii::t('admin', 'Accept'); ?><a target="_blank" href="/agreement/merchant"><?php echo Yii::t('admin', 'Agreement'); ?></a></span>
                    </label>
                    <div class="clearfix">
                        <button type="reset" class="width-30 pull-left btn btn-sm"><i class="ace-icon fa fa-refresh"></i><?php echo Yii::t('admin', 'Reset'); ?></button>
                        <button type="submit" class="width-65 pull-right btn btn-sm btn-success"><?php echo Yii::t('admin', 'Register'); ?>&nbsp;&nbsp;<i class="ace-icon fa fa-arrow-right"></i></button>
                    </div>
                </fieldset>
            </form>
        </div>
        <div class="toolbar center">
            <a href="/admin/manager/login" class="link back-to-login-link"><i class="ace-icon fa fa-arrow-left"></i>&nbsp;&nbsp;<?php echo Yii::t('admin', 'Return login'); ?></a>
        </div>
    </div>
</div>
<?php if (!empty($message)) { ?>
<div class="alert alert-block alert-danger">
    <button type="button" class="close" data-dismiss="alert">
        <i class="icon-remove"></i>
    </button>
    <i class="icon-warning-sign"></i>&nbsp;&nbsp;
    <?php echo $message; ?>	
</div>
<?php } ?>
<div class="row">
    <div class="col-xs-12">
        <div class="space-8"></div>
        <form action="/admin/manager/create" method="POST" class="form-horizontal">
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="user[username]"><?php echo Yii::t('admin', 'Username'); ?></label>
                <div class="col-sm-9">
                    <input type="text" name="user[username]" value="<?php echo $user['username'] ?>" placeholder="<?php echo Yii::t('admin', 'Pelase input email'); ?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>
            <div class="space-4"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="user[password]"><?php echo Yii::t('admin', 'Password'); ?></label>
                <div class="col-sm-9">
                    <input type="password" name="user[password]" value="<?php echo $user['password'] ?>" placeholder="<?php echo Yii::t('admin', 'Please input password'); ?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>
            <div class="space-4"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="user[repassword]"><?php echo Yii::t('admin', 'Repeat password'); ?></label>
                <div class="col-sm-9">
                    <input type="password" name="user[repassword]" value="<?php echo $user['repassword'] ?>" placeholder="<?php echo Yii::t('admin', 'Please input password again'); ?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>
            <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">
                    <button class="btn btn-info" type="submit"><i class="ace-icon glyphicon glyphicon-ok bigger-110"></i><?php echo Yii::t('admin', 'Create'); ?></button>
                    &nbsp; &nbsp; &nbsp;
                    <button class="btn" type="reset"><i class="ace-icon fa fa-undo bigger-110"></i><?php echo Yii::t('admin', 'Reset'); ?></button>
                </div>
            </div>
        </div>
    </div>
</div>
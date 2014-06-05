<?php if (!empty($message)) { ?>
<div class="alert alert-block alert-danger">
    <i class="icon-warning-sign"></i>&nbsp;&nbsp;
    <?php echo $message; ?>	
</div>
<?php } ?>
<div class="row">
    <div class="col-xs-12">
        <div class="space-8"></div>
        <form action="/admin/manager/resetpwd" method="POST" class="form-horizontal">
            <input type="hidden" name="id" value="<?php echo $userid; ?>" />
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-newpassword"><?php echo Yii::t('admin', 'Password'); ?></label>
                <div class="col-sm-9">
                    <input id="form-field-newpassword" type="password" name="newpassword" value="" placeholder="<?php echo Yii::t('admin', 'Please input password'); ?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>
            <div class="space-4"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-repassword"><?php echo Yii::t('admin', 'Repeat password'); ?></label>
                <div class="col-sm-9">
                    <input id="form-field-repassword" type="password" name="repassword" value="" placeholder="<?php echo Yii::t('admin', 'Please input password again'); ?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>
            <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">
                    <button class="btn btn-info" type="submit"><i class="icon-ok bigger-110"></i><?php echo Yii::t('admin', 'Save'); ?></button>
                    &nbsp; &nbsp; &nbsp;
                    <button class="btn" type="reset"><i class="icon-undo bigger-110"></i><?php echo Yii::t('admin', 'Reset'); ?></button>
                </div>
            </div>
        </div>
    </div>
</div>
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
        <form action="/admin/merchant/create" method="POST" enctype="multipart/form-data" class="form-horizontal">
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="merchant[username]"><?php echo Yii::t('admin', 'Username'); ?></label>
                <div class="col-sm-9">
                    <input type="text" name="merchant[username]" value="<?php echo $merchant['username'] ?>" placeholder="<?php echo Yii::t('admin', 'Please input email'); ?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>
            <div class="space-4"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="merchant[password]"><?php echo Yii::t('admin', 'Password'); ?></label>
                <div class="col-sm-9">
                    <input type="password" name="merchant[password]" value="<?php echo $merchant['password'] ?>" placeholder="<?php echo Yii::t('admin', 'Please input password'); ?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>
            <div class="space-4"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="merchant[repassword]"><?php echo Yii::t('admin', 'Repeat password'); ?></label>
                <div class="col-sm-9">
                    <input type="password" name="merchant[repassword]" value="<?php echo $merchant['repassword'] ?>" placeholder="<?php echo Yii::t('admin', 'Please input password again'); ?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>
            <div class="space-4"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="merchant[name]"><?php echo Yii::t('admin', 'Name'); ?></label>
                <div class="col-sm-9">
                    <input type="text" name="merchant[name]" value="<?php echo $merchant['name'] ?>" placeholder="<?php echo Yii::t('admin', 'Name'); ?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>
            <div class="space-4"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-legal"><?php echo Yii::t('admin', 'Legal'); ?></label>
                <div class="col-sm-9">
                    <input id="form-field-legal" type="text" name="merchant[legal]" value="<?php echo $merchant['legal'] ?>" placeholder="<?php echo Yii::t('admin', 'Legal'); ?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>
            <div class="space-4"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-telephone"><?php echo Yii::t('admin', 'Telephone'); ?></label>
                <div class="col-sm-9">
                    <input id="form-field-telephone" type="text" name="merchant[telephone]" value="<?php echo $merchant['telephone'] ?>" placeholder="<?php echo Yii::t('admin', 'Telephone'); ?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>
            <div class="space-4"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-bank"><?php echo Yii::t('admin', 'Bank'); ?></label>
                <div class="col-sm-9">
                    <input id="form-field-bank" type="text" name="merchant[bank]" value="<?php echo $merchant['bank'] ?>" placeholder="<?php echo Yii::t('admin', 'Bank'); ?>" class="col-xs-10 col-sm-5" />
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
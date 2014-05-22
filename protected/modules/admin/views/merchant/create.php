<?php if (!empty($message)) { ?>
<div class="alert alert-block alert-danger">
    <button type="button" class="close" data-dismiss="alert">
        <i class="icon-remove"></i>
    </button>
    <i class="icon-warning-sign"></i>&nbsp;&nbsp;<?php echo $message; ?>	
</div>
<?php } ?>
<div class="row">
    <div class="col-xs-12">
        <form action="/admin/merchant/create" method="POST" enctype="multipart/form-data" class="form-horizontal">
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="merchant[username]"><?php echo Yii::t('admin', 'Username'); ?></label>
                <div class="col-sm-9">
                    <input type="text" name="merchant[username]" value="<?php echo $merchant['username'] ?>" placeholder="<?php echo Yii::t('admin', 'Username'); ?>" class="col-xs-10 col-sm-5" />
                    <span class="help-inline col-xs-12 col-sm-7">
                        <span class="middle"><?php echo Yii::t('admin', 'Pelase input email'); ?></span>
                    </span>
                </div>
            </div>
            <div class="space-4"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="merchant[password]"><?php echo Yii::t('admin', 'Password'); ?></label>
                <div class="col-sm-9">
                    <input type="password" name="merchant[password]" value="<?php echo $merchant['password'] ?>" placeholder="<?php echo Yii::t('admin', 'Password'); ?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>
            <div class="space-4"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="merchant[repassword]"><?php echo Yii::t('admin', 'Repeat password'); ?></label>
                <div class="col-sm-9">
                    <input type="password" name="merchant[repassword]" value="<?php echo $merchant['repassword'] ?>" placeholder="<?php echo Yii::t('admin', 'Repeat password'); ?>" class="col-xs-10 col-sm-5" />
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
                <label class="col-sm-3 control-label no-padding-right" for="merchant[logo]"><?php echo Yii::t('admin', 'Logo'); ?></label>
                <div class="col-sm-9">
                    <input type="file" name="file" id="id-input-file-upload-logo" />
                </div>
            </div>
            <div class="space-4"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="merchant[category]"><?php echo Yii::t('admin', 'Category'); ?></label>
                <div class="col-sm-9">
                    <select name="merchant[category]" class="col-sm-5">
                        <?php foreach ($categories as $value) { ?>
                            <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="space-4"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="merchant[description]"><?php echo Yii::t('admin', 'Description'); ?></label>
                <div class="col-sm-9">
                    <textarea name="merchant[description]" class="col-xs-10 col-sm-5" placeholder="<?php echo Yii::t('admin', 'Description'); ?>"></textarea>
                </div>
            </div>
            <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">
                    <button class="btn btn-info" type="submit"><i class="icon-ok bigger-110"></i><?php echo Yii::t('admin', 'Create'); ?></button>
                    &nbsp; &nbsp; &nbsp;
                    <button class="btn" type="reset"><i class="icon-undo bigger-110"></i><?php echo Yii::t('admin', 'Reset'); ?></button>
                </div>
            </div>
    </div>
</div>
</div>
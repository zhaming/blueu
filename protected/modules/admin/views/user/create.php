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
        <form action="/admin/user/create" method="POST" enctype="multipart/form-data" class="form-horizontal">
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-username"><?php echo Yii::t('admin', 'Username'); ?></label>
                <div class="col-sm-9">
                    <input id="form-field-username" type="text" name="user[username]" value="<?php echo $user['username'] ?>" placeholder="<?php echo Yii::t('admin', 'Please input email'); ?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>
            <div class="space-4"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-password"><?php echo Yii::t('admin', 'Password'); ?></label>
                <div class="col-sm-9">
                    <input id="form-field-password" type="password" name="user[password]" value="<?php echo $user['password'] ?>" placeholder="<?php echo Yii::t('admin', 'Please input password'); ?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>
            <div class="space-4"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-repassword"><?php echo Yii::t('admin', 'Repeat password'); ?></label>
                <div class="col-sm-9">
                    <input id="form-field-repassword" type="password" name="user[repassword]" value="<?php echo $user['repassword'] ?>" placeholder="<?php echo Yii::t('admin', 'Please input password again'); ?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>
            <div class="space-4"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-name"><?php echo Yii::t('admin', 'Name'); ?></label>
                <div class="col-sm-9">
                    <input id="form-field-name" type="text" name="user[name]" value="<?php echo $user['name'] ?>" placeholder="<?php echo Yii::t('admin', 'Name'); ?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>
            <div class="space-4"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="id-input-file-single-upload"><?php echo Yii::t('admin', 'Avatar'); ?></label>
                <div class="col-sm-4">
                    <input id="id-input-file-single-upload" type="file" name="file" />
                </div>
            </div>
            <div class="space-4"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-sex"><?php echo Yii::t('admin', 'Sex'); ?></label>
                <div class="col-sm-9">
                    <label>
                        <input name="user[sex]" value="0" type="radio"<?php if ($user['sex']==HelpTemplate::USER_SEX_UNKNOWN) { ?> checked="checked"<?php } ?> class="ace" />
                        <span class="lbl"><?php echo Yii::t('admin', 'Unknown'); ?></span>
                    </label>&nbsp;&nbsp;&nbsp;&nbsp;
                    <label>
                        <input name="user[sex]" value="1" type="radio"<?php if ($user['sex']==HelpTemplate::USER_SEX_FEMALE) { ?> checked="checked"<?php } ?> class="ace" />
                        <span class="lbl"><?php echo Yii::t('admin', 'Female'); ?></span>
                    </label>&nbsp;&nbsp;&nbsp;&nbsp;
                    <label>
                        <input name="user[sex]" value="2" type="radio"<?php if ($user['sex']==HelpTemplate::USER_SEX_MALE) { ?> checked="checked"<?php } ?> class="ace" />
                        <span class="lbl"><?php echo Yii::t('admin', 'Male'); ?></span>
                    </label>
                </div>
            </div>
            <div class="space-4"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-mask-2"><?php echo Yii::t('admin', 'Mobile'); ?></label>
                <div class="col-sm-9">
                    <input id="form-field-mask-2" type="text" name="user[mobile]" class="col-xs-10 col-sm-5" />
                </div>
            </div>
            <div class="space-4"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-century"><?php echo Yii::t('admin', 'Century'); ?></label>
                <div class="col-sm-9">
                    <select id="form-field-century" name="user[century]" class="col-sm-5 no-padding-left">
                        <option value="other"><?php echo Yii::t('admin', 'Other'); ?></option>
                        <option value="00">00</option>
                        <option value="90">90</option>
                        <option value="80">80</option>
                        <option value="70">70</option>
                    </select>
                </div>
            </div>
            <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">
                    <button class="btn btn-info" type="submit"><i class="ace-icon glyphicon glyphicon-ok bigger-110"></i><?php echo Yii::t('admin', 'Create'); ?></button>
                    &nbsp; &nbsp; &nbsp;
                    <button class="btn" type="reset"><i class="ace-icon fa fa-undo bigger-110"></i><?php echo Yii::t('admin', 'Reset'); ?></button>
                </div>
            </div>
        </form>
    </div>
</div>
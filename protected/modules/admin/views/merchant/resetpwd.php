<div class="row">
    <div class="col-xs-12">
        <div class="space-6"></div>
        <form action="<?php echo $this->createUrl('resetpwd'); ?>" method="post" class="form-horizontal">
            <div class="tabbable">
                <ul class="nav nav-tabs padding-16">
                    <li>
                        <a href="<?php echo $this->createUrl('detail?id=' . $id); ?>">
                            <i class="green ace-icon fa fa-sun-o bigger-125"></i>
                            <?php echo Yii::t('admin', 'Overview'); ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $this->createUrl('edit?id=' . $id); ?>">
                            <i class="green ace-icon fa fa-edit bigger-125"></i>
                            <?php echo Yii::t('admin', 'Edit information'); ?>
                        </a>
                    </li>
                    <li class="active">
                        <a href="<?php echo $this->createUrl('resetpwd?id=' . $id); ?>">
                            <i class="green ace-icon fa fa-key bigger-125"></i>
                            <?php echo Yii::t('admin', 'Reset password'); ?>
                        </a>
                    </li>
                </ul>
                <div class="tab-content no-border padding-24">
                    <div id="edit-password" class="tab-pane in active">
                        <?php if (!empty($message)) { ?>
                        <div class="alert alert-block alert-danger">
                            <p><strong><?php echo $message; ?></strong></p>
                        </div>
                        <?php } ?>
                        <input type="hidden" name="merchant[id]" value="<?php echo $id; ?>" />
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-pass1"><?php echo Yii::t('admin', 'New password'); ?></label>
                            <div class="col-sm-9">
                                <input type="password" name="merchant[newpassword]" id="form-field-pass1">
                            </div>
                        </div>
                        <div class="space-4"></div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-pass2"><?php echo Yii::t('admin', 'Repeat password'); ?></label>
                            <div class="col-sm-9">
                                <input type="password" name="merchant[repassword]" id="form-field-pass2">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">
                    <button class="btn btn-info" type="submit">
                        <i class="ace-icon glyphicon glyphicon-ok bigger-110"></i>
                        <?php echo Yii::t('admin', 'Save'); ?>
                    </button>
                    &nbsp; &nbsp;
                    <button class="btn" type="reset">
                        <i class="ace-icon fa fa-undo bigger-110"></i>
                        <?php echo Yii::t('admin', 'Reset'); ?>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
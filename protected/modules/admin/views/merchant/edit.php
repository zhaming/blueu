<div class="row">
    <div class="col-xs-12">
        <div class="space-6"></div>
        <form action="<?php echo $this->createUrl('edit'); ?>" method="post" class="form-horizontal">
            <div class="tabbable">
                <ul class="nav nav-tabs padding-16">
                    <li>
                        <a href="<?php echo $this->createUrl('detail?id=' . $merchant['id']); ?>">
                            <i class="green icon-sun bigger-125"></i>
                            <?php echo Yii::t('admin', 'Overview'); ?>
                        </a>
                    </li>
                    <li class="active">
                        <a href="<?php echo $this->createUrl('edit?id=' . $merchant['id']); ?>">
                            <i class="green icon-edit bigger-125"></i>
                            <?php echo Yii::t('admin', 'Edit information'); ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $this->createUrl('resetpwd?id=' . $merchant['id']); ?>">
                            <i class="green icon-key bigger-125"></i>
                            <?php echo Yii::t('admin', 'Reset password'); ?>
                        </a>
                    </li>
                </ul>
                <div class="tab-content no-border padding-24">
                    <div id="edit-basic" class="tab-pane in active">
                        <?php if (!empty($message)) { ?>
                        <div class="alert alert-block alert-danger">
                            <p><strong><?php echo $message; ?></strong></p>
                        </div>
                        <?php } ?>
                        <input type="hidden" name="merchant[id]" value="<?php echo $merchant['id']; ?>" />
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-name"><?php echo Yii::t('admin', 'Name'); ?></label>
                            <div class="col-sm-9">
                                <span class="input-icon input-icon-right">
                                    <input id="form-field-name" type="text" name="merchant[name]" value="<?php echo $merchant['name']; ?>" />
                                    <i class="icon-user"></i>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-legal"><?php echo Yii::t('admin', 'Legal'); ?></label>
                            <div class="col-sm-9">
                                <span class="input-icon input-icon-right">
                                    <input id="form-field-legal" type="text" name="merchant[legal]" value="<?php echo $merchant['legal']; ?>" />
                                    <i class="icon-user-md"></i>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-telephone"><?php echo Yii::t('admin', 'Telephone'); ?></label>
                            <div class="col-sm-9">
                                <span class="input-icon input-icon-right">
                                    <input id="form-field-telephone" type="text" name="merchant[telephone]" value="<?php echo $merchant['telephone']; ?>" />
                                    <i class="icon-headphones"></i>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-bank"><?php echo Yii::t('admin', 'Bank'); ?></label>
                            <div class="col-sm-9">
                                <span class="input-icon input-icon-right">
                                    <input id="form-field-bank" type="text" name="merchant[bank]" value="<?php echo $merchant['bank']; ?>" />
                                    <i class="icon-money"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">
                    <button class="btn btn-info" type="submit">
                        <i class="icon-ok bigger-110"></i>
                        <?php echo Yii::t('admin', 'Save'); ?>
                    </button>
                    &nbsp; &nbsp;
                    <button class="btn" type="reset">
                        <i class="icon-undo bigger-110"></i>
                        <?php echo Yii::t('admin', 'Reset'); ?>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
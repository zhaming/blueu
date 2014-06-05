<div class="row">
    <div class="col-xs-12">
        <div class="space-6"></div>
        <?php if (!empty($message)) { ?>
        <div class="alert alert-block <?php if ($error) { ?>alert-danger<?php } else { ?>alert-success<?php } ?>">
            <p>
                <strong>
                    <i class="<?php if ($error) { ?>icon-remove<?php } else { ?>icon-ok<?php } ?>"></i>
                    <?php echo $message; ?>
                </strong>
            </p>
        </div>
        <?php } ?>
        <form action="<?php echo $this->createUrl('profile'); ?>" method="post" class="form-horizontal">
            <div class="tabbable">
                <ul class="nav nav-tabs padding-16">
                    <li class="active">
                        <a data-toggle="tab" href="#basic">
                            <i class="green icon-sun bigger-125"></i>
                            <?php echo Yii::t('admin', 'Overview'); ?>
                        </a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#edit-password">
                            <i class="blue icon-key bigger-125"></i>
                            <?php echo Yii::t('admin', 'Reset password'); ?>
                        </a>
                    </li>
                </ul>
                <div class="tab-content no-border padding-24">
                    <div id="basic" class="tab-pane<?php if (!$error) { ?> in active<?php } ?>">
                        <div class="col-xs-12 col-sm-2"></div>
                        <div class="col-xs-12 col-sm-4">
                            <div class="profile-user-info">
                                <div class="profile-info-row">
                                    <div class="profile-info-name"><?php echo Yii::t('admin', 'Username'); ?></div>
                                    <div class="profile-info-value">
                                        <span><?php echo $account->username; ?></span>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name"><?php echo Yii::t('admin', 'Role'); ?></div>
                                    <div class="profile-info-value">
                                        <i class="icon-map-marker light-orange bigger-110"></i>
                                        <span><?php echo HelpTemplate::role($account->roleid); ?></span>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name"><?php echo Yii::t('admin', 'Registration time'); ?></div>
                                    <div class="profile-info-value">
                                        <span><?php echo date('Y/m/d H:i:s', $account->registertime); ?></span>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name"><?php echo Yii::t('admin', 'Last Online'); ?></div>
                                    <div class="profile-info-value">
                                        <span><?php echo date('Y/m/d H:i:s', $account->logintime); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-2"></div>
                    </div>
                    <div id="edit-password" class="tab-pane<?php if ($error) { ?> in active<?php } ?>">
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-pass1"><?php echo Yii::t('admin', 'Password'); ?></label>
                            <div class="col-sm-9">
                                <input type="password" name="password" id="form-field-pass1">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-pass2"><?php echo Yii::t('admin', 'New password'); ?></label>
                            <div class="col-sm-9">
                                <input type="password" name="newpassword" id="form-field-pass2">
                            </div>
                        </div>
                        <div class="space-4"></div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-pass3"><?php echo Yii::t('admin', 'Repeat password'); ?></label>
                            <div class="col-sm-9">
                                <input type="password" name="repassword" id="form-field-pass3">
                            </div>
                        </div>
                        <div class="clearfix form-actions">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="submit" class="btn btn-info">
                                    <i class="icon-ok bigger-110"></i>
                                    <?php echo Yii::t('admin', 'Save'); ?>
                                </button>
                                &nbsp; &nbsp;
                                <button type="reset" class="btn">
                                    <i class="icon-undo bigger-110"></i>
                                    <?php echo Yii::t('admin', 'Reset'); ?>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
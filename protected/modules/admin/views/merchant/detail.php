<div class="row">
    <div class="col-xs-12">
        <div class="space-6"></div>
        <div class="tabbable">
            <ul class="nav nav-tabs padding-16">
                <li class="active">
                    <a href="<?php echo $this->createUrl('detail?id=' . $merchant['id']); ?>">
                        <i class="green icon-user bigger-125"></i>
                        <?php echo Yii::t('admin', 'Overview'); ?>
                    </a>
                </li>
                <li>
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
                <div id="basic" class="tab-pane in active">
                    <?php $message = Yii::app()->user->getFlash('messagetip'); if ($message != null) { ?>
                    <div class="alert alert-block<?php if ($message['type'] == 'success') { ?> alert-success<?php } ?><?php if ($message['type'] == 'error') { ?> alert-denger<?php } ?>">
                        <p>
                            <strong>
                                <i class="<?php if ($message['type'] == 'success') { ?>icon-ok<?php } ?><?php if ($message['type'] == 'error') { ?>icon-remove<?php } ?>"></i>
                                <?php echo $message['msg']; ?>
                            </strong>
                        </p>
                    </div>
                    <?php } ?>
                    <div class="col-xs-12 col-sm-2"></div>
                    <div class="col-xs-12 col-sm-4">
                        <div class="profile-user-info">
                            <div class="profile-info-row">
                                <div class="profile-info-name"><?php echo Yii::t('admin', 'Username'); ?></div>
                                <div class="profile-info-value">
                                    <span><?php echo $merchant->account->username; ?></span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"><?php echo Yii::t('admin', 'Role'); ?></div>
                                <div class="profile-info-value">
                                    <i class="icon-map-marker light-orange bigger-110"></i>
                                    <span><?php echo HelpTemplate::role($merchant->account->roleid); ?></span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"><?php echo Yii::t('admin', 'Registration time'); ?></div>
                                <div class="profile-info-value">
                                    <span><?php echo date('Y/m/d H:i:s', $merchant->account->registertime); ?></span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"><?php echo Yii::t('admin', 'Last Online'); ?></div>
                                <div class="profile-info-value">
                                    <span><?php echo date('Y/m/d H:i:s', $merchant->account->logintime); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-2"></div>
                </div>
            </div>
        </div>
    </div>
</div>
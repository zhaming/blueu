<div class="row">
    <div class="col-xs-12">
        <div class="space-6"></div>
        <div class="tabbable">
            <ul class="nav nav-tabs padding-16">
                <li class="active">
                    <a href="<?php echo $this->createUrl('detail?id=' . $user['id']); ?>">
                        <i class="green icon-sun bigger-125"></i>
                        <?php echo Yii::t('admin', 'Overview'); ?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $this->createUrl('edit?id=' . $user['id']); ?>">
                        <i class="green icon-edit bigger-125"></i>
                        <?php echo Yii::t('admin', 'Edit information'); ?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $this->createUrl('resetpwd?id=' . $user['id']); ?>">
                        <i class="blue icon-key bigger-125"></i>
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
                    <div class="row">
                        <div class="col-xs-12 col-sm-3 center">
                            <span class="profile-picture">
                                <img id="avatar" class="editable img-responsive" alt="<?php echo $user['name']; ?>" src="<?php echo HelpTemplate::getAvatarUrl($user['avatar']); ?>"></img>
                            </span>
                        </div>
                        <div class="col-xs-12 col-sm-9">
                            <div class="profile-user-info">
                                <div class="profile-info-row">
                                    <div class="profile-info-name"><?php echo Yii::t('admin', 'Username'); ?></div>
                                    <div class="profile-info-value">
                                        <span><?php echo $user['account']['username']; ?></span>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name"><?php echo Yii::t('admin', 'Status'); ?></div>
                                    <div class="profile-info-value">
                                        <span><?php echo HelpTemplate::accountStatus($user['account']['status']); ?></span>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name"><?php echo Yii::t('admin', 'Name'); ?></div>
                                    <div class="profile-info-value">
                                        <span><?php echo $user['name']; ?>&nbsp;</span>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name"><?php echo Yii::t('admin', 'Sex'); ?></div>
                                    <div class="profile-info-value">
                                        <span><?php echo HelpTemplate::sex($user['sex']); ?></span>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name"><?php echo Yii::t('admin', 'Century'); ?></div>
                                    <div class="profile-info-value">
                                        <span><?php echo $user['century']; ?>&nbsp;</span>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name"><?php echo Yii::t('admin', 'Mobile'); ?></div>
                                    <div class="profile-info-value">
                                        <span><?php echo $user['mobile']; ?>&nbsp;</span>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name"><?php echo Yii::t('admin', 'Push'); ?></div>
                                    <div class="profile-info-value">
                                        <span><?php echo HelpTemplate::yesOrNo($user['pushable']); ?></span>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name"><?php echo Yii::t('admin', 'Registration time'); ?></div>
                                    <div class="profile-info-value">
                                        <span><?php echo date('Y/m/d H:i:s', $user['account']['registertime']); ?></span>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name"><?php echo Yii::t('admin', 'Last Online'); ?></div>
                                    <div class="profile-info-value">
                                        <span><?php echo date('Y/m/d H:i:s', $user['account']['logintime']); ?></span>
                                    </div>
                                </div>
                            </div>                                
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
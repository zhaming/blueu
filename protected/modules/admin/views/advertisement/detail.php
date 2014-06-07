<div class="row">
    <div class="col-xs-12">
        <div class="space-6"></div>
        <div class="tabbable">
            <ul class="nav nav-tabs padding-16">
                <li class="active">
                    <a href="<?php echo $this->createUrl('detail?id=' . $ad['id']); ?>">
                        <i class="green ace-icon fa fa-sun-o bigger-125"></i>
                        <?php echo Yii::t('admin', 'Overview'); ?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $this->createUrl('edit?id=' . $ad['id']); ?>">
                        <i class="green ace-icon fa fa-edit bigger-125"></i>
                        <?php echo Yii::t('admin', 'Edit information'); ?>
                    </a>
                </li>
            </ul>
            <div class="tab-content no-border padding-24">
                <div id="basic" class="tab-pane in active">
                    <div class="row">
                        <div class="col-xs-12 col-sm-3 center">
                            <span class="profile-picture">
                                <img class="edit-picture editable img-responsive" data-value="<?php echo $ad['id']; ?>-2" src="<?php echo HelpTemplate::getAdUrl($ad['pic']); ?>" />
                            </span>
                        </div>
                        <div class="col-xs-12 col-sm-9">
                            <div class="profile-user-info">
                                <div class="profile-info-row">
                                    <div class="profile-info-name"><?php echo Yii::t('admin', 'Description'); ?></div>
                                    <div class="profile-info-value">
                                        <span><?php echo $ad['desc']; ?>&nbsp;</span>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name"><?php echo Yii::t('admin', 'Url'); ?></div>
                                    <div class="profile-info-value">
                                        <span><?php echo $ad['url']; ?>&nbsp;</span>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name"><?php echo Yii::t('admin', 'Place tag'); ?></div>
                                    <div class="profile-info-value">
                                        <span><?php echo $ad['placetag']; ?></span>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name"><?php echo Yii::t('admin', 'Owner'); ?></div>
                                    <div class="profile-info-value">
                                        <span><?php echo $ad['account']['username']; ?></span>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name"><?php echo Yii::t('admin', 'Created'); ?></div>
                                    <div class="profile-info-value">
                                        <span><?php echo date('Y/m/d H:i:s', $ad['created']); ?></span>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name"><?php echo Yii::t('admin', 'Disabled'); ?></div>
                                    <div class="profile-info-value">
                                        <span><?php if ($ad['disabled']) { echo Yii::t('admin', 'Yes'); } else { echo Yii::t('admin', 'No'); } ?></span>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name"><?php echo Yii::t('admin', 'Source'); ?></div>
                                    <div class="profile-info-value">
                                        <span><?php echo HelpTemplate::adSource($ad['source']); ?></span>
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
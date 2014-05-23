<div class="row">
    <div class="col-xs-12 col-sm-2">
        
    </div>
    <div class="col-xs-12 col-sm-4">
        <div class="space-10"></div>
        <div class="profile-user-info">
            <div class="profile-info-row">
                <div class="profile-info-name"></div>
                <div class="profile-info-value text-right">
                    <a href="/admin/manager/edit" class="no-underline">
                        <i class="orange icon-edit bigger-200"></i>
                    </a>
                </div>
            </div>
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
</div>
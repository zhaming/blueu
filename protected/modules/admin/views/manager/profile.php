<div class="page-header">
    <h1>管理员信息</h1>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-2"></div>
    <div class="col-xs-12 col-sm-4">
        <h4 class="blue">
            <a href="/admin/manager/edit" class="no-underline">
                <i class="orange icon-edit bigger-120"></i>
            </a>
        </h4>
        <div class="profile-user-info">
            <div class="profile-info-row">
                <div class="profile-info-name">Username</div>
                <div class="profile-info-value">
                    <span><?php echo $account->username; ?></span>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-name"> Location </div>

                <div class="profile-info-value">
                    <i class="icon-map-marker light-orange bigger-110"></i>
                    <span>Netherlands</span>
                    <span>Amsterdam</span>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-name"> Age </div>
                <div class="profile-info-value">
                    <span>38</span>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-name"> Joined </div>
                <div class="profile-info-value">
                    <span><?php echo date('Y-m-d H:i:s', $account->registertime); ?></span>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-name"> Last Online </div>
                <div class="profile-info-value">
                    <span><?php echo date('Y-m-d H:i:s', $account->logintime); ?></span>
                </div>
            </div>
        </div>
    </div>
</div>
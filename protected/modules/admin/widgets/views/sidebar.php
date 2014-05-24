<div class="sidebar" id="sidebar">
    <script type="text/javascript">
        try {
            ace.settings.check('sidebar', 'fixed')
        } catch (e) {
        }
    </script>
    <div class="sidebar-shortcuts" id="sidebar-shortcuts">
        <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
            <button class="btn btn-success">
                <i class="icon-signal"></i>
            </button>
            <button class="btn btn-info">
                <i class="icon-pencil"></i>
            </button>
            <button class="btn btn-warning">
                <i class="icon-group"></i>
            </button>

            <button class="btn btn-danger">
                <i class="icon-cogs"></i>
            </button>
        </div>
        <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
            <span class="btn btn-success"></span>
            <span class="btn btn-info"></span>
            <span class="btn btn-warning"></span>
            <span class="btn btn-danger"></span>
        </div>
    </div>
    <ul class="nav nav-list">
        <li<?php if (Yii::app()->controller->id == 'site') { ?> class="active"<?php } ?>>
            <a href="/admin">
                <i class="icon-dashboard"></i>
                <span class="menu-text"><?php echo Yii::t('admin', 'Console'); ?></span>
            </a>
        </li>
        <?php if (HelpTemplate::isLoginAsAdmin()) { ?>
        <li<?php if (in_array(Yii::app()->controller->id, array('user', 'merchant', 'manager'))) { ?> class="active"<?php } ?>>
            <a class="dropdown-toggle">
                <i class="icon-user"></i>
                <span class="menu-text cursor-default"><?php echo Yii::t('admin', 'User manaer'); ?></span>
                <b class="arrow icon-angle-down"></b>
            </a>
            <ul class="submenu">
                <li<?php if (Yii::app()->controller->getId() == 'merchant') { ?> class="active"<?php } ?>>
                    <a href="/admin/merchant"><i class="icon-double-angle-right"></i><?php echo Yii::t('admin', 'Merchant manager'); ?></a>
                </li>
                <li<?php if (Yii::app()->controller->getId() == 'user') { ?> class="active"<?php } ?>>
                    <a href="/admin/user"><i class="icon-double-angle-right"></i><?php echo Yii::t('admin', 'Client user'); ?></a>
                </li>
                <?php if (Yii::app()->user->getId() == 1) { ?>
                <li<?php if (Yii::app()->controller->getId() == 'manager') { ?> class="active"<?php } ?>>
                    <a href="/admin/manager"><i class="icon-double-angle-right"></i><?php echo Yii::t('admin', 'Administrator manager'); ?></a>
                </li>
                <?php } ?>
            </ul>
        </li>
        <?php } ?>
        <li<?php if (Yii::app()->controller->id == 'merchantshop') { ?> class="active"<?php } ?>>
            <a class="dropdown-toggle">
                <i class="icon-home"></i>
                <span class="menu-text"><?php echo Yii::t('admin', 'Merchant shop_manager'); ?></span>
            </a>
            <ul class="submenu">
                <li<?php if (Yii::app()->controller->getId() == 'merchantshop' && Yii::app()->controller->getAction()->getId() == 'index') { ?> class="active"<?php } ?>>
                    <a href="/admin/merchantshop/index"><i class="icon-double-angle-right"></i><?php echo  Yii::t("shop","Shop List")?></a>
                </li>
                <li<?php if (Yii::app()->controller->getId() == 'merchantshop' && Yii::app()->controller->getAction()->getId() == 'create') { ?> class="active"<?php } ?>>
                    <a href="/admin/merchantshop/create"><i class="icon-double-angle-right"></i><?php echo  Yii::t("shop","Shop Create")?></a>
                </li>
            </ul>
        </li>
        <li<?php if (Yii::app()->controller->id == 'merchantproduct') { ?> class="active"<?php } ?>>
            <a class="dropdown-toggle">
                <i class="icon-home"></i>
                <span class="menu-text"><?php echo Yii::t("shop","Product Manager")?></span>
            </a>
            <ul class="submenu">
                <li<?php if (Yii::app()->controller->getId() == 'merchantproduct' && Yii::app()->controller->getAction()->getId() == 'index') { ?> class="active"<?php } ?>>
                    <a href="/admin/merchantproduct/index"><i class="icon-double-angle-right"></i><?php echo Yii::t("shop","Product List")?></a>
                </li>
                <li<?php if (Yii::app()->controller->getId() == 'merchantproduct' && Yii::app()->controller->getAction()->getId() == 'create') { ?> class="active"<?php } ?>>
                    <a href="/admin/merchantproduct/create"><i class="icon-double-angle-right"></i><?php echo Yii::t("shop","Product Create")?></a>
                </li>
            </ul>
        </li>
        <li<?php if (Yii::app()->controller->id == 'merchantcoupon') { ?> class="active"<?php } ?>>
            <a class="dropdown-toggle">
                <i class=" icon-gift"></i>
                <span class="menu-text"><?php echo Yii::t("shop","Coupon Manager")?></span>
            </a>
            <ul class="submenu">
                <li<?php if (Yii::app()->controller->getId() == 'merchantcoupon' && Yii::app()->controller->getAction()->getId() == 'index') { ?> class="active"<?php } ?>>
                    <a href="/admin/merchantcoupon/index"><i class="icon-double-angle-right"></i><?php echo Yii::t("shop","Coupon List")?></a>
                </li>
                <li<?php if (Yii::app()->controller->getId() == 'merchantcoupon' && Yii::app()->controller->getAction()->getId() == 'create') { ?> class="active"<?php } ?>>
                    <a href="/admin/merchantcoupon/create"><i class="icon-double-angle-right"></i><?php echo Yii::t("shop","Coupon Create")?></a>
                </li>
            </ul>
        </li>

        <li<?php if (Yii::app()->controller->id == 'activity') { ?> class="active"<?php } ?>>
            <a class="dropdown-toggle">
                <i class="icon-list"></i>
                <span class="menu-text cursor-default"><?php echo Yii::t('admin', 'Activity manager'); ?></span>
                <b class="arrow icon-angle-down"></b>
            </a>
            <ul class="submenu">
                <li<?php if (Yii::app()->controller->getId() == 'activity' && Yii::app()->controller->getAction()->getId() == 'index') { ?> class="active"<?php } ?>>
                    <a href="/admin/activity/index"><i class="icon-double-angle-right"></i>活动列表</a>
                </li>
                <li<?php if (Yii::app()->controller->getId() == 'activity' && Yii::app()->controller->getAction()->getId() == 'template') { ?> class="active"<?php } ?>>
                    <a href="/admin/activity/template"><i class="icon-double-angle-right"></i>活动模版</a>
                </li>
            </ul>
        </li>
        <li<?php if (Yii::app()->controller->id == 'stat') { ?> class="active"<?php } ?>>
            <a class="dropdown-toggle">
                <i class="icon-legal"></i>
                <span class="menu-text cursor-default"><?php echo Yii::t('admin', 'Statistic Manager'); ?></span>
                <b class="arrow icon-angle-down"></b>
            </a>
            <ul class="submenu">
                <li<?php if (Yii::app()->controller->getId() == 'stat' && Yii::app()->controller->getAction()->getId() == 'user') { ?> class="active"<?php } ?>>
                    <a href="/admin/stat/user"><i class="icon-double-angle-right"></i><?php echo Yii::t('admin', 'User Analytics'); ?></a>
                </li>
                <li<?php if (Yii::app()->controller->getId() == 'stat' && Yii::app()->controller->getAction()->getId() == 'industry') { ?> class="active"<?php } ?>>
                    <a href="/admin/stat/industry"><i class="icon-double-angle-right"></i><?php echo Yii::t('admin', 'Industry Analytics'); ?></a>
                </li>
            </ul>
        </li>
        <li<?php if (Yii::app()->controller->id == 'push') { ?> class="active"<?php } ?>>
            <a href="/admin/push">
                <i class="icon-list-alt"></i>
                <span class="menu-text">推送管理</span>
            </a>
        </li>
        <?php if (HelpTemplate::isLoginAsAdmin()) { ?>
        <li<?php if (in_array(Yii::app()->controller->id, array('settings', 'log'))) { ?> class="active"<?php } ?>>
            <a class="dropdown-toggle">
                <i class="icon-legal"></i>
                <span class="menu-text cursor-default"><?php echo Yii::t('admin', 'System manager'); ?></span>
                <b class="arrow icon-angle-down"></b>
            </a>
            <ul class="submenu">
                <li<?php if (Yii::app()->controller->getId() == 'settings') { ?> class="active"<?php } ?>>
                    <a href="/admin/settings"><i class="icon-double-angle-right"></i><?php echo Yii::t('admin', 'System settings'); ?></a>
                </li>
                <li<?php if (Yii::app()->controller->getId() == 'log') { ?> class="active"<?php } ?>>
                    <a href="/admin/log"><i class="icon-double-angle-right"></i><?php echo Yii::t('admin', 'Log manager'); ?></a>
                </li>
            </ul>
        </li>
        <?php } ?>
    </ul>
    <div id="sidebar-collapse" class="sidebar-collapse">
        <i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
    </div>
    <script type="text/javascript">
        try {
            ace.settings.check('sidebar', 'collapsed');
        } catch (e) {
            console.log(e);
        }
    </script>
</div>
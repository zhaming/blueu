<!-- #section:basics/sidebar -->
<div id="sidebar" class="sidebar responsive">
    <div class="sidebar-shortcuts" id="sidebar-shortcuts">       
        <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
            <a href="/admin/user/index" title="<?php echo Yii::t('admin', 'Client user'); ?>" class="btn btn-success">
                <i class="ace-icon fa fa-user"></i>
            </a>
            <a href="/admin/merchantshop/create" title="<?php echo Yii::t('admin', 'Create shop'); ?>" class="btn btn-info">
                <i class="ace-icon fa fa-shopping-cart"></i>
            </a>
            <a href="/admin/stat/user" title="<?php echo Yii::t('admin', 'User stat'); ?>" class="btn btn-warning">
                <i class="ace-icon fa fa-bar-chart-o"></i>
            </a>
            <a href="/admin/log/index" title="<?php echo Yii::t('admin', 'Log'); ?>" class="btn btn-danger">
                <i class="ace-icon glyphicon glyphicon-time"></i>
            </a>
        </div>
    </div>
    <!-- /.sidebar-shortcuts -->
    <ul class="nav nav-list">
        <li<?php if (Yii::app()->controller->id == 'site') { ?> class="active"<?php } ?>>
            <a href="/admin">
                <i class="menu-icon fa fa-dashboard"></i>
                <span class="menu-text"><?php echo Yii::t('admin', 'Console'); ?></span>
            </a>
        </li>
        <?php if (HelpTemplate::isLoginAsAdmin()) { ?>
            <li<?php if (in_array(Yii::app()->controller->id, array('user', 'merchant', 'manager'))) { ?> class="active"<?php } ?>>
                <a class="dropdown-toggle">
                    <i class="menu-icon fa fa-user"></i>
                    <span class="menu-text cursor-default"><?php echo Yii::t('admin', 'User'); ?></span>
                    <b class="arrow icon-angle-down"></b>
                </a>
                <ul class="submenu">
                    <li<?php if (Yii::app()->controller->getId() == 'merchant') { ?> class="active"<?php } ?>>
                        <a href="/admin/merchant"><i class="icon-double-angle-right"></i><?php echo Yii::t('admin', 'Merchant'); ?></a>
                    </li>
                    <li<?php if (Yii::app()->controller->getId() == 'user') { ?> class="active"<?php } ?>>
                        <a href="/admin/user"><i class="icon-double-angle-right"></i><?php echo Yii::t('admin', 'Client'); ?></a>
                    </li>
                    <?php if (Yii::app()->user->getId() == 1) { ?>
                        <li<?php if (Yii::app()->controller->getId() == 'manager') { ?> class="active"<?php } ?>>
                            <a href="/admin/manager"><i class="icon-double-angle-right"></i><?php echo Yii::t('admin', 'Administrator'); ?></a>
                        </li>
                    <?php } ?>
                </ul>
            </li>

            <li<?php if (Yii::app()->controller->getId() == 'station') { ?> class="active"<?php } ?>>
                <a class="dropdown-toggle">
                    <i class="menu-icon fa fa-rss"></i>
                    <span class="menu-text cursor-default"><?php echo Yii::t('station', 'Station Manager'); ?></span>
                    <b class="arrow icon-angle-down"></b>
                </a>
                <ul class="submenu">
                    <li<?php if (Yii::app()->controller->getId() == 'station' && Yii::app()->controller->getAction()->getId() == 'index') { ?> class="active"<?php } ?>>
                        <a href="/admin/station/index"><i class="icon-double-angle-right"></i><?php echo Yii::t("station", "Station List") ?></a>
                    </li>
                    <li<?php if (Yii::app()->controller->getId() == 'station' && Yii::app()->controller->getAction()->getId() == 'create') { ?> class="active"<?php } ?>>
                        <a href="/admin/station/create"><i class="icon-double-angle-right"></i><?php echo Yii::t("station", "Station Create") ?></a>
                    </li>
                </ul>
            </li>
        <?php } ?>
        <li<?php if (Yii::app()->controller->id == 'merchantshop') { ?> class="active"<?php } ?>>
            <a class="dropdown-toggle">
                <i class="menu-icon fa fa-shopping-cart"></i>
                <span class="menu-text cursor-default"><?php echo Yii::t('admin', 'Merchant shop_manager'); ?></span>
                <b class="arrow icon-angle-down"></b>
            </a>
            <ul class="submenu">
                <li<?php if (Yii::app()->controller->getId() == 'merchantshop' && Yii::app()->controller->getAction()->getId() == 'index') { ?> class="active"<?php } ?>>
                    <a href="/admin/merchantshop/index"><i class="icon-double-angle-right"></i><?php echo Yii::t("shop", "Shop List") ?></a>
                </li>
                <li<?php if (Yii::app()->controller->getId() == 'merchantshop' && Yii::app()->controller->getAction()->getId() == 'create') { ?> class="active"<?php } ?>>
                    <a href="/admin/merchantshop/create"><i class="icon-double-angle-right"></i><?php echo Yii::t("shop", "Shop Create") ?></a>
                </li>
            </ul>
        </li>
        <li<?php if (Yii::app()->controller->id == 'merchantproduct') { ?> class="active"<?php } ?>>
            <a class="dropdown-toggle">
                <i class="menu-icon fa fa-list"></i>
                <span class="menu-text cursor-default"><?php echo Yii::t('admin', 'ProductManager'); ?></span>
                <b class="arrow icon-angle-down"></b>
            </a>
            <ul class="submenu">
                <li<?php if (Yii::app()->controller->getId() == 'merchantproduct' && Yii::app()->controller->getAction()->getId() == 'index') { ?> class="active"<?php } ?>>
                    <a href="/admin/merchantproduct/index"><i class="icon-double-angle-right"></i><?php echo Yii::t("shop", "Product List") ?></a>
                </li>
                <li<?php if (Yii::app()->controller->getId() == 'merchantproduct' && Yii::app()->controller->getAction()->getId() == 'create') { ?> class="active"<?php } ?>>
                    <a href="/admin/merchantproduct/create"><i class="icon-double-angle-right"></i><?php echo Yii::t("shop", "Product Create") ?></a>
                </li>
            </ul>
        </li>
        <li<?php if (Yii::app()->controller->id == 'merchantcoupon') { ?> class="active"<?php } ?>>
            <a class="dropdown-toggle">
                <i class="menu-icon fa fa-signal"></i>
                <span class="menu-text cursor-default"><?php echo Yii::t('shop', 'Coupon Manager'); ?></span>
                <b class="arrow icon-angle-down"></b>
            </a>
            <ul class="submenu">
                <li<?php if (Yii::app()->controller->getId() == 'merchantcoupon' && Yii::app()->controller->getAction()->getId() == 'index') { ?> class="active"<?php } ?>>
                    <a href="/admin/merchantcoupon/index"><i class="icon-double-angle-right"></i><?php echo Yii::t("shop", "Coupon List") ?></a>
                </li>
                <li<?php if (Yii::app()->controller->getId() == 'merchantcoupon' && Yii::app()->controller->getAction()->getId() == 'create') { ?> class="active"<?php } ?>>
                    <a href="/admin/merchantcoupon/create"><i class="icon-double-angle-right"></i><?php echo Yii::t("shop", "Coupon Create") ?></a>
                </li>
                <li<?php if (Yii::app()->controller->getId() == 'merchantcoupon' && Yii::app()->controller->getAction()->getId() == 'validatecoupon') { ?> class="active"<?php } ?>>
                    <a href="/admin/merchantcoupon/validatecoupon"><i class="icon-double-angle-right"></i><?php echo Yii::t("shop", "Coupon use") ?></a>
                </li>
            </ul>
        </li>
        <!--stamp-->
        <li<?php if (Yii::app()->controller->id == 'merchantstamp') { ?> class="active"<?php } ?>>
            <a class="dropdown-toggle">
                <i class="menu-icon fa fa-gift"></i>
                <span class="menu-text cursor-default"><?php echo Yii::t('shop', 'Stamp Manager'); ?></span>
                <b class="arrow icon-angle-down"></b>
            </a>
            <ul class="submenu">
                <li<?php if (Yii::app()->controller->getId() == 'merchantstamp' && Yii::app()->controller->getAction()->getId() == 'index') { ?> class="active"<?php } ?>>
                    <a href="/admin/merchantstamp/index"><i class="icon-double-angle-right"></i><?php echo Yii::t("shop", "Stamp List") ?></a>
                </li>
                <li<?php if (Yii::app()->controller->getId() == 'merchantstamp' && Yii::app()->controller->getAction()->getId() == 'create') { ?> class="active"<?php } ?>>
                    <a href="/admin/merchantstamp/create"><i class="icon-double-angle-right"></i><?php echo Yii::t("shop", "Stamp Create") ?></a>
                </li>
            </ul>
        </li>

        <!--li<?php if (Yii::app()->controller->id == 'activity') { ?> class="active"<?php } ?>>
            <a class="dropdown-toggle">
                <i class="menu-icon fa fa-adjust"></i>
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
        </li-->
        <li<?php if (Yii::app()->controller->id == 'stat') { ?> class="active"<?php } ?>>
            <a class="dropdown-toggle">
                <i class="menu-icon fa fa-bar-chart-o"></i>
                <span class="menu-text cursor-default"><?php echo Yii::t('admin', 'Statistic Manager'); ?></span>
                <b class="arrow icon-angle-down"></b>
            </a>
            <ul class="submenu">
                <?php if (HelpTemplate::isLoginAsAdmin()) { ?>
                    <li<?php if (Yii::app()->controller->getId() == 'stat' && Yii::app()->controller->getAction()->getId() == 'user') { ?> class="active"<?php } ?>>
                        <a href="/admin/stat/user"><i class="icon-double-angle-right"></i><?php echo Yii::t('admin', 'User Analytics'); ?></a>
                    </li>
                    <li<?php if (Yii::app()->controller->getId() == 'stat' && Yii::app()->controller->getAction()->getId() == 'industry') { ?> class="active"<?php } ?>>
                        <a href="/admin/stat/industry"><i class="icon-double-angle-right"></i><?php echo Yii::t('admin', 'Industry Analytics'); ?></a>
                    </li>
                <?php } ?>
                <li<?php if (Yii::app()->controller->getId() == 'stat' && Yii::app()->controller->getAction()->getId() == 'shop') { ?> class="active"<?php } ?>>
                    <a href="/admin/stat/shop"><i class="icon-double-angle-right"></i><?php echo Yii::t('admin', 'Shop Analytics'); ?></a>
                </li>
            </ul>
        </li>
        <?php if (HelpTemplate::isLoginAsAdmin()) { ?>
            <li<?php if (Yii::app()->controller->id == 'push') { ?> class="active"<?php } ?>>
                <a class="dropdown-toggle">
                    <i class="menu-icon glyphicon glyphicon-pushpin"></i>
                    <span class="menu-text cursor-default"><?php echo Yii::t('admin', 'PushManager'); ?></span>
                    <b class="arrow icon-angle-down"></b>
                </a>
                <ul class="submenu">
                    <li<?php if (Yii::app()->controller->getId() == 'push' && Yii::app()->controller->getAction()->getId() == 'list') { ?> class="active"<?php } ?>>
                        <a href="/admin/push/list"><i class="icon-double-angle-right"></i><?php echo Yii::t('admin', 'PushList'); ?></a>
                    </li>
                    <li<?php if (Yii::app()->controller->getId() == 'push' && Yii::app()->controller->getAction()->getId() == 'manual') { ?> class="active"<?php } ?>>
                        <a href="/admin/push/manual"><i class="icon-double-angle-right"></i><?php echo Yii::t('admin', 'PushManual'); ?></a>
                    </li>
                </ul>
            </li>
            <li<?php if (Yii::app()->controller->id == 'advertisement') { ?> class="active"<?php } ?>>
                <a href="/admin/advertisement/index">
                    <i class="menu-icon fa fa-film"></i>
                    <span class="menu-text"><?php echo Yii::t('admin', 'Advertisement'); ?></span>
                </a>
            </li>
            <li<?php if (in_array(Yii::app()->controller->id, array('settings', 'log', 'task', 'map'))) { ?> class="active"<?php } ?>>
                <a class="dropdown-toggle">
                    <i class="menu-icon fa fa-wrench"></i>
                    <span class="menu-text cursor-default"><?php echo Yii::t('admin', 'System'); ?></span>
                    <b class="arrow icon-angle-down"></b>
                </a>
                <ul class="submenu">
                    <li<?php if (Yii::app()->controller->getId() == 'task' && Yii::app()->controller->getAction()->getId() == 'list') { ?> class="active"<?php } ?>>
                        <a href="/admin/task/list"><i class="icon-double-angle-right"></i><?php echo Yii::t('admin', 'TaskManager'); ?></a>
                    </li>
                    <li<?php if (Yii::app()->controller->getId() == 'task' && Yii::app()->controller->getAction()->getId() == 'log') { ?> class="active"<?php } ?>>
                        <a href="/admin/task/log"><i class="icon-double-angle-right"></i><?php echo Yii::t('admin', 'TaskLogkManager'); ?></a>
                    </li>
                    <li<?php if (Yii::app()->controller->getId() == 'map') { ?> class="active"<?php } ?>>
                        <a href="/admin/map"><i class="icon-double-angle-right"></i><?php echo Yii::t('admin', 'MapManager'); ?></a>
                    </li>
                    <li<?php if (Yii::app()->controller->getId() == 'settings') { ?> class="active"<?php } ?>>
                        <a href="/admin/settings"><i class="icon-double-angle-right"></i><?php echo Yii::t('admin', 'Settings'); ?></a>
                    </li>
                    <li<?php if (Yii::app()->controller->getId() == 'log') { ?> class="active"<?php } ?>>
                        <a href="/admin/log"><i class="icon-double-angle-right"></i><?php echo Yii::t('admin', 'Log'); ?></a>
                    </li>
                </ul>
            </li>
        <?php } ?>
    </ul>
    <!-- /.nav-list -->
    <!-- #section:basics/sidebar.layout.minimize -->
    <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
        <i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
    </div>
</div>
<!-- /section:basics/sidebar -->

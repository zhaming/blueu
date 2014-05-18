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
                <span class="menu-text">控制台</span>
            </a>
        </li>
        <li<?php if (Yii::app()->controller->id == 'user') { ?> class="active"<?php } ?>>
            <a href="/admin/user">
                <i class="icon-text-width"></i>
                <span class="menu-text"><?php echo Yii::t('admin','User manaer'); ?></span>
            </a>
        </li>
        <li<?php if (Yii::app()->controller->id == 'merchant') { ?> class="active"<?php } ?>>
            <a href="/admin/merchant">
                <i class="icon-desktop"></i>
                <span class="menu-text"><?php echo Yii::t('admin','Merchant manager'); ?></span>
            </a>
        </li>
        <li<?php if (Yii::app()->controller->id == 'activity') { ?> class="active"<?php } ?>>
            <a class="dropdown-toggle">
                <i class="icon-list"></i>
                <span class="menu-text cursor-default"><?php echo Yii::t('admin','Activity manager'); ?></span>
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
        <li<?php if (Yii::app()->controller->id == 'statistics') { ?> class="active"<?php } ?>>
            <a href="/admin/statistics">
                <i class="icon-edit"></i>
                <span class="menu-text">统计管理</span>
            </a>
        </li>
        <li<?php if (Yii::app()->controller->id == 'push') { ?> class="active"<?php } ?>>
            <a href="/admin/push">
                <i class="icon-list-alt"></i>
                <span class="menu-text">推送管理</span>
            </a>
        </li>
        <li<?php if (Yii::app()->controller->id == 'sys') { ?> class="active"<?php } ?>>
            <a href="/admin/sys">
                <i class="icon-picture"></i>
                <span class="menu-text">系统管理</span>
            </a>
        </li>
    </ul>

    <div class="sidebar-collapse" id="sidebar-collapse">
        <i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
    </div>

    <script type="text/javascript">
        try {
            ace.settings.check('sidebar', 'collapsed');
        } catch (e) {
            
        }
    </script>
</div>
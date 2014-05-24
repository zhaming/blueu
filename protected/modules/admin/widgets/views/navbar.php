<div class="navbar navbar-default" id="navbar">
    <script type="text/javascript">
        try {
            ace.settings.check('navbar', 'fixed')
        } catch (e) {
        }
    </script>

    <div class="navbar-container" id="navbar-container">
        <div class="navbar-header pull-left">
            <a href="#" class="navbar-brand">
                <small>BLUEU后台管理系统</small>
            </a>
        </div>
        <div class="navbar-header pull-right" role="navigation">
            <ul class="nav ace-nav">
                <li class="light-blue">
                    <a data-toggle="dropdown" class="dropdown-toggle cursor-default">
                        <span class="user-info">
                            <small><?php echo Yii::t('admin', 'Welcome,'); ?><?php echo HelpTemplate::logginRole(); ?></small><?php echo Yii::app()->user->getName(); ?>
                        </span>
                        <i class="icon-caret-down"></i>
                    </a>
                    <ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                        <li>
                            <a href="/admin/manager/profile"><i class="icon-user"></i><?php echo Yii::t('admin', 'Profile'); ?></a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="/admin/manager/logout"><i class="icon-off"></i><?php echo Yii::t('admin', 'Logout'); ?></a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
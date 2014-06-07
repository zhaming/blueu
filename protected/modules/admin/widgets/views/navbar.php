<!-- #section:basics/navbar.layout -->
<div id="navbar" class="navbar navbar-default">
    <div class="navbar-container" id="navbar-container">
        <!-- #section:basics/sidebar.mobile.toggle -->
        <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler">
            <span class="sr-only">Toggle sidebar</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <!-- /section:basics/sidebar.mobile.toggle -->
        <div class="navbar-header pull-left">
            <!-- #section:basics/navbar.layout.brand -->
            <a class="navbar-brand cursor-default">
                <small><i class="fa fa-leaf"></i>&nbsp;<?php echo Yii::t('admin', 'BlueU'); ?><?php echo Yii::t('admin', 'Background management system'); ?></small>
            </a>
            <!-- /section:basics/navbar.layout.brand -->
        </div>
        <!-- #section:basics/navbar.dropdown -->
        <div class="navbar-buttons navbar-header pull-right" role="navigation">
            <ul class="nav ace-nav">
                <!-- #section:basics/navbar.user_menu -->
                <li class="light-blue">
                    <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                        <span class="user-info">
                            <small><?php echo Yii::t('admin', 'Welcome,'); ?><?php echo HelpTemplate::loginRole(); ?></small><?php echo Yii::app()->user->getName(); ?>
                        </span>
                        <i class="ace-icon fa fa-caret-down"></i>
                    </a>
                    <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                        <li>
                            <a href="/admin/manager/profile"><i class="ace-icon fa fa-user"></i><?php echo Yii::t('admin', 'Profile'); ?></a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="/admin/manager/logout"><i class="ace-icon fa fa-power-off"></i><?php echo Yii::t('admin', 'Logout'); ?></a>
                        </li>
                    </ul>
                </li>
                <!-- /section:basics/navbar.user_menu -->
            </ul>
        </div>
        <!-- /section:basics/navbar.dropdown -->
    </div>
    <!-- /.navbar-container -->
</div>
<!-- /section:basics/navbar.layout -->


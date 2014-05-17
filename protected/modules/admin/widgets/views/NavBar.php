<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container-fluid">
      <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
      <a class="brand" href="#"> 网站管理后台</a>
      <div class="nav-collapse collapse pull-left">
        <ul class="nav breadcrumb" style="padding: 0px;">
          <li class="active">
            <a href="/admin"><?php echo $this->controller->pageName; ?></a>
          </li>
        </ul>
      </div>
      <div class="btn-group pull-right">
        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
          <i class="icon-user"></i> 
          <?php 
              //$user = UserBehavior::getCurrentUser();
			  $user = Yii::app()->user->getName();
              if(!empty($user))
                echo  $user;
              else
                echo "未登录";
            ?>
          <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
          <li><a href="/admin/manager/mypass"> 修改密码</a></li>
          <li class="divider"></li>
          <li><a href="/admin/manager/logout"> 退出登录</a></li>
        </ul>
      </div>
        </li>
      </ul>

    </div>
  </div>
</div>

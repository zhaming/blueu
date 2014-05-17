<!doctype html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?php //echo $this->pageTitle; ?></title>
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }
      .score{
		width:100px;
      }
    </style>
</head>
<body data-spy="scroll" data-target=".subnav" data-offset="50">
    <?php $this->widget('application.modules.admin.widgets.NavBarWidget'); ?>

    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span2">
          <?php $this->widget('application.modules.admin.widgets.NavListWidget'); ?>
        </div> 
        <div class="span10">
            <?php $this->widget('application.modules.admin.widgets.AlterMsgWidget'); ?>
            <?php echo $content; ?>
        </div> 
      </div> 
      <hr>

      <footer>
        <p>© 网信天成科技 2013</p>
      </footer>

    </div> 
</body>
<script>
    function showSuccess(msg)
    {
        alert(msg);
    }
    function showFail(msg)
    {
        alert(msg);
    }
    function showMessage(msg,type)
    {
        if(type)
            showSuccess(msg)
        else
            showFail(msg)
    }
    function showAfterMsg(that, msg, type)
    {
      if (type) {
          $(that).parent().parent().removeClass('error');
          $(that).next('.help-inline').remove();
      } else {
        $(that).parent().parent().addClass('error');
        if (!$(that).siblings().hasClass('help-inline')) {
          $(that).after('<span class="help-inline">' + msg + '</span>');
        }
      }
    }

    
</script>
 
</html>

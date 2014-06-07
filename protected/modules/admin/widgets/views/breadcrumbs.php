<!-- #section:basics/content.breadcrumbs -->
<div class="breadcrumbs" id="breadcrumbs">
    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="/admin"><?php echo Yii::t('admin', 'Home'); ?></a>
        </li>
        <?php if (!empty($secondLevelTitle)) { if (!empty($thirdLevelTitle)) { ?>
        <li>
            <a href="/admin/<?php echo Yii::app()->controller->id; ?>/index"><?php echo $secondLevelTitle; ?></a>
        </li>
        <?php } else { ?>
        <li class="active"><?php echo $secondLevelTitle; ?></li>
        <?php } } if (!empty($thirdLevelTitle)) { ?>
        <li class="active"><?php echo $thirdLevelTitle; ?></li>
        <?php } ?>
    </ul>
    <!-- /.breadcrumb -->
</div>
<!-- /section:basics/content.breadcrumbs -->
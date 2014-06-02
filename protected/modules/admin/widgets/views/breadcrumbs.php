<div class="breadcrumbs" id="breadcrumbs">
    <script type="text/javascript">
        try {
            ace.settings.check('breadcrumbs', 'fixed');
        } catch (e) {
            console.log(e);
        }
    </script>
    <ul class="breadcrumb">
        <li>
            <i class="icon-home home-icon"></i>
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
</div>
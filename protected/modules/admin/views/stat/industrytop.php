<div class="col-xs-12">
    <div class="space-6"></div>
    <div class="tabbable">
        <ul class="nav nav-tabs padding-16">
            <li>
                <a href="<?php echo $this->createUrl('industry?t=total'); ?>">
                    <i class="green ace-icon fa fa-anchor bigger-125"></i><?php echo Yii::t('admin', 'VStatIndustryTotal'); ?>
                </a>
            </li>
            <li class="active">
                <a href="<?php echo $this->createUrl('industry?t=top'); ?>">
                    <i class="green ace-icon fa fa-cog bigger-125"></i><?php echo Yii::t('admin', 'VStatIndustryTop'); ?>
                </a>
            </li>
            <li>
                <a href="<?php echo $this->createUrl('industry?t=stop'); ?>">
                    <i class="green ace-icon fa fa-comment bigger-125"></i><?php echo Yii::t('admin', 'VStatIndustrySTop'); ?>
                </a>
            </li>
        </ul>
        <div class="col-xs-12">
            <div class="col-sm-5 widget-box" style="margin:25px;">
                <div id="stattype" class="widget-header widget-header-flat" style="line-height:38px;">
                    <?php echo Yii::t('admin', 'VStatHotShop') . '(<b>TOP' . $topLimit . '</b>)'; ?>
                </div>
                <div class="widget-body">
                    <div id="hotshop" class="widget-main"></div>
                </div>
            </div>
            <div class="col-sm-5 widget-box" style="margin:25px;">
                <div id="stattype" class="widget-header widget-header-flat" style="line-height:38px;">
                    <?php echo Yii::t('admin', 'VStatHotIndustry') . '(<b>TOP' . $topLimit . '</b>)'; ?>
                </div>
                <div class="widget-body">
                    <div id="hotindustry" class="widget-main"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$().ready(function(){
    $('#hotshop').load('/admin/stat/industrytop?t=shop');
    $('#hotindustry').load('/admin/stat/industrytop?t=industry');
});
</script>
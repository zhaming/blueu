<div class="col-xs-12">
    <div class="space-6"></div>
    <div class="tabbable">
        <ul class="nav nav-tabs padding-16">
            <li class="active">
                <a href="<?php echo $this->createUrl('industry?t=total'); ?>">
                    <i class="green ace-icon fa fa-anchor bigger-125"></i><?php echo Yii::t('admin', 'VStatIndustryTotal'); ?>
                </a>
            </li>
            <li>
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
        <div class="tab-content no-border padding-24">
            <span id="datetype" style="margin-left:20px;">
                <?php echo Yii::t('admin', 'VStatDateType'); ?>：
                <a href="javascript:void(0)" datat="total:day" datatype="line">
                    <?php echo $limitMap['industry']['day'] . Yii::t('admin', 'day'); ?>
                </a> |
                <a href="javascript:void(0)" datat="total:week" datatype="line">
                    <?php echo $limitMap['industry']['week'] . Yii::t('admin', 'week'); ?>
                </a>
            </span><br>
            <div id="total" style="height:400px;width:800px;" legend="<?php echo $legend; ?>"></div>
        </div>
    </div>
</div>

<script type="text/javascript">
$().ready(function(){
    var legend = $('#total').attr('legend');
    var first = $('#datetype a:first');
    if(first == undefined) return;
    var datat = first.attr('datat');
    var datatype = first.attr('datatype');
    Chart.init('total', '/admin/stat/industrydata', {t:datat}, {
        legend: {data:legend.split(',')},
        toolbox: {show:false},
        series: {type:datatype}
    });
    $('#datetype a').each(function(){
        $(this).click(function(){
            datat = $(this).attr('datat');
            datatype = $(this).attr('datatype');
            Chart.init('total', '/admin/stat/industrydata', {t:datat}, {
                legend: {data:legend.split(',')},
                toolbox: {show:false},
                series: {type:datatype}
            });
        });
    });
});
</script>
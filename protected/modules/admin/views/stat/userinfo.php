<div class="col-xs-12">
    <div class="space-6"></div>
    <div class="tabbable">
        <ul class="nav nav-tabs padding-16">
            <li class="active">
                <a href="<?php echo $this->createUrl('user?t=info'); ?>">
                    <i class="green ace-icon fa fa-sun-o bigger-125"></i><?php echo Yii::t('admin', 'VStatUserInfo'); ?>
                </a>
            </li>
            <li>
                <a href="<?php echo $this->createUrl('user?t=convert'); ?>">
                    <i class="green ace-icon fa fa-edit bigger-125"></i><?php echo Yii::t('admin', 'VStatUserConvert'); ?>
                </a>
            </li>
            <li>
                <a href="<?php echo $this->createUrl('user?t=share'); ?>">
                    <i class="green ace-icon fa fa-share bigger-125"></i><?php echo Yii::t('admin', 'VStatUserShare'); ?>
                </a>
            </li>
        </ul>
        <div class="tab-content no-border padding-24">
            <span id="datetype" style="margin-left:20px;">
                <?php echo Yii::t('admin', 'VStatDateType'); ?>：
                <a href="javascript:void(0)" datat="registered:day" datatype="line">
                    <?php echo $limitMap['user']['day'] . Yii::t('admin', 'day'); ?>
                </a> |
                <a href="javascript:void(0)" datat="registered:week" datatype="line">
                    <?php echo $limitMap['user']['week'] . Yii::t('admin', 'week'); ?>
                </a> |
                <a href="javascript:void(0)" datat="registered:month" datatype="line">
                    <?php echo $limitMap['user']['month'] . Yii::t('admin', 'month'); ?>
                </a>
            </span><br>
            <div id="registered" style="height:300px;width:800px;"></div>
            <div id="sexandcentury" style="height:400px;width:400px;"></div>
        </div>
    </div>
</div>

<script type="text/javascript">
$().ready(function(){
    var first = $('#datetype a:first');
    if(first == undefined) return;
    var datat = first.attr('datat');
    var datatype = first.attr('datatype');
    Chart.init('registered', '/admin/stat/userdata', {t:datat}, {
        toolbox: {show:false},
        series: {type:datatype}
    });
    $('#datetype a').each(function(){
        $(this).click(function(){
            datat = $(this).attr('datat');
            datatype = $(this).attr('datatype');
            Chart.init('registered', '/admin/stat/userdata', {t:datat}, {
                toolbox: {show:false},
                series: {type:datatype}
            });
        });
    });
    
    Chart.init('sexandcentury', '/admin/stat/userdata', {t:'user:sex|century'}, {
        tooltip: {trigger:'item',formatter:'{a} <br/>{b} : {c} ({d}%)'},
        toolbox: {show:false},
        grid: {x:'left',y:'top'},
        series: {type:'pie',itemtyled:false,maxmin:false,average:false}
    });
});
</script>
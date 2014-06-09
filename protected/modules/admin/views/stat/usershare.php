<div class="col-xs-12">
    <div class="space-6"></div>
    <div class="tabbable">
        <ul class="nav nav-tabs padding-16">
            <li>
                <a href="<?php echo $this->createUrl('user?t=info'); ?>">
                    <i class="green ace-icon fa fa-sun-o bigger-125"></i><?php echo Yii::t('admin', 'VStatUserInfo'); ?>
                </a>
            </li>
            <li>
                <a href="<?php echo $this->createUrl('user?t=convert'); ?>">
                    <i class="green ace-icon fa fa-edit bigger-125"></i><?php echo Yii::t('admin', 'VStatUserConvert'); ?>
                </a>
            </li>
            <li class="active">
                <a href="<?php echo $this->createUrl('user?t=share'); ?>">
                    <i class="green ace-icon fa fa-share bigger-125"></i><?php echo Yii::t('admin', 'VStatUserShare'); ?>
                </a>
            </li>
        </ul>
        <div class="col-xs-12">
            <div class="col-sm-5 widget-box" style="margin-top:25px;">
                <div id="stattype" class="widget-header widget-header-flat" style="line-height:38px;">
                    <?php echo Yii::t('admin', 'VStatTop') . '(<b>TOP' . $topLimit . '</b>)'; ?>：
                    <a href="javascript:void(0)" source="1">
                        <?php echo Yii::t('admin', 'Shop'); ?>
                    </a> |
                    <a href="javascript:void(0)" source="2">
                        <?php echo Yii::t('admin', 'Product'); ?>
                    </a> |
                    <a href="javascript:void(0)" source="3">
                        <?php echo Yii::t('admin', 'Coupon'); ?>
                    </a> |
                    <a href="javascript:void(0)" source="4">
                        <?php echo Yii::t('admin', 'Stamp'); ?>
                    </a>
                </div>
                <div class="widget-body">
                    <div id="sharetop" class="widget-main"></div>
                </div>
            </div>
            <div id="share" class="col-sm-7" style="height:300px;"></div>
        </div>
    </div>
</div>

<script type="text/javascript">
$().ready(function(){
    var first = $('#stattype a:first');
    if(first == undefined) return;
    var source = first.attr('source');
    first.attr('style', 'color:#FFA830;');
    $('#sharetop').load('/admin/stat/usersharetop?source='+source);
    $('#stattype a').each(function(){
        $(this).click(function(){
            $('#stattype a').each(function(){
                $(this).attr('style', 'color:##428BCA;');
            });
            $(this).attr('style', 'color:#FFA830;');
            source = $(this).attr('source');
            $('#sharetop').load('/admin/stat/usersharetop?source='+source);
        });
    });
    
    Chart.init('share', '/admin/stat/userdata', {t:'share:'}, {
        toolbox:{show:false},
        series: {type:'line'}
    });
});
</script>
    <div class="col-xs-12">
        <div class="space-6"></div>
        <div class="tabbable">
            <ul class="nav nav-tabs padding-16">
                <li>
                    <a href="<?php echo $this->createUrl('user?t=info'); ?>">
                        <i class="green icon-sun bigger-125"></i><?php echo Yii::t('admin', 'VStatUserInfo'); ?>
                    </a>
                </li>
                <li class="active">
                    <a href="<?php echo $this->createUrl('user?t=convert'); ?>">
                        <i class="green icon-edit bigger-125"></i><?php echo Yii::t('admin', 'VStatUserConvert'); ?>
                    </a>
                </li>
                <li>
                    <a href="<?php echo $this->createUrl('user?t=share'); ?>">
                        <i class="green icon-edit bigger-125"></i><?php echo Yii::t('admin', 'VStatUserShare'); ?>
                    </a>
                </li>
            </ul>
            <div class="tab-content no-border padding-24">
                <div id="convert" class="tab-pane in active" style="height:300px;width:800px;"></div>
            </div>
        </div>
    </div>

<script type="text/javascript">
$().ready(function(){
    Chart.init('convert', '/admin/stat/userdata', {t:'convert:'}, {
        reversed: true,
        grid: {x:60,y:30,x2:30,y2:30},
        toolbox: {show:false},
        series: {type:'bar',itemtyled:false,maxmin:false,average:false}
    });
});
</script>
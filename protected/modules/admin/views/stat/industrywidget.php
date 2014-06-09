<ul class="list-unstyled">
    <?php if(empty($list)){ ?>
    <li class="center"><br><?php echo Yii::t('admin', 'VNoData'); ?><br><br></li>
    <?php }else{ ?>
    <?php foreach($list as $k => $value){ ?> 
    <li style="border-bottom:1px dotted #D5E4F1;">
        [<b style="margin:0 3px;"><?php echo $k+1;//$sourceName; ?></b>]&nbsp;
        <?php echo $value->name; ?>
        <b style="float:right;"><?php echo $value->hot; ?></b>
    </li>
    <?php }} ?>
</ul>
<?php //$this->widget('application.modules.admin.widgets.BCLinkPager', array('pages' => $pages)); ?>
<ul class="list-unstyled">
    <?php if(empty($list)){ ?>
    <li class="center"><br><?php echo Yii::t('admin', 'VNoData'); ?><br><br></li>
    <?php }else{ ?>
    <?php foreach($list as $k => $value){ ?> 
    <li style="border-bottom:1px dotted #D5E4F1;">
        <span style="margin:0 3px;" class="badge badge-danger"><?php echo $k+1; ?></span>&nbsp;
        <?php echo $value->name; ?>
        <b style="float:right;"><?php echo $value->hot; ?></b>
        <?php if(isset($value->shopname)){ ?>
        <i style="float:right;margin-right:30px;"><?php echo $value->shopname; ?></i>
        <?php } ?>
    </li>
    <?php }} ?>
</ul>
<?php //$this->widget('application.modules.admin.widgets.BCLinkPager', array('pages' => $pages)); ?>
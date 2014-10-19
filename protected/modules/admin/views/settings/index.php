<?php if (!empty($message)) { ?>
<div class="alert alert-block alert-danger">
    <button type="button" class="close" data-dismiss="alert">
        <i class="icon-remove"></i>
    </button>
    <i class="icon-warning-sign"></i>&nbsp;&nbsp;
    <?php echo $message; ?>	
</div>
<?php } ?>
<div class="row">
    <div class="col-xs-12">
        <div class="space-8"></div>
        <form action="<?php echo $this->createUrl('index'); ?>" method="POST" class="form-horizontal">
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-name"><?php echo Yii::t('admin', 'Name'); ?></label>
                <div class="col-sm-9">
                    <input type="text" name="name" value="" placeholder="<?php echo Yii::t('admin', 'Name'); ?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>
            <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">
                    <button class="btn btn-info" type="submit"><i class="icon-ok bigger-110"></i><?php echo Yii::t('admin', 'Save'); ?></button>
                    &nbsp; &nbsp; &nbsp;
                    <button class="btn" type="reset"><i class="icon-undo bigger-110"></i><?php echo Yii::t('admin', 'Reset'); ?></button>
                </div>
            </div>
        </form>
    </div>
</div>
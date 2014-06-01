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
        <form action="/admin/map/upload" method="POST" enctype="multipart/form-data" class="form-horizontal">
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-name"><?php echo Yii::t('admin', 'Name'); ?></label>
                <div class="col-sm-9">
                    <input id="form-field-name" type="text" name="map[name]" value="<?php echo $map['name'] ?>" placeholder="<?php echo Yii::t('admin', 'Name'); ?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>
            <div class="space-4"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-marketplace"><?php echo Yii::t('admin', 'Market place'); ?></label>
                <div class="col-sm-9">
                    <input id="form-field-marketplace" type="text" name="map[marketplace]" value="<?php echo $map['marketplace'] ?>" placeholder="<?php echo Yii::t('admin', 'Market place'); ?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>
            <div class="space-4"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-floor"><?php echo Yii::t('admin', 'Floor'); ?></label>
                <div class="col-sm-9">
                    <input id="form-field-floor" type="text" name="map[floor]" value="<?php echo $map['floor'] ?>" placeholder="<?php echo Yii::t('admin', 'Floor'); ?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>
            <div class="space-4"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="id-input-file-single-upload"><?php echo Yii::t('admin', 'Map'); ?></label>
                <div class="col-sm-9">
                    <input id="id-input-file-single-upload" type="file" name="file" />
                </div>
            </div>
            <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">
                    <button class="btn btn-info" type="submit"><i class="icon-ok bigger-110"></i><?php echo Yii::t('admin', 'Create'); ?></button>
                    &nbsp; &nbsp; &nbsp;
                    <button class="btn" type="reset"><i class="icon-undo bigger-110"></i><?php echo Yii::t('admin', 'Reset'); ?></button>
                </div>
            </div>
        </form>
    </div>
</div>
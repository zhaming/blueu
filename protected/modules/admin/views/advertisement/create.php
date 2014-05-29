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
        <form action="/admin/advertisement/create" method="POST" enctype="multipart/form-data" class="form-horizontal">
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-url"><?php echo Yii::t('admin', 'Url'); ?></label>
                <div class="col-sm-9">
                    <input id="form-field-url" type="text" name="advertisement[url]" value="<?php echo $advertisement['url'] ?>" placeholder="<?php echo Yii::t('admin', 'Url'); ?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>
            <div class="space-4"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-placetag"><?php echo Yii::t('admin', 'Place tag'); ?></label>
                <div class="col-sm-9">
                    <input id="form-field-placetag" type="text" name="advertisement[placetag]" value="<?php echo $advertisement['placetag'] ?>" placeholder="<?php echo Yii::t('admin', 'Place tag'); ?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>
            <div class="space-4"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="id-input-file-single-upload"><?php echo Yii::t('admin', 'Picture'); ?></label>
                <div class="col-sm-9">
                    <input id="id-input-file-single-upload" type="file" name="file" />
                </div>
            </div>
            <div class="space-4"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-desc"><?php echo Yii::t('admin', 'Description'); ?></label>
                <div class="input-group col-sm-9">
                    <textarea id="form-field-desc" name="advertisement[desc]" class="col-xs-10 col-sm-5"><?php echo $advertisement['desc'] ?></textarea>
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
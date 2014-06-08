<?php if (!empty($message)) { ?>
<div class="alert alert-block alert-danger">
    <button type="button" class="close" data-dismiss="alert">
        <i class="ace-icon glyphicon glyphicon-remove"></i>
    </button>
    <i class="ace-icon glyphicon glyphicon-warning-sign"></i>&nbsp;&nbsp;
    <?php echo $message; ?>	
</div>
<?php } ?>
<div class="row">
    <div class="col-xs-12">
        <div class="space-8"></div>
        <form method="POST" class="form-horizontal">
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-source"><?php echo Yii::t('admin', 'VSource'); ?></label>
                <div class="col-sm-9">
                    <?php echo CHtml::dropDownList('info[source]', isset($info['source'])?$info['source']:'', $sourceMap, 
                        array('class'=>'col-sm-5', 'id' => 'form-field-source')
                    );?>
                </div>
            </div>
            <div class="space-4"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-sid"><?php echo Yii::t('admin', 'VSID'); ?></label>
                <div class="col-sm-9">
                    <?php echo CHtml::textField('info[sid]', isset($info['sid'])?$info['sid']:'', 
                        array(
                            'class'=>'col-xs-10 col-sm-5',
                            'placeholder' => Yii::t('admin', 'VSID'),
                            'id' => 'form-field-sid'
                        )
                    );?>
                </div>
            </div>
            <div class="space-4"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-name"><?php echo Yii::t('admin', 'VSourceName'); ?></label>
                <div class="col-sm-9">
                    <?php echo CHtml::textField('info[name]', isset($info['name'])?$info['name']:'', 
                        array(
                            'class'=>'col-xs-10 col-sm-5',
                            'placeholder' => Yii::t('admin', 'VSourceName'),
                            'id' => 'form-field-name'
                        )
                    );?>
                </div>
            </div>
            <div class="space-4"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-shopid"><?php echo Yii::t('admin', 'Shop'); ?>ID</label>
                <div class="col-sm-9">
                    <?php echo CHtml::textField('info[shopid]', isset($info['shopid'])?$info['shopid']:'', 
                        array(
                            'class'=>'col-xs-10 col-sm-5',
                            'placeholder' => Yii::t('admin', 'Shop'),
                            'id' => 'form-field-shopid'
                        )
                    );?>
                </div>
            </div>
            <div class="space-4"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-msg"><?php echo Yii::t('admin', 'VTaskMsg'); ?></label>
                <div class="col-sm-9">
                    <?php echo CHtml::textArea('info[msg]', isset($info['msg'])?$info['msg']:'', 
                        array('cols'=>30, 'rows'=>3, 'id'=>'form-field-msg', 'style' => 'float:left')
                    ) . Yii::t('admin', 'VMsgDesc'); ?>
                </div>
            </div>
            <div class="space-4"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-limit"><?php echo Yii::t('admin', 'VPushLimit'); ?></label>
                <div class="col-sm-9">
                    <?php echo CHtml::textField('info[limit]', isset($info['limit'])?$info['limit']:'', 
                        array(
                            'class'=>'col-xs-10 col-sm-2',
                            'placeholder' => Yii::t('admin', 'VPushLimit'),
                            'id' => 'form-field-limit'
                        )
                    ) . Yii::t('admin', 'VPushLimitDesc'); ?>
                </div>
            </div>
            <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">
                    <button class="btn btn-info" type="submit"><i class="ace-icon glyphicon glyphicon-ok bigger-110"></i>
                        <?php echo isset($info['id'])?Yii::t('admin', 'Save'):Yii::t('admin', 'Create'); ?>
                    </button>&nbsp; &nbsp; &nbsp;
                    <button class="btn" type="reset"><i class="ace-icon fa fa-undo bigger-110"></i><?php echo Yii::t('admin', 'Reset'); ?></button>
                    <input type="hidden" name="info[id]" value="<?php echo empty($info['id'])?$info->id:0; ?>">
                </div>
            </div>
        </form>
    </div>
</div>
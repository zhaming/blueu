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
        <form method="POST" enctype="multipart/form-data" class="form-horizontal">
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-name"><?php echo Yii::t('admin', 'VTaskName'); ?></label>
                <div class="col-sm-9">
                    <?php echo CHtml::textField('info[name]', isset($info['name'])?$info['name']:'', 
                        array(
                            'class'=>'col-xs-10 col-sm-3',
                            'placeholder' => Yii::t('admin', 'VTaskName'),
                            'id' => 'form-field-name'
                        )
                    );?>&nbsp;&nbsp;
                    <label>
                        <input name="info[immediately]" value="0" type="radio"<?php if ($info['immediately']==0) { ?> checked="checked"<?php } ?> class="ace" />
                        <span class="lbl"><?php echo Yii::t('admin', 'VTaskKind0'); ?></span>
                    </label>
                    <label>
                        <input name="info[immediately]" value="1" type="radio"<?php if ($info['immediately']==1) { ?> checked="checked"<?php } ?> class="ace" />
                        <span class="lbl"><?php echo Yii::t('admin', 'VTaskKind1'); ?></span>
                    </label>
                </div>
            </div>
            <div class="space-4"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-type"><?php echo Yii::t('admin', 'VTaskType'); ?></label>
                <div class="col-sm-9">
                    <?php echo CHtml::dropDownList('info[type]', isset($info['type'])?$info['type']:'', array_keys($types), 
                        array('class'=>'col-sm-2', 'id' => 'form-field-type', 'kvEqual' => true)
                    );?>&nbsp;&nbsp;
                    <?php echo CHtml::dropDownList('info[item]', isset($info['item'])?$info['item']:'', $types[empty($info['type'])?'push':$info['type']], 
                        array('class'=>'col-sm-2', 'style'=>'margin-left:5px;', 'kvEqual' => true)
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
                <label class="col-sm-3 control-label no-padding-right" for="form-field-param"><?php echo Yii::t('admin', 'VTaskParam'); ?></label>
                <div class="col-sm-9">
                    <?php echo CHtml::textArea('info[sql]', isset($info['sql'])?$info['sql']:'', 
                        array('cols'=>30, 'rows'=>3, 'id'=>'form-field-param')
                    ) . Yii::t('admin', 'VTaskSqlDesc'); ?><br>
                    <?php echo CHtml::textField('info[ext]', isset($info['ext'])?$info['ext']:'', 
                        array('class'=>'col-xs-10 col-sm-5')
                    ) . Yii::t('admin', 'VTaskExtDesc'); ?>
                </div>
            </div>
            <div class="space-4"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-memo"><?php echo Yii::t('admin', 'VTaskMemo'); ?></label>
                <div class="col-sm-9">
                    <?php echo CHtml::textArea('info[memo]', isset($info['memo'])?$info['memo']:'', 
                        array('cols'=>30, 'rows'=>3, 'id'=>'form-field-memo')
                    );?>
                </div>
            </div>
            <div class="space-4"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-disabled"><?php echo Yii::t('admin', 'VTaskDisabled'); ?></label>
                <div class="col-sm-9">
                    <label>
                        <input name="info[disabled]" value="0" type="radio"<?php if ($info['disabled']==0) { ?> checked="checked"<?php } ?> class="ace" />
                        <span class="lbl"><?php echo Yii::t('admin', 'VDisabled0'); ?></span>
                    </label>
                    <label>
                        <input name="info[disabled]" value="1" type="radio"<?php if ($info['disabled']==1) { ?> checked="checked"<?php } ?> class="ace" />
                        <span class="lbl"><?php echo Yii::t('admin', 'VDisabled1'); ?></span>
                    </label>
                </div>
            </div>
            <div class="space-4"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-priority"><?php echo Yii::t('admin', 'VTaskPriority'); ?></label>
                <div class="col-sm-9">
                    <?php echo CHtml::textField('info[priority]', $info['priority'], 
                        array(
                            'class'=>'col-xs-10 col-sm-1',
                            'placeholder' => Yii::t('admin', 'VTaskPriority'),
                            'id' => 'form-field-priority'
                        )
                    ) . Yii::t('admin', 'VTaskPriorityDesc'); ?>
                </div>
            </div>
            <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">
                    <button class="btn btn-info" type="submit"><i class="icon-ok bigger-110"></i>
                        <?php echo isset($info['id'])?Yii::t('admin', 'Save'):Yii::t('admin', 'Create'); ?>
                    </button>&nbsp; &nbsp; &nbsp;
                    <button class="btn" type="reset"><i class="icon-undo bigger-110"></i><?php echo Yii::t('admin', 'Reset'); ?></button>
                    <input type="hidden" name="info[id]" value="<?php echo isset($info['id'])?$info['id']:0; ?>">
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
$().ready(function(){
    $('#form-field-type').change(function(){
        var selected = $(this).val();
        $.getJSON('/admin/task/items', {type: selected}, function(items){
            $('#info_item option').remove();
            for(var i in items){
                $('#info_item').append("<option value='"+items[i]+"'>"+items[i]+"</option>");
            }
        })
    });
});
</script>
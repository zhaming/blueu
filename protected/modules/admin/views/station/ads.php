<div class="page-header">
    <h1>
        <?php echo Yii::t('station', 'Station Manager');?>
        <small><i class="icon-double-angle-right"></i><?php echo Yii::t("station","Station ads edit")?></small>
    </h1>
</div>
<?php $this->widget("AlterMsgWidget")?>
<div class="row">
    <div class="col-xs-12">
        <form class="form-horizontal"  action="/admin/station/editads" method="POST" >

           <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-source"><?php echo Yii::t('admin', 'VSource'); ?></label>
                <div class="col-sm-9">
                    <?php echo CHtml::dropDownList('source', isset($source)?$source:'', $sourceMap, 
                        array('class'=>'col-sm-5', 'id' => 'form-field-source')
                    );?>
                </div>
            </div>
            <div class="space-4"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-sid"><?php echo Yii::t('admin', 'VSID'); ?></label>
                <div class="col-sm-9">
                    <?php echo CHtml::textField('sid', isset($sid)?$sid:'', 
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
                <label class="col-sm-3 control-label no-padding-right" for="form-field-shopid"><?php echo Yii::t('admin', 'Shop'); ?>ID</label>
                <div class="col-sm-9">
                    <?php echo CHtml::textField('shopid', isset($shopid)?$shopid:'', 
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
                <label class="col-sm-3 control-label no-padding-right" for="form-field-source"><?php echo Yii::t('station', 'Station Name'); ?></label>
                <div class="col-sm-9">
                    <select name='staionid'>
                    <?php if(!empty($stations)):?>
                    <?php foreach ($stations as $key => $value) :?>
                    <?php if(!empty($value->uuid) ):?>
                        <option value="<?php echo $value->id;?>"  <?php echo $value->id== $staionid?"selected":"";?>><?php echo $value->name;?></option>
                    <?php endif;?>
                    <?php endforeach;?>
                    <?php endif;?>
                    </select>
                </div>
            </div>
            <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">
                    <button class="btn btn-info" type="submit"><i class="ace-icon glyphicon glyphicon-ok bigger-110"></i><?php echo Yii::t("comment","Submit");?></button>
                    &emsp; &emsp; &emsp;
                    <button class="btn" type="reset"><i class="ace-icon fa fa-undo bigger-110"></i><?php echo Yii::t("comment","Reset");?></button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="page-header">
    <h1>
        <?php echo Yii::t('station', 'Station Manager');?>
        <small><i class="icon-double-angle-right"></i><?php echo Yii::t("station","Station Create")?></small>
    </h1>
</div>
<?php $this->widget("AlterMsgWidget")?>
<div class="row">
    <div class="col-xs-12">
        <form class="form-horizontal"  action="/admin/station/create" method="POST" >

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="station[uuid]"><?php echo Yii::t("station","Station UUID")?></label>
                <div class="col-sm-9">
                    <input type="text" name="station[uuid]" value="" placeholder="<?php echo Yii::t("station","Pelase input station uuid");?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>

             <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="station[name]"><?php echo Yii::t("station","Station Name");?></label>
                <div class="col-sm-9">
                    <input type="text" name="station[name]" value="" placeholder="<?php echo Yii::t("station","Pelase input station name")?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="station[positionX]"><?php echo Yii::t("station","positionX")?></label>
                <div class="col-sm-9">
                    <input type="text" name="station[positionX]" value="" placeholder="<?php echo Yii::t("station","Pelase input positionX");?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="station[positionY]"><?php echo Yii::t("station","positionY")?></label>
                <div class="col-sm-9">
                    <input type="text" name="station[positionY]" value="" placeholder="<?php echo Yii::t("station","Pelase input positionY");?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="station[shopid]"><?php echo Yii::t("station","Shop");?></label>
                <div class="col-sm-9">
                    <select name="station[shopid]" class="col-sm-5">
                    <?php if(!empty($shop)):?>
                        <?php foreach ($shop as $key => $value) :?>
                        <option value="<?php echo $value->id;?>"><?php echo $value->name;?></option>
                        <?php endforeach;?>
                    <?php endif;?>
                    </select>
                </div>
            </div>


            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="station[disabled]"><?php echo Yii::t('station',"Station Disabled")?></label>
                <div class="col-sm-9">
                        <input name="station[disabled]" value="1" class="ace ace-switch ace-switch-5" type="checkbox">
                        <span class="lbl"></span>
                </div>
            </div>

            <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">
                    <button class="btn btn-info" type="submit"><i class="icon-ok bigger-110"></i><?php echo Yii::t("comment","Create");?></button>
                    &emsp; &emsp; &emsp;
                    <button class="btn" type="reset"><i class="icon-undo bigger-110"></i><?php echo Yii::t("comment","Reset");?></button>
                </div>
            </div>
        </div>
    </div>
</div>

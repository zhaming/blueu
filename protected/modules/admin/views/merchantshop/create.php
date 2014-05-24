<div class="page-header">
    <h1>
        <?php echo Yii::t('shop', 'Shop Manager');?>
        <small><i class="icon-double-angle-right"></i><?php echo Yii::t("shop","Shop Create")?></small>
    </h1>
</div>
<?php $this->widget("AlterMsgWidget")?>
<div class="row">
    <div class="col-xs-12">
        <form class="form-horizontal"  action="/admin/merchantshop/create" method="POST" >

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="shop[name]"><?php echo Yii::t("shop","Shop Name")?></label>
                <div class="col-sm-9">
                    <input type="text" name="shop[name]" value="" placeholder="<?php echo Yii::t("shop","Pelase input shop name");?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>

             <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="shop[owner]"><?php echo Yii::t("shop","Shop Owner");?></label>
                <div class="col-sm-9">
                    <input type="text" name="shop[owner]" value="" placeholder="<?php echo Yii::t("shop","Pelase input shop owner")?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="shop[telephone]"><?php echo Yii::t("shop","Telephone")?></label>
                <div class="col-sm-9">
                    <input type="text" name="shop[telephone]" value="" placeholder="<?php echo Yii::t("shop","Pelase input telephone");?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="shop[address]"><?php echo Yii::t("shop","Shop Address");?></label>
                <div class="col-sm-9">
                    <input type="text" name="shop[address]" value="" placeholder="<?php echo Yii::t("shop","Pelase input shop address");?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="shop[url]"><?php echo Yii::t("shop","Shop URL");?></label>
                <div class="col-sm-9">
                    <input type="text" name="shop[url]" value="" placeholder="<?php echo Yii::t("shop","Pelase input shop url");?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="shop[catid]"><?php echo Yii::t("shop","Shop Category");?></label>
                <div class="col-sm-9">
                    <select name="shop[catid]" class="col-sm-5">
                    <?php if(!empty($category)):?>
                        <?php foreach ($category as $key => $value) :?>
                        <option value="<?php echo $value->id;?>"><?php echo $value->name;?></option>
                        <?php endforeach;?>
                    <?php endif;?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="shop[districtid]"><?php echo Yii::t("shop","Shop District");?></label>
                <div class="col-sm-9">
                    <select name="shop[districtid]" class="col-sm-5">
                    <?php if(!empty($district)):?>
                    <?php foreach ($district as $key => $value):?>
                        <option value="<?php echo $value->id?>"><?php echo $value->district?></option>
                    <?php endforeach;?>
                    <?php endif;?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="shop[marketplace]"><?php echo Yii::t("shop","Shop Market Place");?></label>
                <div class="col-sm-9">
                    <input type="text" name="shop[marketplace]" value="" placeholder="<?php echo Yii::t("shop","Pelase input shop market place");?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="shop[floor]"><?php echo Yii::t("shop","Shop Floor");?></label>
                <div class="col-sm-9">
                    <input type="text" name="shop[floor]" value="" placeholder="<?php echo Yii::t("shop","Pelase input shop floor")?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="shop[isonly]"></label>
                <div class="col-sm-9">
                    <label>
                       <?php echo Yii::t('shop',"Only")?>
                        <input name="shop[isonly]" value="1" class="ace ace-switch ace-switch-5" type="checkbox">
                        <span class="lbl"></span>
                    </label>
                    &emsp; &emsp; &emsp;
                    <label>
                        <?php echo Yii::t("shop","Main");?>
                        <input name="shop[ismain]"  value="1" class="ace ace-switch ace-switch-5" type="checkbox">
                        <span class="lbl"></span>
                    </label>
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
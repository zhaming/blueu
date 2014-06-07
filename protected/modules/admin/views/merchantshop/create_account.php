<div class="page-header">
    <h1>
        <?php echo Yii::t('shop', 'Shop Manager');?>
        <small><i class="icon-double-angle-right"></i><?php echo Yii::t("shop","Create account");?></small>
    </h1>
</div>
<?php $this->widget("AlterMsgWidget")?>
<div class="row">
    <div class="col-xs-12">
        <form class="form-horizontal"  action="/admin/merchantshop/AddShopAccount" method="POST" >

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for=""><?php echo Yii::t("shop","Shop Name");?></label>
                <div class="col-sm-9">
                    <input type="hidden"  name="shopid" value="<?php echo $shop->id;?>" />
                    <input type="text" disabled  name="shop_name" value="<?php echo $shop->name;?>"  class="col-xs-10 col-sm-5 disabled" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for=""><?php echo Yii::t("admin","Username");?></label>
                <div class="col-sm-9">
                    <input type="text" name="username" value=""  class="col-xs-10 col-sm-5" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for=""><?php echo Yii::t("admin","Password");?></label>
                <div class="col-sm-9">
                    <input type="password" name="passwd" value=""  class="col-xs-10 col-sm-5" />
                </div>
            </div>

            <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">
                    <button class="btn btn-info" type="submit"><i class="ace-icon glyphicon glyphicon-ok bigger-110"></i><?php echo Yii::t("commnet","Create");?></button>
                    &emsp; &emsp; &emsp;
                    <button class="btn" type="reset"><i class="ace-icon fa fa-undo bigger-110"></i><?php echo Yii::t("commnet","Reset");?></button>
                </div>
            </div>
        </div>
    </div>
</div>
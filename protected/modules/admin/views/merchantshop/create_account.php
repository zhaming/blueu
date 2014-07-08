<div class="space-6"></div>
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
        <form class="form-horizontal" action="/admin/merchantshop/AddShopAccount/id/<?php echo $id; ?>" method="POST">
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-username"><?php echo Yii::t("admin", "Username"); ?></label>
                <div class="col-sm-9">
                    <input id="form-field-username" type="text" name="merchant[username]" value="<?php echo $merchant['username']; ?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-password"><?php echo Yii::t("admin", "Password"); ?></label>
                <div class="col-sm-9">
                    <input id="form-field-password" type="password" name="merchant[password]" value="<?php echo $merchant['password']; ?>" class="col-xs-10 col-sm-5" />
                    <span style="color:red"><?php echo Yii::t("admin", "PasswordTitle"); ?></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-repassword"><?php echo Yii::t("admin", "Repeat password"); ?></label>
                <div class="col-sm-9">
                    <input id="form-field-repassword" type="password" name="merchant[repassword]" value="<?php echo $merchant['repassword']; ?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-name"><?php echo Yii::t("admin", "Name"); ?></label>
                <div class="col-sm-9">
                    <input id="form-field-name" type="text" name="merchant[name]" value="<?php echo $merchant['name']; ?>" class="col-xs-10 col-sm-5 disabled" />
                </div>
            </div>
            <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">
                    <button class="btn btn-info" type="submit"><i class="ace-icon glyphicon glyphicon-ok bigger-110"></i><?php echo Yii::t("admin", "Save"); ?></button>
                    &emsp; &emsp; &emsp;
                    <button class="btn" type="reset"><i class="ace-icon fa fa-undo bigger-110"></i><?php echo Yii::t("admin", "Reset"); ?></button>
                </div>
            </div>
        </div>
    </div>
</div>
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
        <form class="form-horizontal" action="/admin/merchantshop/create" method="POST" enctype="multipart/form-data">
            <?php if (HelpTemplate::isLoginAsAdmin()) { ?>
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-merchantid"><?php echo Yii::t("admin", "Account") ?></label>
                    <div class="col-sm-9">
                        <input id="form-field-merchantid" type="text" name="shop[merchantid]" value="<?php echo $shop['merchantid']; ?>" placeholder="<?php echo Yii::t("admin", "Pelase input associated with the account"); ?>" class="col-xs-10 col-sm-5" />
                    </div>
                </div>
            <?php } ?>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-name"><?php echo Yii::t("admin", "Name") ?></label>
                <div class="col-sm-9">
                    <input id="form-field-name" type="text" name="shop[name]" value="<?php echo $shop['name']; ?>" placeholder="<?php echo Yii::t("admin", "Pelase input shop name"); ?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-owner"><?php echo Yii::t("admin", "Shop owner"); ?></label>
                <div class="col-sm-9">
                    <input id="form-field-owner" type="text" name="shop[owner]" value="<?php echo $shop['owner']; ?>" placeholder="<?php echo Yii::t("admin", "Pelase input shop owner") ?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-intro"><?php echo Yii::t("admin", "Introduce"); ?></label>
                <div class="col-sm-9">
                    <textarea id="form-field-intro" name="shop[intro]" class="col-xs-10 col-sm-5"><?php echo $shop['intro']; ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-pic"><?php echo Yii::t("admin", "Picture"); ?></label>
                <div class="col-sm-4">
                    <input type="file" name="shop[pic]" id="upload-shop-pic" />
                    <script type="text/javascript">
                        $(document).ready(function() {
                            $('#upload-shop-pic').ace_file_input({
                                no_file: 'Choose',
                                btn_choose: 'Choose',
                                btn_change: 'Change',
                                droppable: false,
                                onchange: null,
                                thumbnail: true,
                                whitelist: 'gif|png|jpg|jpeg'
                            });
                        });
                    </script>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-telephone"><?php echo Yii::t("admin", "Telephone") ?></label>
                <div class="col-sm-9">
                    <input id="form-field-telephone" type="text" name="shop[telephone]" value="<?php echo $shop['telephone']; ?>" placeholder="<?php echo Yii::t("admin", "Pelase input telephone"); ?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-address"><?php echo Yii::t("admin", "Address"); ?></label>
                <div class="col-sm-9">
                    <input id="form-field-address" type="text" name="shop[address]" value="<?php echo $shop['address']; ?>" placeholder="<?php echo Yii::t("admin", "Pelase input address"); ?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-url"><?php echo Yii::t("admin", "Url"); ?></label>
                <div class="col-sm-9">
                    <input id="form-field-url" type="text" name="shop[url]" value="<?php echo $shop['url']; ?>" placeholder="<?php echo Yii::t("admin", "Pelase input url"); ?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="category_sec"><?php echo Yii::t("admin", "Industry"); ?></label>
                <div class="col-sm-9">
                    <select id="category" class="col-sm-2">
                        <?php if (!empty($category)): ?>
                            <?php foreach ($category as $key => $value) : ?>
                                <?php if ($value->parentid == 0): ?>
                                    <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                    &nbsp;&nbsp;
                    <select id="category_sec" name="shop[catid]" class="col-sm-2">
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="district_sec"><?php echo Yii::t("admin", "District"); ?></label>
                <div class="col-sm-9">
                    <select id="district" class="col-sm-2">
                        <?php if (!empty($district)): ?>
                            <?php foreach ($district as $key => $value): ?>
                                <?php if ($value->parentid == 0): ?>
                                    <option value="<?php echo $value->id ?>"><?php echo $value->district ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                    <select id="district_sec" name="shop[districtid]" class="col-sm-2"></select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-marketplace"><?php echo Yii::t("admin", "Marketplace"); ?></label>
                <div class="col-sm-9">
                    <input id="form-field-marketplace" type="text" name="shop[marketplace]" value="<?php echo $shop['marketplace']; ?>" placeholder="<?php echo Yii::t("admin", "Pelase input shop market place"); ?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-floor"><?php echo Yii::t("admin", "Floor"); ?></label>
                <div class="col-sm-9">
                    <input id="form-field-floor" type="text" name="shop[floor]" value="<?php echo $shop['floor']; ?>" placeholder="<?php echo Yii::t("admin", "Pelase input shop floor") ?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right"></label>
                <div class="col-sm-9">
                    <label>
                        <?php echo Yii::t('admin', "Shop only") ?>
                        <input name="shop[isonly]" value="1" class="ace ace-switch ace-switch-5" type="checkbox">
                        <span class="lbl"></span>
                    </label>
                    &emsp; &emsp; &emsp;
                    <label>
                        <?php echo Yii::t("admin", "Shop main"); ?>
                        <input name="shop[ismain]"  value="1" class="ace ace-switch ace-switch-5" type="checkbox">
                        <span class="lbl"></span>
                    </label>
                </div>
            </div>
            <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">
                    <button class="btn btn-info" type="submit"><i class="ace-icon glyphicon glyphicon-ok bigger-110"></i><?php echo Yii::t("admin", "Create"); ?></button>
                    &emsp; &emsp; &emsp;
                    <button class="btn" type="reset"><i class="ace-icon fa fa-undo bigger-110"></i><?php echo Yii::t("admin", "Reset"); ?></button>
                </div>
            </div>
    </div>
</div>
</div>
<script type="text/javascript" src="/statics/js/shop_select.js"></script>
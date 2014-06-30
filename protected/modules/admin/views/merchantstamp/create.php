<?php $this->widget("AlterMsgWidget") ?>
<div class="row">
    <div class="col-xs-12">
        <form class="form-horizontal" action="/admin/merchantstamp/create" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-name"><?php echo Yii::t("admin", "Name"); ?></label>
                <div class="col-sm-9">
                    <input id="form-field-name" type="text" name="stamp[name]" value="<?php echo $stamp['name']; ?>" placeholder="<?php echo Yii::t("Admin", "Pelase input name"); ?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-total"><?php echo Yii::t("admin", "Total"); ?></label>
                <div class="col-sm-9">
                    <input id="form-field-total" type="text" name="stamp[total]" value="<?php echo $stamp['total']; ?>" placeholder="<?php echo Yii::t("shop", "Pelase input total"); ?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-intro"><?php echo Yii::t("admin", "Intro"); ?></label>
                <div class="col-sm-9">
                    <textarea id="form-field-intro" name="stamp[intro]" class="col-xs-10 col-sm-5"><?php echo $stamp['intro']; ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-pic"><?php echo Yii::t("admin", "Picture"); ?></label>
                <div class="col-sm-4">
                    <input type="file" name="stamp[pic]" id="upload-coupon-pic" />
                    <script type="text/javascript">
                        $(document).ready(function() {
                            $('#upload-coupon-pic').ace_file_input({
                                no_file: '<?php echo Yii::t("comment", "Choose a picture"); ?>',
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
                <label class="col-sm-3 control-label no-padding-right"><?php echo Yii::t("admin", "Shop"); ?></label>
                <div class="col-sm-9">
                    <?php if (!empty($data)): ?>
                        <?php foreach ($data as $key => $value): ?>
                            <label>
                                <input name="shopid[]" value="<?php echo $value->id ?>" type="checkbox" class="ace">
                                <span class="lbl"><?php echo $value->name ?></span>
                            </label>
                            &emsp;
                            <?php echo $key != 0 && $key % 4 == 0 ? "</br>" : ""; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-validity_end"><?php echo Yii::t("admin", "Validity start"); ?></label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class=" col-sm-5">
                            <div class="input-group">
                                <input id="form-field-validity_start" name="stamp[validityStart]" type="text" class="form-control date-picker" data-date-format="yyyy-mm-dd" value="<?php echo $stamp['validityStart']; ?>" />
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar bigger-110"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="form-field-validity_end"><?php echo Yii::t("admin", "Validity end"); ?></label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class=" col-sm-5">
                            <div class="input-group">
                                <input id="form-field-validity_end" name="stamp[validityEnd]" class="form-control date-picker" type="text" data-date-format="yyyy-mm-dd" value="<?php echo $stamp['validityEnd']; ?>" />
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar bigger-110"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">
                    <button class="btn btn-info" type="submit"><i class="ace-icon glyphicon glyphicon-ok bigger-110"></i><?php echo Yii::t("admin", "Create") ?></button>
                    &nbsp; &nbsp; &nbsp;
                    <button class="btn" type="reset"><i class="ace-icon fa fa-undo bigger-110"></i><?php echo Yii::t("admin", "Reset"); ?></button>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('.date-picker').datepicker({
            autoclose: true
        });
        $('.date-picker').mask('9999-99-99');
    });
</script>
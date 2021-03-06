<?php $this->widget("AlterMsgWidget")?>
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
        <form class="form-horizontal"  action="/admin/merchantcoupon/create" method="POST"  enctype="multipart/form-data">

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="coupon[name]"><?php echo Yii::t("shop","Coupon Name");?></label>
                <div class="col-sm-9">
                    <input type="text" name="coupon[name]" value="<?php echo $coupon['name']; ?>" placeholder="<?php echo Yii::t("shop","Pelase input coupon name");?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="coupon[price]"><?php echo Yii::t("comment","Price");?></label>
                <div class="col-sm-9">
                <input type="text" name="coupon[price]" value="<?php echo $coupon['price']; ?>" placeholder="<?php echo Yii::t("shop","Pelase input coupon price");?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="coupon[intro]"><?php echo Yii::t("comment","Intro");?></label>
                <div class="col-sm-9">
                    <textarea name="coupon[intro]" class="col-xs-10 col-sm-5"><?php echo $coupon['intro']; ?></textarea>
                </div>
            </div>
             <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="coupon[total]"><?php echo Yii::t("comment","Total");?></label>
                <div class="col-sm-9">
                <input type="text" name="coupon[total]" value="<?php echo $coupon['total']; ?>" placeholder="<?php echo Yii::t("shop","Pelase input coupon total");?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="coupon[pic]"><?php echo Yii::t("comment","Picture");?></label>
                <div class="col-sm-4">
                        <input type="file" name="coupon[pic]" id="upload-coupon-pic" />
                        <script type="text/javascript">
                        $(document).ready(function(){
                             $('#upload-coupon-pic').ace_file_input({
                                no_file:'<?php echo Yii::t("comment","Choose a picture");?>',
                                btn_choose:'Choose',
                                btn_change:'Change',
                                droppable:false,
                                onchange:null,
                                thumbnail:true,
                                whitelist:'gif|png|jpg|jpeg'
                            });
                        });
                        </script>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right"><?php echo Yii::t("shop","Apply to shops");?></label>
                <div class="col-sm-9">
                    <?php if(!empty($data)):?>
                    <?php foreach ($data as $key => $value):?>
                        <label>
                            <input name="coupon[shopids][]" value="<?php echo $value->id?>" type="checkbox" class="ace"<?php if (!empty($coupon['shopid']) && in_array($value->id, $coupon['shopid'])) { ?> checked<?php } ?> />
                            <span class="lbl"><?php echo $value->name?></span>
                        </label>
                        &emsp;
                        <?php echo  $key!=0 && $key%4 == 0?"</br>":"";?>
                    <?php endforeach;?>
                    <?php endif;?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="coupon[validityStart]"><?php echo Yii::t("shop","Coupon validity start");?></label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class=" col-sm-5">
                            <div class="input-group">
                                <input name="coupon[validityStart]" type="text" class="form-control date-picker" data-date-format="yyyy-mm-dd" value="<?php echo $coupon['validityStart']; ?>" />
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar bigger-110"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

             <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="coupon[validityEnd]"><?php echo Yii::t("shop","Coupon validity end");?></label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class=" col-sm-5">
                            <div class="input-group">
                                <input name="coupon[validityEnd]" class="form-control date-picker" type="text" data-date-format="yyyy-mm-dd" value="<?php echo $coupon['validityEnd']; ?>" />
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
                    <button class="btn btn-info" type="submit"><i class="ace-icon glyphicon glyphicon-ok bigger-110"></i><?php echo Yii::t("comment","Create")?></button>
                    &nbsp; &nbsp; &nbsp;
                    <button class="btn" type="reset"><i class="ace-icon fa fa-undo bigger-110"></i><?php echo Yii::t("comment","Reset");?></button>
                </div>
            </div>
         </form>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    $('.date-picker').datepicker({
            autoclose:true
        });
    $('.date-picker').mask('9999-99-99');
});
</script>
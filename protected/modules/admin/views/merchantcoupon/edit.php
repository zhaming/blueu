<?php $this->widget("AlterMsgWidget")?>
<div class="row">
    <div class="col-xs-12">
        <form class="form-horizontal"  action="/admin/merchantcoupon/edit" method="POST"  enctype="multipart/form-data">
                <input type="hidden" name="coupon[id]" value="<?php echo $coupon->id;?>"/>
                <input type="hidden" name="coupon[codeid]" value="<?php echo $coupon->codeid;?>"/>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="coupon[name]"><?php echo Yii::t("shop","Coupon Name");?></label>
                <div class="col-sm-9">
                    <input type="text" name="coupon[name]" value="<?php echo $coupon->name;?>" placeholder="<?php echo Yii::t("shop","Pelase input coupon name");?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="coupon[price]"><?php echo Yii::t("comment","Price");?></label>
                <div class="col-sm-9">
                <input type="text" name="coupon[price]" value="<?php echo $coupon->price;?>" placeholder="<?php echo Yii::t("shop","Pelase input coupon price");?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>
             <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="coupon[total]"><?php echo Yii::t("comment","Total");?></label>
                <div class="col-sm-9">
                <input type="text" name="coupon[total]" value="<?php echo $coupon->coupon->total;?>" placeholder="<?php echo Yii::t("shop","Pelase input coupon total");?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>
            <?php if(!empty($coupon->pic)):?>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right"> </label>
                <div class="col-sm-9">
                    <img  class=" col-xs-10 col-sm-5  " src="<?php echo HelpTemplate::getAdUrl($coupon['pic']); ?>"/>
                </div>
            </div>
            <?php endif;?>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="coupon[pic]"><?php echo Yii::t("comment","Picture");?></label>
                <div class="col-sm-4">
                        <input type="file"   name="coupon[pic]" id="upload-coupon-pic" />
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
                     <?php echo empty($coupon->shop)?"":$coupon->shop->name;?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="coupon[validity_start]"><?php echo Yii::t("shop","Coupon validity start");?></label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class=" col-sm-5">
                            <div class="input-group">
                                <input name="coupon[validity_start]" type="text" value="<?php echo !empty($coupon->validity_start)?date("Y-m-d",$coupon->validity_start):"";?>"  class="form-control date-picker"　 data-date-format="yyyy-mm-dd" />
                                <span class="input-group-addon">
                                    <i class="icon-calendar bigger-110"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

             <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="coupon[validity_end]"><?php echo Yii::t("shop","Coupon validity end");?></label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class=" col-sm-5">
                            <div class="input-group">
                                <input name="coupon[validity_end]" value="<?php echo !empty($coupon->validity_end)?date("Y-m-d",$coupon->validity_end):"";?>"  class="form-control date-picker" type="text" data-date-format="yyyy-mm-dd" />
                                <span class="input-group-addon">
                                    <i class="icon-calendar bigger-110"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">
                    <button class="btn btn-info" type="submit"><i class="icon-ok bigger-110"></i><?php echo Yii::t("comment","Submit")?></button>
                    &emsp; &emsp; &emsp;
                    <button class="btn" type="reset"><i class="icon-undo bigger-110"></i><?php echo Yii::t("comment","Reset");?></button>
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
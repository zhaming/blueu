<div class="page-header">
    <h1>
        <?php echo Yii::t('shop', 'Stamp Manager');?>
        <small><i class="icon-double-angle-right"></i><?php echo Yii::t("shop","Stamp Create");?></small>
    </h1>
</div>
<?php $this->widget("AlterMsgWidget")?>
<div class="row">
    <div class="col-xs-12">
        <form class="form-horizontal"  action="/admin/merchantstamp/edit" method="POST"  enctype="multipart/form-data">
                <input type="hidden" name="stamp[id]" value="<?php echo $stamp->id;?>"/>
                <input type="hidden" name="stamp[codeid]" value="<?php echo $stamp->codeid;?>"/>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="stamp[name]"><?php echo Yii::t("shop","Stamp Name");?></label>
                <div class="col-sm-9">
                    <input type="text" name="stamp[name]" value="<?php echo $stamp->name;?>" placeholder="<?php echo Yii::t("shop","Pelase input stamp name");?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>

             <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="stamp[total]"><?php echo Yii::t("comment","Total");?></label>
                <div class="col-sm-9">
                <input type="text" name="stamp[total]" value="<?php echo $stamp->code->total;?>" placeholder="<?php echo Yii::t("shop","Pelase input stamp total");?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>
            <?php if(!empty($stamp->pic)):?>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right"> </label>
                <div class="col-sm-9">
                    <img  class=" col-xs-10 col-sm-5  " src="<?php echo HelpTemplate::getAdUrl($stamp['pic']); ?>"/>
                </div>
            </div>
            <?php endif;?>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="stamp[pic]"><?php echo Yii::t("comment","Picture");?></label>
                <div class="col-sm-9">
                        <input type="file"   name="stamp[pic]" id="upload-coupon-pic" />
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
                <label class="col-sm-3 control-label no-padding-right">适用商铺</label>
                <div class="col-sm-9">
                     <?php echo empty($stamp->shop)?"":$stamp->shop->name;?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="stamp[validity_start]"><?php echo Yii::t("shop","Coupon validity start");?></label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class=" col-sm-5">
                            <div class="input-group">
                                <input name="stamp[validity_start]" type="text" value="<?php echo !empty($stamp->validity_start)?date("Y-m-d",$stamp->validity_start):"";?>"  class="form-control date-picker"　 data-date-format="yyyy-mm-dd" />
                                <span class="input-group-addon">
                                    <i class="icon-calendar bigger-110"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

             <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="stamp[validity_end]"><?php echo Yii::t("shop","Coupon validity end");?></label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class=" col-sm-5">
                            <div class="input-group">
                                <input name="stamp[validity_end]" value="<?php echo !empty($stamp->validity_end)?date("Y-m-d",$stamp->validity_end):"";?>"  class="form-control date-picker" type="text" data-date-format="yyyy-mm-dd" />
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
                    <button class="btn btn-info" type="submit"><i class="ace-icon glyphicon glyphicon-ok bigger-110"></i><?php echo Yii::t("comment","Submit")?></button>
                    &emsp; &emsp; &emsp;
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
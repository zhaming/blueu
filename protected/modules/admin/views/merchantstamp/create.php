<div class="page-header">
    <h1>
        <?php echo Yii::t('shop', 'Stamp Manager');?>
        <small><i class="icon-double-angle-right"></i><?php echo Yii::t("shop","Stamp Create");?></small>
    </h1>
</div>
<?php $this->widget("AlterMsgWidget")?>
<div class="row">
    <div class="col-xs-12">
        <form class="form-horizontal"  action="/admin/merchantstamp/create" method="POST"  enctype="multipart/form-data">

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="stamp[name]"><?php echo Yii::t("shop","Stamp Name");?></label>
                <div class="col-sm-9">
                    <input type="text" name="stamp[name]" value="" placeholder="<?php echo Yii::t("shop","Pelase input stamp name");?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>

             <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="stamp[total]"><?php echo Yii::t("comment","Total");?></label>
                <div class="col-sm-9">
                <input type="text" name="stamp[total]" value="" placeholder="<?php echo Yii::t("shop","Pelase input stamp total");?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>

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
                    <?php if(!empty($data)):?>
                    <?php foreach ($data as $key => $value):?>
                        <label>
                            <input name="shopid[]" value="<?php echo $value->id?>" type="checkbox" class="ace">
                            <span class="lbl"><?php echo $value->name?></span>
                        </label>
                        &emsp;
                        <?php echo  $key!=0 && $key%4 == 0?"</br>":"";?>
                    <?php endforeach;?>
                    <?php endif;?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="stamp[validity_start]"><?php echo Yii::t("shop","Coupon validity start");?></label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class=" col-sm-5">
                            <div class="input-group">
                                <input name="stamp[validity_start]" type="text"  class="form-control date-picker"　 data-date-format="yyyy-mm-dd" />
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
                                <input name="stamp[validity_end]" class="form-control date-picker" type="text" data-date-format="yyyy-mm-dd" />
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
                    <button class="btn btn-info" type="submit"><i class="icon-ok bigger-110"></i><?php echo Yii::t("comment","Create")?></button>
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
<div class="page-header">
    <h1>
        <?php echo Yii::t("shop","Product Manager");?>
        <small><i class="icon-double-angle-right"></i><?php echo Yii::t("shop","Product Create");?></small>
    </h1>
</div>
<?php $this->widget("AlterMsgWidget")?>
<div class="row">
    <div class="col-xs-12">
        <form class="form-horizontal"  action="/admin/merchantproduct/create" method="POST"  enctype="multipart/form-data">

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="product[name]"><?php echo Yii::t("shop","Product name");?></label>
                <div class="col-sm-9">
                    <input type="text" name="product[name]" value="" placeholder="<?php echo Yii::t("shop","Pelease input product name");?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="product[intro]"><?php echo Yii::t("shop","Product intro");?></label>
                <div class="col-sm-9">
                <textarea name="product[intro]" placeholder="<?php echo Yii::t("shop","Pelease input product intro");?>" class=" col-xs-10 col-sm-5  " style="height:100px;"></textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="product[pic]"><?php echo Yii::t("comment","Picture");?></label>
                <div class="col-sm-4">
                        <input type="file"   name="product[pic]" id="upload-product-pic" />
                        <script type="text/javascript">
                        $(document).ready(function(){
                             $('#upload-product-pic').ace_file_input({
                                no_file:'Choose',
                                btn_choose:'Choose',
                                btn_change:'Change',
                                droppable:false,
                                onchange:null,
                                thumbnail:true, //| true | large
                                whitelist:'gif|png|jpg|jpeg'
                            });
                        });
                        </script>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="product[price]"><?php echo Yii::t("shop","Price");?></label>
                <div class="col-sm-9">
                    <input type="text" name="product[price]" value="" placeholder="<?php echo Yii::t("shop","Pelase input price");?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="product[discount]"><?php echo Yii::t("shop","discount");?></label>
                <div class="col-sm-9">
                    <input type="text" name="product[discount]" value="1" placeholder="<?php echo Yii::t("shop","Pelase input discount");?>" class="col-xs-10 col-sm-5" />
                </div>
            </div>


            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right"><?php echo Yii::t("shop","Apply to shops");?></label>
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

            <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">
                    <button class="btn btn-info" type="submit"><i class="ace-icon glyphicon glyphicon-ok bigger-110"></i><?php echo Yii::t("comment","Create");?></button>
                    &emsp; &emsp; &emsp;
                    <button class="btn" type="reset"><i class="ace-icon fa fa-undo bigger-110"></i><?php echo Yii::t("comment","Reset");?></button>
                </div>
            </div>
        </div>
    </div>
</div>
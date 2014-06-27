<?php $this->widget("AlterMsgWidget")?>
<div class="row">
    <div class="col-xs-12">
        <form class="form-horizontal"  action="/admin/merchantshop/create" method="POST" enctype="multipart/form-data">

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
                <label class="col-sm-3 control-label no-padding-right" for="shop[intro]"><?php echo Yii::t("comment","Intro");?></label>
                <div class="col-sm-9">
                    <textarea name="shop[intro]" class="col-xs-10 col-sm-5"></textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="shop[pic]"><?php echo Yii::t("comment","Picture");?></label>
                <div class="col-sm-4">
                    <input type="file" name="shop[pic]" id="upload-shop-pic" />
                    <script type="text/javascript">
                        $(document).ready(function(){
                            $('#upload-shop-pic').ace_file_input({
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
                    <select id="category"   class="col-sm-2">
                    <?php if(!empty($category)):?>
                        <?php foreach ($category as $key => $value) :?>
                        <?php if($value->parentid ==0):?>
                        <option value="<?php echo $value->id;?>"><?php echo $value->name;?></option>
                        <?php endif;?>
                        <?php endforeach;?>
                    <?php endif;?>
                    </select>
                    <select id="category_sec"name="shop[catid]" class="col-sm-2">
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="shop[districtid]"><?php echo Yii::t("shop","Shop District");?></label>
                <div class="col-sm-9">
                    <select id="district"  class="col-sm-2">
                    <?php if(!empty($district)):?>
                    <?php foreach ($district as $key => $value):?>
                    <?php if($value->parentid ==0):?>
                        <option value="<?php echo $value->id?>"><?php echo $value->district?></option>
                    <?php endif;?>
                    <?php endforeach;?>
                    <?php endif;?>
                    </select>

                    <select id="district_sec" name="shop[districtid]" class="col-sm-2">
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
                    <button class="btn btn-info" type="submit"><i class="ace-icon glyphicon glyphicon-ok bigger-110"></i><?php echo Yii::t("comment","Create");?></button>
                    &emsp; &emsp; &emsp;
                    <button class="btn" type="reset"><i class="ace-icon fa fa-undo bigger-110"></i><?php echo Yii::t("comment","Reset");?></button>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="/statics/js/shop_select.js"></script>
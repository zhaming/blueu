<div class="page-header">
    <h1>
        商品管理
        <small><i class="icon-double-angle-right"></i>添加商品</small>
    </h1>
</div>
<?php $this->widget("AlterMsgWidget")?>
<div class="row">
    <div class="col-xs-12">
        <form class="form-horizontal"  action="/admin/merchantproduct/create" method="POST"  enctype="multipart/form-data">

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="product[name]">商品名</label>
                <div class="col-sm-9">
                    <input type="text" name="product[name]" value="" placeholder="请输入商品名" class="col-xs-10 col-sm-5" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="product[intro]">简介</label>
                <div class="col-sm-9">
                <textarea name="product[intro]" placeholder="请输入简介" class=" col-xs-10 col-sm-5  " style="height:100px;"></textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="product[pic]">图片</label>
                <div class="col-sm-9">
                        <input type="file"   name="product[pic]" id="upload-product-pic" />
                        <script type="text/javascript">
                        $(document).ready(function(){
                             $('#upload-product-pic').ace_file_input({
                                no_file:'选择图片',
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
                <label class="col-sm-3 control-label no-padding-right" for="product[price]">价格</label>
                <div class="col-sm-9">
                    <input type="text" name="product[price]" value="" placeholder="请输入价格" class="col-xs-10 col-sm-5" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="product[discount]">折扣</label>
                <div class="col-sm-9">
                    <input type="text" name="product[discount]" value="1" placeholder="请输入折扣" class="col-xs-10 col-sm-5" />
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

            <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">
                    <button class="btn btn-info" type="submit"><i class="icon-ok bigger-110"></i>创建</button>
                    &emsp; &emsp; &emsp;
                    <button class="btn" type="reset"><i class="icon-undo bigger-110"></i>重置</button>
                </div>
            </div>
        </div>
    </div>
</div>
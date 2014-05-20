<div class="page-header">
    <h1>
        <?php echo Yii::t('admin', 'Merchant shop_manager');?>
        <small><i class="icon-double-angle-right"></i>商铺创建</small>
    </h1>
</div>
<?php $this->widget("AlterMsgWidget")?>
<div class="row">
    <div class="col-xs-12">
        <form class="form-horizontal"  action="/admin/merchantshop/create" method="POST" >

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="shop[name]">商铺名</label>
                <div class="col-sm-9">
                    <input type="text" name="shop[name]" value="" placeholder="请输入商铺名" class="col-xs-10 col-sm-5" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="shop[telephone]">联系电话</label>
                <div class="col-sm-9">
                    <input type="text" name="shop[telephone]" value="" placeholder="请输入联系电话" class="col-xs-10 col-sm-5" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="shop[address]">商铺地址</label>
                <div class="col-sm-9">
                    <input type="text" name="shop[address]" value="" placeholder="请输入商铺地址" class="col-xs-10 col-sm-5" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="shop[url]">商铺网址</label>
                <div class="col-sm-9">
                    <input type="text" name="shop[url]" value="" placeholder="请输入商铺网址" class="col-xs-10 col-sm-5" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="shop[catid]">行业</label>
                <div class="col-sm-9">
                    <select name="shop[catid]" class="col-sm-5">
                        <option value="1">vvv</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="shop[districtid]">商圈</label>
                <div class="col-sm-9">
                    <select name="shop[districtid]" class="col-sm-5">
                        <option value="1">笑嘻嘻</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="shop[marketplace]">所在商场</label>
                <div class="col-sm-9">
                    <input type="text" name="shop[marketplace]" value="" placeholder="请输入商铺所在商场" class="col-xs-10 col-sm-5" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="shop[floor]">楼层号</label>
                <div class="col-sm-9">
                    <input type="text" name="shop[floor]" value="" placeholder="请输入商铺楼层号" class="col-xs-10 col-sm-5" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="shop[floor]">楼层号</label>
                <div class="col-sm-9">
                    <input type="text" name="shop[floor]" value="" placeholder="请输入商铺楼层号" class="col-xs-10 col-sm-5" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="shop[isonly]"></label>
                <div class="col-sm-9">
                    <label>
                        独家
                        <input name="shop[isonly]" value="1" class="ace ace-switch ace-switch-5" type="checkbox">
                        <span class="lbl"></span>
                    </label>
                    &emsp; &emsp; &emsp;
                    <label>
                        总店
                        <input name="shop[ismain]" value="1" class="ace ace-switch ace-switch-5" type="checkbox">
                        <span class="lbl"></span>
                    </label>
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
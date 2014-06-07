<div class="page-header">
    <h1>
        <?php echo Yii::t('admin', 'Merchant shop_manager');?>
        <small><i class="icon-double-angle-right"></i>创建分店账号</small>
    </h1>
</div>
<?php $this->widget("AlterMsgWidget")?>
<div class="row">
    <div class="col-xs-12">
        <form class="form-horizontal"  action="/admin/merchantshop/AddShopAccount" method="POST" >

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="">店铺</label>
                <div class="col-sm-9">
                    <input type="hidden"  name="shopid" value="<?php echo $shop->id;?>" />
                    <input type="text" disabled  name="shop_name" value="<?php echo $shop->name;?>"  class="col-xs-10 col-sm-5 disabled" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="">用户名</label>
                <div class="col-sm-9">
                    <input type="text" name="username" value="" placeholder="请输入用户名" class="col-xs-10 col-sm-5" />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="">密码</label>
                <div class="col-sm-9">
                    <input type="password" name="passwd" value="" placeholder="请输入密码" class="col-xs-10 col-sm-5" />
                </div>
            </div>

            <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">
                    <button class="btn btn-info" type="submit"><i class="ace-icon glyphicon glyphicon-ok bigger-110"></i>创建</button>
                    &emsp; &emsp; &emsp;
                    <button class="btn" type="reset"><i class="ace-icon fa fa-undo bigger-110"></i>重置</button>
                </div>
            </div>
        </div>
    </div>
</div>
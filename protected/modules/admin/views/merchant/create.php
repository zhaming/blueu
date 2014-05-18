<div class="page-header">
    <h1>商户管理<small><i class="icon-double-angle-right"></i>创建</small></h1>
</div>
<?php if (!empty($message)) { ?>
<div class="alert alert-block alert-danger">
    <button type="button" class="close" data-dismiss="alert">
        <i class="icon-remove"></i>
    </button>
    <i class="icon-warning-sign"></i>&nbsp;&nbsp;<?php echo $message; ?>	
</div>
<?php } ?>
<div class="row">
    <div class="col-xs-12">
        <form class="form-horizontal" role="form" action="/admin/merchant/create" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="merchant[username]">用户名</label>
                <div class="col-sm-9">
                    <input type="text" name="merchant[username]" value="<?php echo $merchant['username'] ?>" placeholder="请输入用户名" class="col-xs-10 col-sm-5" />
                    <span class="help-inline col-xs-12 col-sm-7">
                        <span class="middle">建议输入邮箱</span>
                    </span>
                </div>
            </div>
            <div class="space-4"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="merchant[password]">密码</label>
                <div class="col-sm-9">
                    <input type="password" name="merchant[password]" value="<?php echo $merchant['password'] ?>" placeholder="请输入密码" class="col-xs-10 col-sm-5" />
                </div>
            </div>
            <div class="space-4"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="merchant[repassword]">确认密码</label>
                <div class="col-sm-9">
                    <input type="password" name="merchant[repassword]" value="<?php echo $merchant['repassword'] ?>" placeholder="再次输入密码" class="col-xs-10 col-sm-5" />
                </div>
            </div>
            <div class="space-4"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="merchant[name]">名称</label>
                <div class="col-sm-9">
                    <input type="text" name="merchant[name]" value="<?php echo $merchant['name'] ?>" placeholder="请输入名称" class="col-xs-10 col-sm-5" />
                </div>
            </div>
            <div class="space-4"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="merchant[logo]">Logo</label>
                <div class="col-sm-9">
                    <input type="file" id="id-input-file-upload-logo" />
                </div>
            </div>
            <div class="space-4"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="merchant[category]">年代</label>
                <div class="col-sm-9">
                    <select name="merchant[category]" class="col-sm-5">
                        <?php foreach ($categories as $value) { ?>
                        <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="space-4"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="merchant[description]">描述</label>
                <div class="col-sm-9">
                    <textarea name="merchant[description]" class="col-xs-10 col-sm-5" placeholder="请输入描述"></textarea>
                </div>
            </div>
            <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">
                    <button class="btn btn-info" type="submit"><i class="icon-ok bigger-110"></i>创建</button>
                    &nbsp; &nbsp; &nbsp;
                    <button class="btn" type="reset"><i class="icon-undo bigger-110"></i>重置</button>
                </div>
            </div>
        </div>
    </div>
</div>
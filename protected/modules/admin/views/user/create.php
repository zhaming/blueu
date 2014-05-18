<div class="page-header">
    <h1>用户管理<small><i class="icon-double-angle-right"></i>创建</small></h1>
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
        <form class="form-horizontal" role="form" action="/admin/user/create" method="POST">
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="user[username]">用户名</label>
                <div class="col-sm-9">
                    <input type="text" name="user[username]" value="<?php echo $user['username'] ?>" placeholder="用户名" class="col-xs-10 col-sm-5" />
                    <span class="help-inline col-xs-12 col-sm-7">
                        <span class="middle">建议输入邮箱</span>
                    </span>
                </div>
            </div>
            <div class="space-4"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="user[password]">密码</label>
                <div class="col-sm-9">
                    <input type="password" name="user[password]" value="<?php echo $user['password'] ?>" placeholder="密码" class="col-xs-10 col-sm-5" />
                </div>
            </div>
            <div class="space-4"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="user[repassword]">确认密码</label>
                <div class="col-sm-9">
                    <input type="password" name="user[repassword]" value="<?php echo $user['repassword'] ?>" placeholder="确认密码" class="col-xs-10 col-sm-5" />
                </div>
            </div>
            <div class="space-4"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="user[name]">昵称</label>
                <div class="col-sm-9">
                    <input type="text" name="user[name]" value="<?php echo $user['name'] ?>" placeholder="昵称" class="col-xs-10 col-sm-5" />
                </div>
            </div>
            <div class="space-4"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="user[sex]">性别</label>
                <div class="col-sm-9">
                    <label>
                        <input name="user[sex]" value="0" type="radio"<?php if ($user['sex']==0) { ?> checked="checked"<?php } ?> class="ace" />
                        <span class="lbl">保密</span>
                    </label>&nbsp;&nbsp;&nbsp;&nbsp;
                    <label>
                        <input name="user[sex]" value="1" type="radio"<?php if ($user['sex']==1) { ?> checked="checked"<?php } ?> class="ace" />
                        <span class="lbl">女</span>
                    </label>&nbsp;&nbsp;&nbsp;&nbsp;
                    <label>
                        <input name="user[sex]" value="2" type="radio"<?php if ($user['sex']==2) { ?> checked="checked"<?php } ?> class="ace" />
                        <span class="lbl">男</span>
                    </label>
                </div>
            </div>
            <div class="space-4"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="user[mobile]">电话</label>
                <div class="input-group col-sm-9">
                    <!--<span class="input-group-addon">
                        <i class="icon-phone"></i>
                    </span>-->
                    <input name="user[mobile]" class="col-xs-10 col-sm-5" type="text" id="form-field-mask-2" />
                </div>
            </div>
            <div class="space-4"></div>
            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right" for="user[century]">年代</label>
                <div class="col-sm-9">
                    <select name="user[century]" class="col-sm-5">
                        <option value="">00</option>
                        <option value="AL">90</option>
                        <option value="AK">80</option>
                        <option value="AK">70</option>
                        <option value="AK">其他</option>
                    </select>
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
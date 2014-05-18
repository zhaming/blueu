<form class="form-horizontal well" action="/admin/manager/mypass" method="POST">
    <fieldset>
        <legend>修改密码</legend>
        <div class="control-group error">
            <label class="control-label" for="input01">密码</label>
            <div class="controls">
                <input type="password" class="input-xlarge" id="input01" name="oldpwd" />
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="input01">新密码</label>
            <div class="controls">
                <input type="password" class="input-xlarge" id="input01" name="newpwd" />
                <p class="help-block">至少6个字符</p>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="input01">确认密码</label>
            <div class="controls">
                <input type="password" class="input-xlarge" id="input01" name="repwd" />
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">修改</button>
        </div>
    </fieldset>
</form>
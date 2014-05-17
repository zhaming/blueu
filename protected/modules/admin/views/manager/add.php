<?php $this->widget('application.modules.admin.widgets.NavTabWidget',array('index'=>'manager'))?>
<div class="tab-content">
    <div class="tab-pane active">
        <form name='goods' class="form-horizontal well" enctype="multipart/form-data" action="" method='post'>
            <fieldset>
                <div class="control-group">
                    <label class="control-label">用户名:</label>
                    <div class="controls">
                        <input type="text" name='manager[name]' class="span3">
                        <p class="help-block">默认密码：123456</p>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">电话:</label>
                    <div class="controls">
                        <input type="text" name='manager[mobile]' class="span3">
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="input02">角色:</label>
                    <div class="controls">
                        <?php $first = true; ?>
                        <?php foreach ($roles as $role):?>
                            <label class='checkbox inline span3'>
                                <input type='radio' name='manager[role_id]'
                                value='<?php echo $role['role_id'] ?>'
                                <?php if($first) { echo 'checked'; $first = false; }?> />
                                <?php echo $role['role_name']?>
                             </label>
                        <?php endforeach;?>
                    </div>
                </div>
                <div class="form-actions">
                    <button class="btn btn-primary" type="submit">新增</button>
                </div>
            </fieldset>
        </form>
    </div>
</div>


<?php $this->widget('application.modules.admin.widgets.NavTabWidget',array('index'=>'manager'))?>
<div class="tab-content">
    <div class="tab-pane active">
        <form name='goods' class="form-horizontal well" enctype="multipart/form-data" action="" method='post'>
            <input type="hidden" value="<?php echo $manager['id']; ?>" name="manager[id]" />
            <fieldset>
                <div class="control-group">
                    <label class="control-label">用户名:</label>
                    <div class="controls">
                        <input type="text" value="<?php echo $manager['name']; ?>" readonly="readonly" class="span3">
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="input02">角色:</label>
                    <div class="controls">
                        <?php foreach ($roles as $role):?>
                            <label class='checkbox inline span3'>
                                <input type='radio' name='manager[role_id]'
                                value='<?php echo $role['role_id'] ?>'
                                <?php if($manager['role_id'] == $role['role_id']) { echo 'checked'; }?> />
                                <?php echo $role['role_name']?>
                             </label>
                        <?php endforeach;?>
                    </div>
                </div>
                <div class="form-actions">
                    <button class="btn btn-primary" type="submit">更新</button>
                </div>
            </fieldset>
        </form>
    </div>
</div>


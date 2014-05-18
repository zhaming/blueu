<div class="tab-content">
    <div class="tab-pane active">
        <form name='goods' class="form-horizontal well" enctype="multipart/form-data" action="" method='post'>
            <fieldset>
                <div class="control-group">
                    <label class="control-label">编号:</label>
                    <div class="controls">
                        <input type="text" name='id' readonly class="span3" value="<?php echo $id; ?>">
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">名称:</label>
                    <div class="controls">
                        <input type="text" name='name' class="span3" value="<?php echo $name; ?>">
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">描述信息:</label>
                    <div class="controls">
                        <input type="text" name='describ' class="span3" value="<?php echo $describ; ?>">
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">基站信息:</label>
                    <div class="controls">
                    <select name='blueid' class="span3">
                        <?php foreach ($rc_station as $station): ?>
                            <option <?php if ($station->id == $blueid) echo 'selected'; ?> value="<?php echo $station->id; ?>"><?php echo $station->name.'('.$station->id.')'; ?></option>
                        <?php endforeach; ?>
                    </select>
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">图片信息:</label>
                    <img src=<?php echo FilesComponent::getImageUrl($pic); ?>></img>
                    <div class="controls">
                        <input type="file" name='pic' class="span3" value="<?php echo $pic; ?>">
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="form-actions">
                    <button class="btn btn-primary" type="submit">修改</button>
                </div>
            </fieldset>
        </form>
    </div>
</div>


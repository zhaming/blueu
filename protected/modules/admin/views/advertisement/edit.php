<div class="row">
    <div class="col-xs-12">
        <div class="space-6"></div>
        <form action="<?php echo $this->createUrl('edit'); ?>" method="post" class="form-horizontal">
            <div class="tabbable">
                <ul class="nav nav-tabs padding-16">
                    <li>
                        <a href="<?php echo $this->createUrl('detail?id=' . $ad['id']); ?>">
                            <i class="green icon-user bigger-125"></i>
                            <?php echo Yii::t('admin', 'Overview'); ?>
                        </a>
                    </li>
                    <li class="active">
                        <a href="<?php echo $this->createUrl('edit?id=' . $ad['id']); ?>">
                            <i class="green icon-edit bigger-125"></i>
                            <?php echo Yii::t('admin', 'Edit information'); ?>
                        </a>
                    </li>
                </ul>
                <div class="tab-content no-border padding-24">
                    <div id="edit-basic" class="tab-pane in active">
                        <?php if (!empty($message)) { ?>
                        <div class="alert alert-block alert-danger">
                            <p><strong><?php echo $message; ?></strong></p>
                        </div>
                        <?php } ?>
                        <input type="hidden" name="ad[id]" value="<?php echo $ad['id']; ?>" />
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-desc"><?php echo Yii::t('admin', 'Description'); ?></label>
                            <div class="col-sm-9">
                                <span class="input-icon input-icon-right">
                                    <input id="form-field-desc" name="ad[desc]" value="<?php echo $ad['desc']; ?>" type="text" placeholder="<?php echo Yii::t('admin', 'Description'); ?>" />
                                    <i class="icon-credit-card"></i>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-url"><?php echo Yii::t('admin', 'Url'); ?></label>
                            <div class="col-sm-9">
                                <span class="input-icon input-icon-right">
                                    <input id="form-field-url" name="ad[url]" value="<?php echo $ad['url']; ?>" type="text" placeholder="<?php echo Yii::t('admin', 'Url'); ?>" />
                                    <i class="icon-external-link"></i>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-placetag"><?php echo Yii::t('admin', 'Place tag'); ?></label>
                            <div class="col-sm-9">
                                <select id="form-field-placetag" name="ad[placetag]" class="col-sm-3 no-padding-left">
                                    <?php foreach (HelpTemplate::getAdPlaceTags() as $key => $value) { ?>
                                    <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-disabled"><?php echo Yii::t('admin', 'Disabled'); ?></label>
                            <div class="col-sm-9">
                                <label class="control-label">
                                    <input id="form-field-disabled" name="ad[disabled]" value="1" class="ace ace-switch ace-switch-2" type="checkbox"<?php if ($ad['disabled']) { ?> checked<?php } ?> />
                                    <span class="lbl"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">
                    <button class="btn btn-info" type="submit">
                        <i class="icon-ok bigger-110"></i>
                        <?php echo Yii::t('admin', 'Save'); ?>
                    </button>
                    &nbsp; &nbsp;
                    <button class="btn" type="reset">
                        <i class="icon-undo bigger-110"></i>
                        <?php echo Yii::t('admin', 'Reset'); ?>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
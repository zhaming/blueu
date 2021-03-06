<div class="row">
    <div class="col-xs-12">
        <p>
            <a href="/admin/manager/create" class="btn btn-app btn-success btn-xs">
                <i class="ace-icon glyphicon glyphicon-plus bigger-120"></i>
                <?php echo Yii::t('admin', 'Create'); ?>
            </a>
            <button class="btn btn-app btn-danger btn-xs batch-delete-confirm">
                <i class="ace-icon glyphicon glyphicon-remove bigger-120"></i>
                <?php echo Yii::t('admin', 'Delete'); ?>
            </button>
        </p>
        <?php $this->widget('application.modules.admin.widgets.AlterMsgWidget'); ?>
        <div class="table-responsive">
            <form action="/admin/manager/delete" method="POST" class="batch-delete-form">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="center">
                                <label>
                                    <input type="checkbox" class="ace" />
                                    <span class="lbl"></span>
                                </label>
                            </th>
                            <th><?php echo Yii::t('admin', 'Id'); ?></th>
                            <th><?php echo Yii::t('admin', 'Username'); ?></th>
                            <th><?php echo Yii::t('admin', 'Status'); ?></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($data)) { foreach ($data as $item) { if ($item->id == 1) { continue; } ?>
                        <tr>
                            <td class="center">
                                <label>
                                    <input type="checkbox" name="id[]" value="<?php echo $item->id; ?>" class="ace" />
                                    <span class="lbl"></span>
                                </label>
                            </td>
                            <td><?php echo $item->id; ?></td>
                            <td><?php echo $item->username; ?></td>
                            <td>
                                <?php echo Yii::t('admin', 'Account'); ?>:
                                <?php if ($item->status == HelpTemplate::USER_STATUS_NORMAL) { echo Yii::t('admin', 'Enable'); } if ($item->status == HelpTemplate::USER_STATUS_DISABLED) { echo Yii::t('admin', 'Disable'); } ?>
                            </td>
                            <td>
                                <div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
                                    <?php if ($item->status == HelpTemplate::USER_STATUS_DISABLED) { ?>
                                    <a href="<?php echo $this->createUrl('enable?id=' . $item->id); ?>" title="<?php echo Yii::t('admin', 'Enable'); ?>" class="green">
                                        <i class="ace-icon fa fa-unlock bigger-130"></i>
                                    </a>
                                    <?php } else { ?>
                                    <a href="<?php echo $this->createUrl('disable?id=' . $item->id); ?>" title="<?php echo Yii::t('admin', 'Disable'); ?>" class="yellow">
                                        <i class="ace-icon fa fa-lock bigger-130"></i>
                                    </a>
                                    <?php } ?>
                                    <a href="<?php echo $this->createUrl('resetpwd?id=' . $item->id); ?>" title="<?php echo Yii::t('admin', 'Reset password'); ?>" class="green">
                                        <i class="ace-icon fa fa-key bigger-130"></i>
                                    </a>
                                    <a href="<?php echo $this->createUrl('delete?id=' . $item->id); ?>" title="<?php echo Yii::t('admin', 'Delete'); ?>" class="red delete-confirm">
                                        <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php }} ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>

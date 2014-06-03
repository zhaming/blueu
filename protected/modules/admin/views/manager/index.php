<div class="row">
    <div class="col-xs-12">
        <p>
            <a href="/admin/manager/create" class="btn btn-app btn-success btn-xs">
                <i class="icon-plus bigger-120"></i>
                <?php echo Yii::t('admin', 'Create'); ?>
            </a>
            <button class="btn btn-app btn-danger btn-xs batch-delete-confirm">
                <i class="icon-remove bigger-120"></i>
                <?php echo Yii::t('admin', 'Delete'); ?>
            </button>
        </p>
        <?php $message = Yii::app()->user->getFlash('messagetip'); if ($message != null) { ?>
        <div class="alert alert-block<?php if ($message['type'] == 'success') { ?> alert-success<?php } ?><?php if ($message['type'] == 'error') { ?> alert-danger<?php } ?>">
            <p><strong><?php echo $message['msg']; ?></strong></p>
        </div>
        <?php } ?>
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
                                <?php if ($item->status == HelpTemplate::USER_STATUS_DISABLED) { ?>
                                <a href="<?php echo $this->createUrl('enable?id=' . $item->id); ?>" title="<?php echo Yii::t('admin', 'Enable'); ?>" class="btn btn-xs btn-success">
                                    <i class="icon-unlock bigger-120"></i>
                                </a>
                                <?php } else { ?>
                                <a href="<?php echo $this->createUrl('disable?id=' . $item->id); ?>" title="<?php echo Yii::t('admin', 'Disable'); ?>" class="btn btn-xs btn-warning">
                                    <i class="icon-lock bigger-120"></i>
                                </a>
                                <?php } ?>
                                <a href="<?php echo $this->createUrl('resetpwd?id=' . $item->id); ?>" title="<?php echo Yii::t('admin', 'Reset password'); ?>" class="btn btn-xs btn-success">
                                    <i class="icon-key bigger-120"></i>
                                </a>
                                <a href="<?php echo $this->createUrl('delete?id=' . $item->id); ?>" title="<?php echo Yii::t('admin', 'Delete'); ?>" class="btn btn-xs btn-danger delete-confirm">
                                    <i class="icon-trash bigger-120"></i>
                                </a>
                            </td>
                        </tr>
                        <?php }} ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>

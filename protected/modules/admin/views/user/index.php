<div class="row">
    <div class="col-xs-12">
        <p>
            <a href="/admin/user/create" class="btn btn-app btn-success btn-xs">
                <i class="icon-plus bigger-120"></i>
                <?php echo Yii::t('admin', 'Create'); ?>
            </a>
            <button class="btn btn-app btn-danger btn-xs batch-delete-confirm">
                <i class="icon-remove bigger-120"></i>
                <?php echo Yii::t('admin', 'Delete'); ?>
            </button>
        </p>
        <?php $message = Yii::app()->user->getFlash('messagetip'); if ($message != null) { ?>
        <div class="alert alert-block<?php if ($message['type'] == 'success') { ?> alert-success<?php } ?><?php if ($message['type'] == 'error') { ?> alert-denger<?php } ?>">
            <p>
                <strong>
                    <i class="<?php if ($message['type'] == 'success') { ?>icon-ok<?php } ?><?php if ($message['type'] == 'error') { ?>icon-remove<?php } ?>"></i>
                    <?php echo $message['msg']; ?>
                </strong>
            </p>
        </div>
        <?php } ?>
        <form action="/admin/user/index" method="get" class="well form-inline">
            <label class="inline">
                <input type="text" name="username" value="<?php if(!empty($_GET['username'])) { echo $_GET['username']; } ?>" placeholder="<?php echo Yii::t('admin', 'Username'); ?>" /> 
            </label>
            <label class="inline">
                <input type="text" name="name" value="<?php if(!empty($_GET['name'])) { echo $_GET['name']; } ?>" placeholder="<?php echo Yii::t('admin', 'Name'); ?>" /> 
            </label>
            <label class="inline" >
                <button type="submit" class="btn btn-xs btn-info">
                    <i class="icon-search"></i><?php echo Yii::t('admin', 'Search'); ?>
                </button>
            </label>
        </form>
        <div class="table-responsive">
            <form action="/admin/user/delete" method="POST" class="batch-delete-form">
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
                            <th><?php echo Yii::t('admin', 'Name'); ?></th>
                            <th><?php echo Yii::t('admin', 'Status'); ?></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($data)) { ?>
                        <?php foreach ($data as $item) { ?>
                        <tr>
                            <td class="center">
                                <label>
                                    <input type="checkbox" name="id[]" value="<?php echo $item['id']; ?>" class="ace" />
                                    <span class="lbl"></span>
                                </label>
                            </td>
                            <td><?php echo $item['id']; ?></td>
                            <td><?php echo $item->account->username; ?></td>
                            <td><?php echo $item->name; ?></td>
                            <td>
                                <?php echo Yii::t('admin', 'Account'); ?>:
                                <?php if ($item->account->status == HelpTemplate::USER_STATUS_NORMAL) { ?><font class="green"><?php echo Yii::t('admin', 'Enable'); ?></font><?php } if ($item->account->status == HelpTemplate::USER_STATUS_DISABLED) {?><font class="red"><?php echo Yii::t('admin', 'Disable'); ?></font><?php } ?>,
                                <?php echo Yii::t('admin', 'Push'); ?>:
                                <?php if ($item->pushable) { ?><font class="green"><?php echo Yii::t('admin', 'Enable'); ?></font><?php } else {?><font class="red"><?php echo Yii::t('admin', 'Disable'); ?></font><?php } ?>
                            </td>
                            <td>
                                <div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
                                    <?php if ($item->account->status == HelpTemplate::USER_STATUS_DISABLED) { ?>
                                    <a href="<?php echo $this->createUrl('enable?id=' . $item['id']); ?>" title="<?php echo Yii::t('admin', 'Enable'); ?>" class="green">
                                        <i class="icon-unlock bigger-130"></i>
                                    </a>
                                    <?php } else { ?>
                                    <a href="<?php echo $this->createUrl('disable?id=' . $item['id']); ?>" title="<?php echo Yii::t('admin', 'Disable'); ?>" class="yellow">
                                        <i class="icon-lock bigger-130"></i>
                                    </a>
                                    <?php } ?>
                                    <?php if ($item->pushable) { ?>
                                    <a href="<?php echo $this->createUrl('disablepush?id=' . $item['id']); ?>" title="<?php echo Yii::t('admin', 'Disable push'); ?>" class="red">
                                        <i class="icon-download-alt bigger-130"></i>
                                    </a>
                                    <?php } else { ?>
                                    <a href="<?php echo $this->createUrl('enablepush?id=' . $item['id']); ?>" title="<?php echo Yii::t('admin', 'Enable push'); ?>" class="green">
                                        <i class="icon-download-alt bigger-130"></i>
                                    </a>
                                    <?php } ?>
                                    <a href="<?php echo $this->createUrl('detail?id=' . $item['id']); ?>" title="<?php echo Yii::t('admin', 'Detail'); ?>" class="green">
                                        <i class="icon-edit bigger-130"></i>
                                    </a>
                                    <a href="<?php echo $this->createUrl('delete?id=' . $item['id']); ?>" title="<?php echo Yii::t('admin', 'Delete'); ?>" class="red delete-confirm">
                                        <i class="icon-trash bigger-130"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php }} ?>
                    </tbody>
                </table>
            </form>
            <?php $this->widget('application.modules.admin.widgets.BCLinkPager', array('pages' => $pager)); ?>
        </div>
    </div>
</div>
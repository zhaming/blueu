<div class="row">
    <div class="col-xs-12">
        <form action="/admin/user/delete" method="POST">
            <p>
                <a href="/admin/user/create" class="btn btn-app btn-success btn-xs">
                    <i class="icon-plus bigger-120"></i>
                    <?php echo Yii::t('admin', 'Create'); ?>
                </a>
                <button type="submit" class="btn btn-app btn-danger btn-xs">
                    <i class="icon-remove bigger-120"></i>
                    <?php echo Yii::t('admin', 'Delete'); ?>
                </button>
            </p>
            <?php $message = Yii::app()->user->getFlash('messagetip'); if ($message != null) { ?>
            <div class="alert alert-block alert-success">
                <button type="button" class="close" data-dismiss="alert">
                    <i class="icon-remove"></i>
                </button>
                <p>
                    <strong>
                        <?php if ($message['type'] == 'success') { ?><i class="icon-ok"></i><?php } ?>
                        <?php if ($message['type'] == 'error') { ?><i class="icon-remove"></i><?php } ?>
                        <?php echo $message['msg']; ?>
                    </strong>
                </p>
            </div>
            <?php } ?>
            <div class="table-responsive">
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
                                <?php if ($item->account->status == 0) {echo Yii::t('admin', 'Enable');} if ($item->account->status == 1) {echo Yii::t('admin', 'Disable');} ?>,
                                <?php echo Yii::t('admin', 'Push'); ?>:
                                <?php if ($item->pushable) {echo Yii::t('admin', 'Enable');} else {echo Yii::t('admin', 'Disable');} ?>
                            </td>
                            <td>
                                <div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
                                    <?php if ($item->account->status == 1) { ?>
                                    <a href="<?php echo $this->createUrl('enable?id=' . $item['id']); ?>" title="<?php echo Yii::t('admin', 'Enable'); ?>" class="btn btn-xs btn-success">
                                        <i class="icon-unlock bigger-120"></i>
                                    </a>
                                    <?php } else { ?>
                                    <a href="<?php echo $this->createUrl('disable?id=' . $item['id']); ?>" title="<?php echo Yii::t('admin', 'Disable'); ?>" class="btn btn-xs btn-warning">
                                        <i class="icon-lock bigger-120"></i>
                                    </a>
                                    <?php } ?>
                                    <?php if ($item->pushable) { ?>
                                    <a href="<?php echo $this->createUrl('disablepush?id=' . $item['id']); ?>" title="<?php echo Yii::t('admin', 'Disable push'); ?>" class="btn btn-xs btn-danger">
                                        <i class="icon-download-alt bigger-120"></i>
                                    </a>
                                    <?php } else { ?>
                                    <a href="<?php echo $this->createUrl('enablepush?id=' . $item['id']); ?>" title="<?php echo Yii::t('admin', 'Enable push'); ?>" class="btn btn-xs btn-success">
                                        <i class="icon-download-alt bigger-120"></i>
                                    </a>
                                    <?php } ?>
                                    <a href="/admin/user/detail?id=<?php echo $item['id']; ?>" title="<?php echo Yii::t('admin', 'Edit'); ?>" class="btn btn-xs btn-success">
                                        <i class="icon-edit bigger-120"></i>
                                    </a>
                                    <a href="<?php echo $this->createUrl('delete?id=' . $item['id']); ?>" title="<?php echo Yii::t('admin', 'Delete'); ?>" class="btn btn-xs btn-danger delete-confirm">
                                        <i class="icon-trash bigger-120"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php }} ?>
                    </tbody>
                </table>
                <?php $this->widget('application.modules.admin.widgets.BCLinkPager', array('pages' => $pager)); ?>
            </div>
        </form>
    </div>
</div>
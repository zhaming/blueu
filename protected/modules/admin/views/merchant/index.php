<div class="row">
    <div class="col-xs-12">
        <form action="/admin/merchant/index" method="get" class="well form-inline">
            <label class="inline">
                <?php echo Yii::t('admin', 'Username'); ?>
                <input type="text" name="username" value="<?php if(!empty($_GET['username'])) { echo $_GET['username']; } ?>"> 
            </label>
            <label class="inline">
                <?php echo Yii::t('admin', 'Name'); ?>
                <input type="text" name="name" value="<?php if(!empty($_GET['name'])) { echo $_GET['name']; } ?>"> 
            </label>
            <label class="inline ">
                <input name="isonly" type="checkbox" class="ace" value="1">
                <span class="lbl"><?php echo Yii::t('admin', 'Normal'); ?></span>
            </label>
            <label class="inline" >
                <button type="submit" class="btn btn-xs btn-info">
                    <i class="icon-search"></i><?php echo Yii::t('admin', 'Search'); ?>
                </button>
            </label>
        </form>
        <form action="/admin/merchant/delete" method="POST">
            <p>
                <a href="/admin/merchant/create" class="btn btn-app btn-success btn-xs">
                    <i class="icon-plus bigger-120"></i>
                    <?php echo Yii::t('admin', 'Create'); ?>
                </a>
                <button type="submit" class="btn btn-app btn-danger btn-xs">
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
                                <?php if ($item->account->status == HelpTemplate::USER_STATUS_NORMAL) { ?><font class="green"><?php echo Yii::t('admin', 'Enable'); ?></font><?php } if ($item->account->status == HelpTemplate::USER_STATUS_DISABLED) { ?><font class="red"><?php echo Yii::t('admin', 'Disable'); ?></font><?php } ?>
                            </td>
                            <td>
                                <?php if ($item->account->status == HelpTemplate::USER_STATUS_DISABLED) { ?>
                                <a href="<?php echo $this->createUrl('enable?id=' . $item['id']); ?>" title="<?php echo Yii::t('admin', 'Enable'); ?>" class="btn btn-xs btn-success">
                                    <i class="icon-unlock bigger-120"></i>
                                </a>
                                <?php } else { ?>
                                <a href="<?php echo $this->createUrl('disable?id=' . $item['id']); ?>" title="<?php echo Yii::t('admin', 'Disable'); ?>" class="btn btn-xs btn-warning">
                                    <i class="icon-lock bigger-120"></i>
                                </a>
                                <?php } ?>
                                <a href="<?php echo $this->createUrl('detail?id=' . $item['id']); ?>" title="<?php echo Yii::t('admin', 'Detail'); ?>" class="btn btn-xs btn-success">
                                    <i class="icon-edit bigger-120"></i>
                                </a>
                                <a href="<?php echo $this->createUrl('delete?id=' . $item['id']); ?>" title="<?php echo Yii::t('admin', 'Delete'); ?>" class="btn btn-xs btn-danger delete-confirm">
                                    <i class="icon-trash bigger-120"></i>
                                </a>
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

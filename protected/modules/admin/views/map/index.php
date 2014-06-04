<div class="row">
    <div class="col-xs-12">
        <p>
            <a href="/admin/map/upload" class="btn btn-app btn-success btn-xs">
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
        <form action="/admin/map/index" method="get" class="well form-inline">
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
            <form action="/admin/map/delete" method="POST" class="batch-delete-form">
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
                            <th><?php echo Yii::t('admin', 'Name'); ?></th>
                            <th><?php echo Yii::t('admin', 'Market place'); ?></th>
                            <th><?php echo Yii::t('admin', 'Floor'); ?></th>
                            <th><?php echo Yii::t('admin', 'Created'); ?></th>
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
                            <td><?php echo $item['name']; ?></td>
                            <td><?php echo $item['marketplace']; ?></td>
                            <td><?php echo $item['floor']; ?></td>
                            <td><?php echo date('y-m-d H:i:s', $item['created']); ?></td>
                            <td>
                                <div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
                                    <?php if ($item['disabled'] == HelpTemplate::USER_STATUS_DISABLED) { ?>
                                    <a href="<?php echo $this->createUrl('enable?id=' . $item['id']); ?>" title="<?php echo Yii::t('admin', 'Enable'); ?>" class="green">
                                        <i class="icon-unlock bigger-130"></i>
                                    </a>
                                    <?php } else { ?>
                                    <a href="<?php echo $this->createUrl('disable?id=' . $item['id']); ?>" title="<?php echo Yii::t('admin', 'Disable'); ?>" class="yellow">
                                        <i class="icon-lock bigger-130"></i>
                                    </a>
                                    <?php } ?>
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
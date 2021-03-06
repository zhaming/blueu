<div class="row">
    <div class="col-xs-12">
        <p>
            <a href="/admin/advertisement/create" class="btn btn-app btn-success btn-xs">
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
            <form action="/admin/advertisement/delete" method="POST" class="batch-delete-form">
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
                            <th><?php echo Yii::t('admin', 'Position'); ?></th>
                            <th><?php echo Yii::t('admin', 'Url'); ?></th>
                            <th><?php echo Yii::t('admin', 'Description'); ?></th>
                            <th><?php echo Yii::t('admin', 'Source'); ?></th>
                            <th><i class="ace-icon glyphicon glyphicon-time bigger-110 hidden-480"></i><?php echo Yii::t('admin', 'Created'); ?></th>
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
                            <td><?php echo $item['placetag']; ?></td>
                            <td><?php echo $item['url']; ?></td>
                            <td><?php echo $item['desc']; ?></td>
                            <td><?php echo HelpTemplate::adSource($item['source']); ?></td>
                            <td><?php echo date('y-m-d H:i:s', $item['created']); ?></td>
                            <td>
                                <div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
                                    <?php if ($item->disabled == HelpTemplate::DISABLED) { ?>
                                    <a href="<?php echo $this->createUrl('enable?id=' . $item['id']); ?>" title="<?php echo Yii::t('admin', 'Enable'); ?>" class="green">
                                        <i class="ace-icon fa fa-unlock bigger-130"></i>
                                    </a>
                                    <?php } else { ?>
                                    <a href="<?php echo $this->createUrl('disable?id=' . $item['id']); ?>" title="<?php echo Yii::t('admin', 'Disable'); ?>" class="yellow">
                                        <i class="ace-icon fa fa-lock bigger-130"></i>
                                    </a>
                                    <?php } ?>
                                    <a href="<?php echo $this->createUrl('detail?id=' . $item['id']); ?>" title="<?php echo Yii::t('admin', 'Detail'); ?>" class="green">
                                        <i class="ace-icon fa fa-edit bigger-130"></i>
                                    </a>
                                    <a href="<?php echo $this->createUrl('delete?id=' . $item['id']); ?>" title="<?php echo Yii::t('admin', 'Delete'); ?>" class="red delete-confirm">
                                        <i class="ace-icon fa fa-trash-o bigger-130"></i>
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
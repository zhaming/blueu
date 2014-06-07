<div class="row">
    <div class="col-xs-12">
        <p>
            <a href="/admin/map/upload" class="btn btn-app btn-success btn-xs">
                <i class="ace-icon glyphicon glyphicon-plus bigger-120"></i>
                <?php echo Yii::t('admin', 'Create'); ?>
            </a>
            <button class="btn btn-app btn-danger btn-xs batch-delete-confirm">
                <i class="ace-icon glyphicon glyphicon-remove bigger-120"></i>
                <?php echo Yii::t('admin', 'Delete'); ?>
            </button>
        </p>
        <?php $this->widget('application.modules.admin.widgets.AlterMsgWidget'); ?>
        <form action="/admin/map/index" method="get" class="well form-inline">
            <label class="inline">
                <input type="text" name="name" value="<?php if(!empty($_GET['name'])) { echo $_GET['name']; } ?>" placeholder="<?php echo Yii::t('admin', 'Name'); ?>" /> 
            </label>
            <label class="inline" >
                <button type="submit" class="btn btn-xs btn-info">
                    <i class="ace-icon fa fa-search"></i><?php echo Yii::t('admin', 'Search'); ?>
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
                            <th><i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i><?php echo Yii::t('admin', 'Created'); ?></th>
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
                                        <i class="ace-icon fa fa-unlock bigger-130"></i>
                                    </a>
                                    <?php } else { ?>
                                    <a href="<?php echo $this->createUrl('disable?id=' . $item['id']); ?>" title="<?php echo Yii::t('admin', 'Disable'); ?>" class="yellow">
                                        <i class="ace-icon fa fa-lock bigger-130"></i>
                                    </a>
                                    <?php } ?>
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
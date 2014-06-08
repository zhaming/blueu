<div class="row">
    <div class="col-xs-12">
        <p>
            <a href="/admin/station/create" class="btn btn-app btn-success btn-xs"><i class="ace-icon fa fa-plus bigger-120"></i>创建</a>
        </p>
        <?php $this->widget("AlterMsgWidget") ?>
        <div class="table-responsive">
            <form  action="" method="get" class="well form-inline">
                <label class="inline">
                    <input type="text" name="name" value="<?php echo!empty($name) ? $name : ''; ?>" placeholder="<?php echo Yii::t('station', 'Station Name'); ?>" />
                </label>
                <label class="inline" >
                    <button type="submit" class="btn btn-xs btn-info">
                        <i class="ace-icon fa fa-search"></i><?php echo Yii::t('admin', 'Search'); ?>
                    </button>
                </label>
            </form>
            <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th><?php echo Yii::t('admin', 'Id'); ?></th>
                        <th><?php echo Yii::t('station', 'Station UUID'); ?></th>
                        <th><?php echo Yii::t('station', 'Station Name'); ?></th>
                        <th><?php echo Yii::t('station', 'Shop'); ?></th>
                        <th><?php echo Yii::t('station', 'positionX'); ?></th>
                        <th><?php echo Yii::t('station', 'positionY'); ?></th>
                        <th><?php echo Yii::t('station', 'Station Disabled'); ?></th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($data)): ?>
                        <?php foreach ($data as $key => $value) : ?>
                            <tr>
                                <td><?php echo $value->id ?></td>
                                <td><?php echo $value->uuid ?></td>
                                <td><?php echo $value->name ?></td>
                                <td><?php echo empty($value->shopid) ? '' : $value->shop->name ?></td>
                                <td><?php echo $value->positionX ?></td>
                                <td><?php echo $value->positionY; ?></td>
                                <td><?php echo $value->disabled == 1 ? "Yes" : "No"; ?></td>
                                <td>
                                    <div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
                                        <a href="/admin/station/edit/id/<?php echo $value->id; ?>" title="<?php echo Yii::t('admin', 'Detail'); ?>" class="green">
                                            <i class="ace-icon fa fa-edit bigger-130"></i>
                                        </a>
                                        <a href="/admin/station/delete/id/<?php echo $value->id; ?>" title="<?php echo Yii::t('admin', 'Delete'); ?>" class="red delete-confirm">
                                            <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
            <?php $this->widget('application.modules.admin.widgets.BCLinkPager', array('pages' => $pager)); ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th><?php echo Yii::t('admin', 'Id'); ?></th>
                        <th><?php echo Yii::t('admin', 'Contact'); ?></th>
                        <th><?php echo Yii::t('admin', 'User id'); ?></th>
                        <th><?php echo Yii::t('admin', 'Created'); ?></th>
                        <th><?php echo Yii::t('admin', 'Content'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data)) { foreach ($data as $item) { ?>
                    <tr>
                        <td><?php echo $item['id']; ?></td>
                        <td><?php echo $item['contact']; ?></td>
                        <td><?php echo $item['account']['username']; ?></td>
                        <td><?php echo date('y-m-d H:i:s', $item['created']); ?></td>
                        <td><?php echo $item['content']; ?></td>
                    </tr>
                    <?php }} ?>
                </tbody>
            </table>
            <?php //$this->widget('application.modules.admin.widgets.BCLinkPager', array('pages' => $pager)); ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="space-8"></div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th><?php echo Yii::t('admin', 'Time'); ?></th>
                        <th><?php echo Yii::t('admin', 'Content'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data)) { ?>
                    <?php foreach ($data as $item) { ?>
                    <tr>
                        <td><?php echo $item->time; ?></td>
                        <td><?php echo $item->content; ?></td>
                    </tr>
                    <?php }} ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

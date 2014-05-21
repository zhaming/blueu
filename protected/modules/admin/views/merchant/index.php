<div class="row">
    <div class="col-xs-12">
        <p>
            <a href="/admin/merchant/create" class="btn btn-app btn-success btn-xs"><i class="icon-plus bigger-120"></i>创建</a>
            <a href="/admin/merchant/delete" class="btn btn-app btn-danger btn-xs"><i class="icon-remove bigger-120"></i>删除</a>
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
            <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="center">
                            <label>
                                <input type="checkbox" class="ace" />
                                <span class="lbl"></span>
                            </label>
                        </th>
                        <th>编号</th>
                        <th>名称</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <?php if (!empty($data)) { foreach ($data as $item) { ?>
                        <td class="center">
                            <label>
                                <input type="checkbox" class="ace" />
                                <span class="lbl"></span>
                            </label>
                        </td>
                        <td><?php echo $item->id; ?></td>
                        <td><?php echo $item->name; ?></td>
                        <td>
                            <a href="/admin/merchant/activity?id=<?php echo $item->id; ?>" title="<?php echo Yii::t('admin', 'Product'); ?>" class="btn btn-xs btn-success">
                                <i class="icon-coffee bigger-120"></i>
                            </a>
                            <a href="/admin/merchant/stations?id=<?php echo $item->id; ?>" title="<?php echo Yii::t('admin', 'Bluetooth base station'); ?>" class="btn btn-xs btn-success">
                                <i class="icon-signal bigger-120"></i>
                            </a>
                            <a href="/admin/merchant/mermber?id=<?php echo $item->id; ?>" title="<?php echo Yii::t('admin', 'Member'); ?>" class="btn btn-xs btn-success">
                                <i class="icon-user bigger-120"></i>
                            </a>
                            <a href="/admin/merchant/edit?id=<?php echo $item->id; ?>" title="<?php echo Yii::t('admin', 'Edit'); ?>" class="btn btn-xs btn-success">
                                <i class="icon-edit bigger-120"></i>
                            </a>
                            <a href="" title="删除" class="btn btn-xs btn-danger">
                                <i class="icon-trash bigger-120"></i>
                            </a>
                        </td>
                    </tr>
                    <?php }} ?>
                </tbody>
            </table>
            <?php $this->widget('application.modules.admin.widgets.BCLinkPager', array('pages' => $pager)); ?>
        </div>
    </div>
</div>

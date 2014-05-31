<div class="row">
    <div class="col-xs-12">
        <form action="/admin/acl/delete" method="POST">
            <p>
                <a href="/admin/acl/create" class="btn btn-app btn-success btn-xs">
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
                            <th><?php echo Yii::t('admin', 'Access path'); ?></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
                <?php //$this->widget('application.modules.admin.widgets.BCLinkPager', array('pages' => $pager)); ?>
            </div>
        </form>
    </div>
</div>
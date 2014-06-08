<div class="page-header">
    <h1>
        <?php echo Yii::t('station', 'Station Manager');?>
        <small><i class="icon-double-angle-right"></i><?php echo Yii::t('station', 'Station ads list');?></small>
    </h1>
</div>
<div class="row">
    <div class="col-xs-12">
        <p>
            <a href="/admin/station/editads" class="btn btn-app btn-success btn-xs"><i class="ace-icon fa fa-plus bigger-120"></i><?php echo Yii::t("comment","Create");?></a>
        </p>
        <?php $this->widget("AlterMsgWidget")?>
        <div class="table-responsive">
            <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                    </tr>
                </thead>

                <tbody>
                <?php if(!empty($data)):?>
                    <?php foreach ($data as $key => $value) :?>
                        <br/>
                        <?php echo $value->uuid;?>
                        <?php echo $value->source;?>
                        <?php echo $value->sid;?>
                        <?php echo $value->shopid;?>
                    <?php endforeach;?>
                <?php endif;?>
                </tbody>
            </table>
            <?php $this->widget('application.modules.admin.widgets.BCLinkPager', array('pages' => $pager)); ?>
        </div>
    </div>
</div>

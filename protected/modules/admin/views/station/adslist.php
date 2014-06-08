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
                        <th><?php echo Yii::t("comment",'Number')?></th>
                        <th><?php echo Yii::t('station', 'Station UUID');?></th>
                        <th><?php echo Yii::t('station', 'Station Name');?></th>
                        <th><?php echo Yii::t('shop', 'Shop Name');?></th>
                        <th><?php echo Yii::t('admin', 'VSource'); ?></th>
                        <th><?php echo Yii::t("comment",'Operate')?></th>
                    </tr>
                </thead>

                <tbody>
                <?php if(!empty($data)):?>
                    <?php foreach ($data as $key => $value) :?>
                        <tr>
                        <td><?php echo $value->staionid?></td>
                        <td><?php echo $value->uuid;?></td>
                        <td><?php echo empty($value->station)?"":$value->station->name?></td>
                        <td><?php echo empty($value->shop)?"":$value->shop->name?></td>
                        <td>
                            <?php echo $sourceMap[$value->source]; ?>
                        </td>
                        <td>
                        <div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
                                <a href="/admin/merchantshop/delete/id/<?php echo $value->sid;?>"  title="<?php echo Yii::t("admin","Delete");?>"  class="delete-confirm red"> 
                                    <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                </a>
                                <a href="admin/station/editads/source/<?php echo $value->source?>/shopid/<?php echo $value->shopid?>/staionid/<?php echo $value->staionid?>/sid/<?php echo $value->sid;?>" title="<?php echo Yii::t("admin","Detail");?>" class="green"> 
                                    <i class="ace-icon fa fa-edit bigger-130"></i>
                                </a>
                        </div>

                        </td>
                        </tr>
                    <?php endforeach;?>
                <?php endif;?>
                </tbody>
            </table>
            <?php $this->widget('application.modules.admin.widgets.BCLinkPager', array('pages' => $pager)); ?>
        </div>
    </div>
</div>

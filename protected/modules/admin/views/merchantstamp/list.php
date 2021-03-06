<div class="row">
    <div class="col-xs-12">
        <p>
            <a href="/admin/merchantstamp/create" class="btn btn-app btn-success btn-xs">
                <i class="ace-icon fa fa-plus bigger-120"></i><?php echo Yii::t('admin', 'Create'); ?>
            </a>
        </p>
        <?php $this->widget("AlterMsgWidget") ?>
        <div class="table-responsive">
            <form  action="/admin/merchantstamp/index" method="get" class="well form-inline">
                <label class="inline">
                    <input type="text" name="name" value="<?php echo!empty($name) ? $name : ''; ?>" placeholder="<?php echo Yii::t('shop', "Stamp Name"); ?>" />
                </label>
                <label class="inline">
                    <button type="submit" class="btn btn-xs btn-info">
                        <i class="ace-icon fa fa-search"></i><?php echo Yii::t('admin', 'Search'); ?>
                    </button>
                </label>
            </form>
            <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th width="45px" ><?php echo Yii::t("comment", "Number"); ?></th>
                        <th><?php echo Yii::t("shop", "Stamp Name"); ?></th>
                        <th><?php echo Yii::t("shop", "Coupon validity start"); ?></th>
                        <th><?php echo Yii::t("shop", "Coupon validity end"); ?></th>
                        <th><?php echo Yii::t("shop", "Coupon total"); ?></th>
                        <th><?php echo Yii::t("shop", "Coupon used"); ?></th>
                        <th><?php echo Yii::t("comment", "Operate") ?></th>
                    </tr>
                </thead>

                <tbody>

                <?php if(!empty($data)):?>
                    <?php foreach ($data as $key => $value) :?>
                    <tr>
                        <td width="45px"  class="center"><?php echo $value->id?></td>
                        <td><?php echo $value->name?></td>
                        <td><?php echo empty($value->validity_start)?"":date("Y-m-d",$value->validity_start);?></td>
                        <td><?php echo empty($value->validity_end)?"":date("Y-m-d",$value->validity_end);?></td>
                        <td><?php echo $value->code->total;?></td>
                        <td><?php echo $value->code->used;?></td>
                        <td>
                            <div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
                                <a href="/admin/merchantstamp/edit/id/<?php echo $value->id; ?>" title="<?php echo Yii::t('admin', 'Detail'); ?>" class="green" >
                                    <i class="ace-icon fa fa-edit bigger-130"></i>
                                </a>
                                <a href="/admin/merchantstamp/delete/id/<?php echo $value->id; ?>" title="<?php echo Yii::t('admin', 'Delete'); ?>" class="delete-confirm red" >
                                    <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                </a>
                                <a href="/admin/push/add/source/3/shopid/<?php echo $value->shopid;?>/name/<?php echo $value->name;?>/sid/<?php echo $value->id;?>" title="<?php echo Yii::t("shop","Add push");?>"> 
                                    <i class="ace-icon fa fa-plus bigger-130"></i>
                                </a>
                                <a href="/admin/station/editads/sid/<?php echo $value->id?>/source/4/shopid/<?php echo $value->shopid?>" title="<?php echo Yii::t("station","Station add to ads");?>"> 
                                    <i class="ace-icon fa fa-bullhorn bigger-130"></i>
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
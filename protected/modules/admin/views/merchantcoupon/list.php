<div class="page-header">
    <h1>
        <?php echo Yii::t('shop', 'Coupon Manager');?>
        <small><i class="icon-double-angle-right"></i><?php echo Yii::t('shop', 'Coupon List');?></small>
    </h1>
</div>
<div class="row">
    <div class="col-xs-12">
        <p>
            <a href="/admin/merchantproduct/create" class="btn btn-app btn-yellow btn-xs">
                <i class="icon-create bigger-120"></i><?php echo Yii::t('comment', 'Add');?>
            </a>
        </p>
        <?php $this->widget("AlterMsgWidget")?>
        <div class="table-responsive">
            <form  action="/admin/merchantcoupon/index" method="get" class="well form-inline">
                <label class="inline">
                   <?php echo Yii::t('shop',"Coupon Name")?>：
                    <input type="text" name="name" value="<?php echo !empty($name)?$name:'' ;?>" />&emsp;
                </label>
                <label class="inline">
                    <button type="submit" class="btn btn-xs btn-info">
                        <i class="icon-search"></i><?php echo Yii::t('comment', 'Select');?>
                    </button>
                </label>
            </form>
            <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th width="45px" ><?php echo Yii::t("comment","Number");?></th>
                        <th><?php echo Yii::t("shop","Coupon Name");?></th>
                        <th><?php echo Yii::t("comment","Price");?></th>
                        <th><?php echo Yii::t("shop","Coupon validity start");?></th>
                        <th><?php echo Yii::t("shop","Coupon validity end");?></th>
                        <th><?php echo Yii::t("shop","Coupon total");?></th>
                        <th><?php echo Yii::t("shop","Coupon used");?></th>
                        <th><?php echo Yii::t("comment","Operate")?></th>
                    </tr>
                </thead>

                <tbody>
                <?php if(!empty($data)):?>
                    <?php foreach ($data as $key => $value) :?>
                    <tr>
                        <td width="45px"  class="center"><?php echo $value->id?></td>
                        <td><?php echo $value->name?></td>
                        <td><?php echo $value->price?></td>
                        <td><?php echo empty($value->validity_start)?"":date("Y-m-d",$value->validity_start);?></td>
                        <td><?php echo empty($value->validity_end)?"":date("Y-m-d",$value->validity_end);?></td>
                        <td><?php echo $value->coupon->total;?></td>
                        <td><?php echo $value->coupon->used;?></td>
                        <td>
                            <a href="/admin/merchantcoupon/edit/id/<?php echo $value->id;?>" title="<?php echo Yii::t('admin', 'Detail'); ?>"  class="green" ><i class="ace-icon fa fa-edit bigger-130"></i></a>
                            <a href="/admin/merchantcoupon/delete/id/<?php echo $value->id;?>" title="<?php echo Yii::t('admin', 'Delete'); ?>"  class="delete-confirm red" ><i class="ace-icon fa fa-trash-o bigger-130"></i></a>
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
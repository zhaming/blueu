<div class="row">
    <div class="col-xs-12">
        <p>
            <a href="/admin/merchantproduct/create" class="btn btn-app btn-success btn-xs"><i class="ace-icon fa fa-plus bigger-120"></i><?php echo Yii::t("comment","Create");?></a>
        </p>
        <?php $this->widget("AlterMsgWidget")?>
        <div class="table-responsive">
            <form  action="/admin/merchantproduct/index" method="get" class="well form-inline">
                <label class="inline">
                    <?php echo Yii::t("shop","Product name");?>：
                    <input type="text" name="name" value="<?php echo !empty($name)?$name:'' ;?>" />&emsp;
                </label>
                <label class="inline" >
                    <button type="submit" class="btn btn-xs btn-info">
                        <i class="ace-icon fa fa-search"></i> <?php echo Yii::t("comment","Select");?>
                    </button>
                </label>
            </form>
            <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th width="45px" ><?php echo Yii::t("comment","Number");?></th>
                        <th><?php echo Yii::t("shop","Product name");?></th>
                        <th><?php echo Yii::t('shop','Product intro');?></th>
                        <th><?php echo Yii::t("shop","Price");?></th>
                        <th><?php echo Yii::t("shop","discount");?></th>
                        <th><?php echo Yii::t("shop","Apply to shops");?></th>
                        <th><?php echo Yii::t("shop","Release people");?></th>
                        <th><?php echo Yii::t("comment","status");?></th>
                        <th><?php echo Yii::t("comment","Operate");?></th>
                    </tr>
                </thead>

                <tbody>
                <?php if(!empty($data)):?>
                    <?php foreach ($data as $key => $value) :?>
                    <tr>
                        <td width="45px"  class="center"><?php echo $value->id?></td>
                        <td><?php echo $value->name?></td>
                        <td><?php echo $value->intro?></td>
                        <td><?php echo $value->price?></td>
                        <td><?php echo $value->discount?></td>
                        <td><?php if(!empty($value->shop_product)):?>
                            <?php foreach ($value->shop_product as $k => $v) :?>
                                <?php  echo empty($v->shop)?"":$v->shop->name;?>&emsp;
                            <?php endforeach;?>
                            <?php endif;?>
                        </td>
                        <td><?php echo !empty($value->merchant)?$value->merchant->name:"";?></td>
                        <td>
                            <?php $status =$value->status;
                                switch ($status) {
                                    case 0:
                                    echo Yii::t('comment',"Approveding");
                                        break;
                                    case 1:
                                    echo Yii::t('comment',"Approved");
                                        break;
                                    case 2:
                                    echo Yii::t('comment',"Unapproved");
                                        break;
                                    default:
                                        break;
                                }
                            ?>
                        </td>
                        <td>
                            <div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
                                <a href="/admin/merchantproduct/edit/id/<?php echo $value->id;?>" title="<?php echo Yii::t('admin', 'Detail'); ?>"  class="green" ><i class="ace-icon fa fa-edit bigger-130"></i></a>
                                <a href="/admin/merchantproduct/delete/id/<?php echo $value->id;?>" title="<?php echo Yii::t('admin', 'Delete'); ?>"  class="delete-confirm red" ><i class="ace-icon fa fa-trash-o bigger-130"></i></a>
                                 <a href="/admin/push/add/source/2/shopid/<?php echo empty($value->shop_product)?"":$value->shop_product[0]['shopid'];?>/name/<?php echo $value->name;?>/sid/<?php echo $value->id;?>" title="<?php echo Yii::t("shop","Add push");?>"> 
                                    <i class="ace-icon fa fa-plus bigger-130"></i>
                                </a>

                                <a href="/admin/station/editads/sid/<?php echo $value->id?>/source/2/shopid/<?php echo empty($value->shop_product)?"":$value->shop_product[0]['shopid'];?>" title="<?php echo Yii::t("station","Station add to ads");?>"> 
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
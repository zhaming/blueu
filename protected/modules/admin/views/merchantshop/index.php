<div class="page-header">
    <h1>
        <?php echo Yii::t('shop', 'Shop Manager');?>
        <small><i class="icon-double-angle-right"></i><?php echo Yii::t("shop","Shop List");?></small>
    </h1>
</div>
<div class="row">
    <div class="col-xs-12">
        <p>
            <a href="/admin/merchantshop/create" class="btn btn-app btn-success btn-xs"><i class="ace-icon fa fa-plus bigger-120"></i><?php echo Yii::t('admin', 'Create'); ?></a>
        </p>
        <?php $this->widget("AlterMsgWidget")?>
        <div class="table-responsive">
            <form  action="/admin/merchantshop/index" method="get" class="well form-inline">
                <label class="inline">
                    <?php echo Yii::t("shop","Shop Name");?>：
                    <input type="text" name="name" value="<?php echo !empty($name)?$name:'' ;?>" />&emsp;
                </label>
                <label class="inline">
                    <?php echo Yii::t("shop","Shop Owner");?>：
                    <input type="text" name="owner" value="<?php echo !empty($owner)?$owner:'' ;?>" />&emsp;
                </label>
                <label class="inline ">
                    <input name="isonly" type="checkbox" class="ace" value="1" <?php echo !empty($isonly)?"checked":'' ;?>>
                    <span class="lbl">  <?php echo Yii::t("shop","Only");?>&emsp;</span>
                </label>
                <label class="inline" >
                    <button type="submit" class="btn btn-xs btn-info">
                        <i class="icon-search"></i> <?php echo Yii::t("comment","Select");?>
                    </button>
                </label>
            </form>
            <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th><?php echo Yii::t("comment","Number");?></th>
                        <th><?php echo Yii::t("shop","Shop Name");?></th>
                        <th><?php echo Yii::t("shop","Shop Owner");?></th>
                        <th><?php echo Yii::t("admin","Telephone")?></th>
                        <th><?php echo Yii::t("shop","Shop Address")?></th>
                        <th><?php echo Yii::t("shop","Main")?></th>
                        <th><?php echo Yii::t("shop","Only")?></th>
                        <th><?php echo Yii::t("comment","Operate");?></th>
                    </tr>
                </thead>

                <tbody>
                <?php if(!empty($data)):?>
                    <?php foreach ($data as $key => $value) :?>
                    <tr>
                        <td><?php echo $value->id?></td>
                        <td><?php echo $value->name?></td>
                        <td><?php echo $value->owner?></td>
                        <td><?php echo $value->telephone?></td>
                        <td><?php echo $value->address;?></td>
                        <td><?php echo $value->ismain ==1?"Y":"N";?></td>
                        <td><?php echo $value->isonly ==1?"Y":"N";?></td>
                        <td>
<<<<<<< HEAD
                            <a href="/admin/merchantshop/delete/id/<?php echo $value->id;?>"  title="<?php echo Yii::t("admin","Delete");?>"  class="delete-confirm red"> 
                                <i class="ace-icon fa fa-trash-o bigger-130"></i>
                            </a>
                            <a href="/admin/merchantshop/edit/id/<?php echo $value->id;?>" title="<?php echo Yii::t("admin","Detail");?>" class="green"> 
                                <i class="ace-icon fa fa-edit bigger-130"></i>
                            </a>
                            <?php if(empty($value->selfid)): ?>
                            <a href="/admin/merchantshop/addshopaccount/id/<?php echo $value->id;?>"  title="<?php echo Yii::t("shop","Create account");?>" class="orange" > 
                                <i class="ace-icon fa fa-lemon-o bigger-130"></i>
                            </a>
                            <?php endif;?>
                            <a href="/admin/station/create/shopid/<?php echo $value->id;?>" title="<?php echo Yii::t("shop","Add station");?>"> 
                                <i class="ace-icon fa fa-rss bigger-130"></i>
                            </a>
=======
                            <div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
                                <a href="/admin/merchantshop/delete/id/<?php echo $value->id;?>"  title="<?php echo Yii::t("admin","Delete");?>"  class="delete-confirm red"> 
                                    <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                </a>
                                <a href="/admin/merchantshop/edit/id/<?php echo $value->id;?>" title="<?php echo Yii::t("admin","Detail");?>" class="green"> 
                                    <i class="ace-icon fa fa-edit bigger-130"></i>
                                </a>
                                <?php if(empty($value->selfid)): ?>
                                <a href="/admin/merchantshop/addshopaccount/id/<?php echo $value->id;?>"  title="<?php echo Yii::t("shop","Create account");?>" class="orange" > 
                                    <i class="ace-icon fa fa-lemon-o bigger-130"></i>
                                </a>
                                <?php endif;?>
                                <a href="/admin/station/create/shopid/<?php echo $value->id;?>" title="<?php echo Yii::t("shop","Add station");?>"> 
                                    <i class="ace-icon fa fa-plus bigger-130"></i>
                                </a>
                            </div>
>>>>>>> e8602fa8dba6853736fa69258bf869e12bc71872
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

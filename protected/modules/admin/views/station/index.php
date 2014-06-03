<div class="page-header">
    <h1>
        <?php echo Yii::t('station', 'Station Manager');?>
        <small><i class="icon-double-angle-right"></i><?php echo Yii::t('station', 'Station List');?></small>
    </h1>
</div>
<div class="row">
    <div class="col-xs-12">
        <p>
            <a href="/admin/station/create" class="btn btn-app btn-yellow btn-xs"><i class="icon-create bigger-120"></i>创建</a>
        </p>
        <?php $this->widget("AlterMsgWidget")?>
        <div class="table-responsive">
            <form  action="" method="get" class="well form-inline">
                <label class="inline">
                    <?php echo Yii::t('station', 'Station Name');?>：
                    <input type="text" name="name" value="<?php echo !empty($name)?$name:'' ;?>" />&emsp;
                </label>
                <label class="inline" >
                    <button type="submit" class="btn btn-xs btn-info">
                        <i class="icon-search"></i> 查询
                    </button>
                </label>
            </form>
            <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>编号</th>
                        <th><?php echo Yii::t('station', 'Station UUID');?></th>
                        <th><?php echo Yii::t('station', 'Station Name');?></th>
                        <th><?php echo Yii::t('station', 'Shop');?></th>
                        <th><?php echo Yii::t('station', 'positionX');?></th>
                        <th><?php echo Yii::t('station', 'positionY');?></th>
                        <th><?php echo Yii::t('station', 'Station Disabled');?></th>
                        <th>操作</th>
                    </tr>
                </thead>

                <tbody>
                <?php if(!empty($data)):?>
                    <?php foreach ($data as $key => $value) :?>
                    <tr>
                        <td><?php echo $value->id?></td>
                        <td><?php echo $value->uuid?></td>
                        <td><?php echo $value->name?></td>
                        <td><?php echo empty($value->shopid)?'':$value->shop->name?></td>
                        <td><?php echo $value->positionX?></td>
                        <td><?php echo $value->positionY;?></td>
                        <td><?php echo $value->disabled ==1?"Yes":"No";?></td>
                         <td>
                            <a onclick="return confirm('确定要删除吗？');" href="/admin/station/delete/id/<?php echo $value->id;?>"><i class="icon-remove red"></i>删除</a>
                            <a href="/admin/station/edit/id/<?php echo $value->id;?>"><i class="icon-edit"></i>详情</a>
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

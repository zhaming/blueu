<div class="row">
    <div class="col-xs-12">
        <p>
            <a href="/admin/task/add" class="btn btn-app btn-success btn-xs">
                <i class="icon-plus bigger-120"></i>
                <?php echo Yii::t('admin', 'Create'); ?>
            </a>
        </p>
        <?php $this->widget("AlterMsgWidget")?>
        
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th><?php echo Yii::t('admin', 'VTaskNT'); ?></th>
                        <th><?php echo Yii::t('admin', 'VTaskMsg'); ?></th>
                        <th style="width:12%"><?php echo Yii::t('admin', 'VOther'); ?></th>
                        <th style="width:16%">
                            <i class="icon-time bigger-110 hidden-480"></i>
                            <?php echo Yii::t('admin', 'VTaskTime'); ?>
                        </th>
                        <th style="width:15%"><?php echo Yii::t('admin', 'VStatus'); ?></th>
                        <th style="width:15%"></th>
                    </tr>
                </thead>

                <tbody>
                    <?php if(empty($list)){ ?>
                    <tr><td colspan="6" class="center"><br><?php echo Yii::t('admin', 'VNoData'); ?><br><br></td></tr>
                    <?php }else{ ?>
                    <?php foreach($list as $value){ ?>
                    <tr>
                        <td title="<?php echo $value->memo; ?>">
                            <?php echo $value->name; ?><br>
                            <span style="font-style:italic"><?php echo $value->type; ?>:<?php echo $value->item; ?></span>
                        </td>
                        <td title="<?php echo $value->msg; ?>">
                            <?php echo MingString::str_cut($value->msg, 60); ?>
                        </td>
                        <td>
                            <?php echo Yii::t('admin', 'VTaskKind'); ?>
                            <strong>
                                <?php echo $value->immediately==1?Yii::t('admin', 'VTaskKind1'):Yii::t('admin', 'VTaskKind0'); ?>
                            </strong><br>
                            <?php echo Yii::t('admin', 'VPriority'); ?>
                            <strong><?php echo $value->priority . Yii::t('admin', 'VPriorityL'); ?></strong>
                        </td>
                        <td>
                            <?php echo date('Y-m-d H:i:s', $value->created); ?><br>
                            <font color="green">
                                <?php echo empty($value->lasttime)?Yii::t('admin', 'VTaskNoRun'):date('Y-m-d H:i:s', $value->lasttime); ?>
                            </font>
                        </td>
                        <td>
                            <?php echo Yii::t('admin', 'VRuntime'); ?>
                            <strong>
                                <?php echo $value->runtime==1?Yii::t('admin', 'VRuntime1'):Yii::t('admin', 'VRuntime0'); ?>
                            </strong><br>
                            <?php echo Yii::t('admin', 'VDisabled'); ?>
                            <strong>
                                <?php echo $value->disabled==0?Yii::t('admin', 'VDisabled0'):Yii::t('admin', 'VDisabled1'); ?>
                            </strong>
                        </td>
                        <td>
                            <a href="<?php echo $this->createUrl('log?taskid=' . $value->id); ?>" title="<?php echo Yii::t('admin', 'Log'); ?>" class="btn btn-xs btn-success">
                                <i class="icon-external-link bigger-120"></i>
                            </a>
                            <a href="<?php echo $this->createUrl('edit?id=' . $value->id); ?>" title="<?php echo Yii::t('admin', 'Edit'); ?>" class="btn btn-xs btn-success">
                                <i class="icon-edit bigger-120"></i>
                            </a>
                            <a href="<?php echo $this->createUrl('delete?id=' . $value->id); ?>" title="<?php echo Yii::t('admin', 'Delete'); ?>" class="btn btn-xs btn-danger delete-confirm">
                                <i class="icon-trash bigger-120"></i>
                            </a>
                        </td>
                    </tr>
                    <?php }} ?>
                </tbody>
            </table>
        </div>
        
        <div class="widget-box">
            <div class="widget-header widget-header-flat">
                <h4 class="smaller-80"><?php echo Yii::t('admin', 'TaskDefinition'); ?></h4>
            </div>
            <div class="widget-body">
                <div class="widget-main">
                    <dl id="dt-list-1">
                        <dd><?php echo Yii::t('admin', 'TaskDefinition0'); ?></dd>
                        <dd><?php echo Yii::t('admin', 'TaskDefinition1'); ?></dd>
                        <dd><?php echo Yii::t('admin', 'TaskDefinition2'); ?></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$('table th input:checkbox').on('click' , function(){
    var that = this;
    $(this).closest('table').find('tr > td:first-child input:checkbox')
    .each(function(){
        this.checked = that.checked;
        $(this).closest('tr').toggleClass('selected');
    });

});
</script>
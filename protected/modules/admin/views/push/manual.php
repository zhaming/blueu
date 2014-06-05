<div class="row">
    <div class="col-xs-12">
        <p>
            <a href="/admin/push/add" class="btn btn-app btn-success btn-xs">
                <i class="icon-plus bigger-120"></i>
                <?php echo Yii::t('admin', 'Create'); ?>
            </a>
        </p>
        <?php $this->widget("AlterMsgWidget")?>
        
        <div class="table-header"><?php echo Yii::t('admin', 'SearchForm'); ?></div>
        <div class="table-responsive">
            <form method="GET">
            <div class="row" style="margin-bottom:5px;">
                <div class="col-xs-12">
                    <span class="input-icon" style="float:left;">
                        <?php echo CHtml::dropDownList('source', Yii::app()->request->getQuery('source'), $sourceMap, 
                            array('class'=>'form-control', style=>'height:34px')
                        );?>
                    </span>
                    <span class="input-icon" style="float:left;margin-left:5px;">
                        <?php echo CHtml::textField('sid', Yii::app()->request->getQuery('sid'),
                            array('class'=>'form-control','placeholder' => Yii::t('admin', 'VSID'))
                        );?>
                    </span>
                    <span class="input-group" style="float:left;width:150px;margin-left:20px;">
                        <?php echo CHtml::textField('start', Yii::app()->request->getQuery('start'), 
                            array(
                                'class'=>'form-control date-picker',
                                'placeholder' => Yii::t('admin', 'VStart'),
                                'data-date-format' => 'yyyy-mm-dd'
                            )
                        );?>
                        <span class="input-group-addon"><i class="icon-calendar bigger-110"></i></span>
                        -
                    </span>
                    <span class="input-group" style="float:left;width:150px;">
                        <?php echo CHtml::textField('end', Yii::app()->request->getQuery('end'), 
                            array(
                                'class'=>'form-control date-picker',
                                'placeholder' => Yii::t('admin', 'VEnd'),
                                'data-date-format' => 'yyyy-mm-dd'
                            )
                        );?>
                        <span class="input-group-addon"><i class="icon-calendar bigger-110"></i></span>
                    </span>
                    <span class="input-group-btn" style="float:right;width:auto;">
                        <button type="submit" class="btn btn-purple btn-sm">
                            <?php echo Yii::t('admin', 'Search'); ?>
                            <i class="icon-search icon-on-right bigger-110"></i>
                        </button>
                    </span>
                </div>
            </div>
            </form>
            
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="center"><label><input type="checkbox" class="ace" /><span class="lbl"></span></label></th>
                        <th class="center" style="width:7%"><?php echo Yii::t('admin', 'VSource'); ?></th>
                        <th style="width:10%"><?php echo Yii::t('admin', 'VSourceName'); ?></th>
                        <th><?php echo Yii::t('admin', 'Shop'); ?></th>
                        <th><?php echo Yii::t('admin', 'VTaskMsg'); ?></th>
                        <th class="center" style="width:8%"><?php echo Yii::t('admin', 'Push'); ?></th>
                        <th class="center" style="width:16%"><?php echo Yii::t('admin', 'Created'); ?></th>
                        <th style="width:10%"></th>
                    </tr>
                </thead>
                
                <tbody>
                <?php if(empty($list)){ ?>
                    <tr><td colspan="8" class="center"><br><?php echo Yii::t('admin', 'VNoData'); ?><br><br></td></tr>
                    <?php }else{ ?>
                    <?php foreach($list as $value){ ?>
                    <tr>
                        <td class="center">
                            <label>
                                <input type="checkbox" name="id[]" value="<?php echo $value->id; ?>" class="ace" />
                                <span class="lbl"></span>
                            </label>
                        </td>
                        <td class="center" title="<?php echo $value->source; ?>">
                            <?php echo $sourceMap[$value->source]; ?>
                        </td>
                        <td title="<?php echo $value->sid; ?>">
                            <?php echo $value->name; ?>
                        </td>
                        <td title="<?php echo $value->shopid; ?>">
                            <?php echo $value->shopname; ?>
                        </td>
                        <td title="<?php echo $value->msg; ?>">
                            <?php echo MingString::str_cut($value->msg, 50); ?>
                        </td>
                        <td class="center">
                            <span title="<?php echo Yii::t('admin', 'VPushLimit'); ?>">
                                <strong><?php echo $value->limit; ?></strong>
                            </span>&nbsp;&nbsp;
                            <span title="<?php echo Yii::t('admin', 'VPushCount'); ?>">
                                <strong><?php echo $value->count; ?></strong>
                            </span>
                        </td>
                        <td class="center">
                            <?php echo date('Y-m-d H:i:s', $value->created); ?>
                        </td>
                        <td>
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
            <?php $this->widget('application.modules.admin.widgets.BCLinkPager', array('pages' => $pages)); ?>
        </div>
        
    </div>
</div>

<script type="text/javascript">
$().ready(function(){
    Order.init(['#order_created', '#order_clicktime']);
    $('.date-picker').datepicker({autoclose:true}).next().on(ace.click_event, function(){
        $(this).prev().focus();
    });
});
</script>
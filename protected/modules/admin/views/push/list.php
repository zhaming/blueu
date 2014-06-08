<div class="row">
    <div class="col-xs-12">
        <?php $this->widget("AlterMsgWidget")?>
        
        <div class="table-header"><?php echo Yii::t('admin', 'SearchForm'); ?></div>
        <div class="table-responsive">
            <form method="GET">
            <div class="row" style="margin-bottom:5px;">
                <div class="col-xs-12">
                    <span class="input-icon" style="float:left">
                        <?php echo CHtml::textField('to', Yii::app()->request->getQuery('to'),
                            array('class'=>'form-control','placeholder' => Yii::t('admin', 'VToId'))
                        );?>
                    </span>
                    <span class="input-icon" style="float:left;margin-left:20px;">
                        <?php echo CHtml::dropDownList('type', Yii::app()->request->getQuery('type'), $types, 
                            array('class'=>'form-control', 'style'=>'height:34px', 'kvEqual' => true)
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
                        <span class="input-group-addon"><i class="ace-icon fa fa-calendar bigger-110"></i></span>
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
                        <span class="input-group-addon"><i class="ace-icon fa fa-calendar bigger-110"></i></span>
                    </span>
                    <span class="input-group-btn" style="float:right;width:auto;">
                        <button type="submit" class="btn btn-purple btn-sm">
                            <?php echo Yii::t('admin', 'Search'); ?>
                            <i class="ace-icon fa fa-search icon-on-right bigger-110"></i>
                        </button>
                    </span>
                </div>
            </div>
            </form>
            
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th style="width:12%"><?php echo Yii::t('admin', 'VPusher'); ?></th>
                        <th style="width:12%"><?php echo Yii::t('admin', 'VReceiver'); ?></th>
                        <th><?php echo Yii::t('admin', 'VPushMsg'); ?></th>
                        <th><?php echo Yii::t('admin', 'VSource'); ?></th>
                        <th style="width:16%"><?php echo Yii::t('admin', 'VTimePC'); ?></th>
                    </tr>
                </thead>
                
                <tbody>
                <?php if(empty($list)){ ?>
                    <tr><td colspan="6" class="center"><br><?php echo Yii::t('admin', 'VNoData'); ?><br><br></td></tr>
                    <?php }else{ ?>
                    <?php foreach($list as $value){ ?>
                    <tr>
                        <td>
                            <?php if($value->from > 0){ ?>
                            <a href="/admin/user/detail?id=<?php echo $value->from; ?>"><?php echo $value->fromtitle; ?></a>
                            <?php }else{ ?>
                            <?php echo $value->fromtitle; ?>
                            <?php } ?><br>
                            <span style="font-style:italic"><?php echo $value->type; ?></span>
                        </td>
                        <td>
                            <a href="/admin/user/detail?id=<?php echo $value->to; ?>"><?php echo $value->totitle; ?></a>
                        </td>
                        <td title="<?php echo $value->message; ?>">
                            <?php echo MingString::str_cut($value->message, 80); ?>
                        </td>
                        <td>
                            <?php echo Yii::t('admin', 'Shop') . ':'; ?>
                            <strong><?php echo empty($value->shopname)?Yii::t('admin', 'VNoDataS'):$value->shopname; ?></strong><br>
                            <?php if(empty($value->source)){ ?>
                            <?php echo Yii::t('admin', 'VNoDataS'); ?>
                            <?php }else{ ?>
                            <?php echo $sourceMap[$value->source] . ':'; ?>
                            <strong><?php echo $value->srcname; ?></strong>
                            <?php } ?>
                        </td>
                        <td>
                            <?php echo date('Y-m-d H:i:s', $value->created); ?><br>
                            <font color="green">
                                <?php echo empty($value->clicktime)?Yii::t('admin', 'VPushNoClick'):date('Y-m-d H:i:s', $value->clicktime); ?>
                            </font>
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
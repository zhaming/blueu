<div class="row">
    <div class="col-xs-12">
        <?php $this->widget("AlterMsgWidget")?>
        
        <div class="table-header"><?php echo Yii::t('admin', 'SearchForm'); ?></div>
        <div class="table-responsive">
            <form action="/admin/task/log" method="GET">
            <div class="row" style="margin-bottom:5px;">
                <div class="col-xs-12">
                    <span class="input-icon" style="float:left">
                        <?php echo CHtml::dropDownList('taskid', Yii::app()->request->getQuery('taskid'), $tasks, 
                            array('class'=>'form-control', style=>'height:34px')
                        );?>
                    </span>
                    <span class="input-group" style="float:left;width:150px;margin-left:50px;">
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
                        <th style="width:15%" id="order_taskid"><?php echo Yii::t('admin', 'VTaskName'); ?></th>
                        <th style="width:16%" id="order_start"><?php echo Yii::t('admin', 'VStart'); ?></th>
                        <th style="width:16%" id="order_end"><?php echo Yii::t('admin', 'VEnd'); ?></th>
                        <th class="center" style="width:9%"><?php echo Yii::t('admin', 'VCostTime'); ?></th>
                        <th class="center" style="width:9%" id="order_total"><?php echo Yii::t('admin', 'VTotal'); ?></th>
                        <th class="center" style="width:7%" id="order_success"><?php echo Yii::t('admin', 'VSuccess'); ?></th>
                        <th class="center" style="width:7%"><?php echo Yii::t('admin', 'VFailed'); ?></th>
                        <th><?php echo Yii::t('admin', 'VStatusCode'); ?></th>
                    </tr>
                </thead>

                <tbody>
                    <?php if(empty($list)){ ?>
                    <tr><td colspan="8" class="center"><br><?php echo Yii::t('admin', 'VNoData'); ?><br><br></td></tr>
                    <?php }else{ ?>
                    <?php foreach($list as $v){ ?>
                    <tr>
                        <td><?php echo $tasks[$v->taskid]; ?></td>
                        <td><?php echo empty($v->start)?'':date('Y-m-d H:i:s', $v->start); ?></td>
                        <td><?php echo empty($v->end)?'':date('Y-m-d H:i:s', $v->end); ?></td>
                        <td class="center"><?php echo $v->interval . Yii::t('admin', 'VSecond'); ?></td>
                        <td class="center"><font color="blue"><?php echo $v->total; ?></font></td>
                        <td class="center"><font color="green"><?php echo $v->success; ?></font></td>
                        <td class="center"><font color="red"><?php echo $v->failed; ?></font></td>
                        <td style="word-break:break-all;overflow:hidden;">
                            <?php echo $v->result; ?>
                        </td>
                    </tr>
                    <?php }} ?>
                </tbody>
            </table>
            <?php $this->widget('application.modules.admin.widgets.BCLinkPager', array('pages' => $pages)); ?>
        </div>
        
        <div class="widget-box">
            <div class="widget-header widget-header-flat">
                <h5><?php echo Yii::t('admin', 'TaskErrDefinition'); ?></h5>
            </div>
            <div class="widget-body">
                <div class="widget-main">
                    <dl id="dt-list-1">
                        <dd><?php echo Yii::t('admin', 'TaskErrDesc'); ?></dd>
                        <dd><font color="green"><b>0</b></font><?php echo Yii::t('admin', 'TaskErr0'); ?></dd>
                        <dd><font color="red"><b>1</b></font><?php echo Yii::t('admin', 'TaskErr1'); ?></dd>
                        <dd><font color="red"><b>2</b></font><?php echo Yii::t('admin', 'TaskErr2'); ?></dd>
                        <dd><font color="red"><b>3</b></font><?php echo Yii::t('admin', 'TaskErr3'); ?></dd>
                        <dd><font color="red"><b>4</b></font><?php echo Yii::t('admin', 'TaskErr4'); ?></dd>
                        <dd><font color="red"><b>5</b></font><?php echo Yii::t('admin', 'TaskErr5'); ?></dd>
                        <dd><font color="red"><b>6</b></font><?php echo Yii::t('admin', 'TaskErr6'); ?></dd>
                        <dd><font color="red"><b>7</b></font><?php echo Yii::t('admin', 'TaskErr7'); ?></dd>
                        <dd><font color="red"><b>8</b></font><?php echo Yii::t('admin', 'TaskErr8'); ?></dd>
                        <dd><font color="red"><b>9</b></font><?php echo Yii::t('admin', 'TaskErr9'); ?></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$().ready(function(){
    Order.init(['#order_start', '#order_end', '#order_total', '#order_success']);
    $('.date-picker').datepicker({autoclose:true}).next().on(ace.click_event, function(){
        $(this).prev().focus();
    });
});
</script>
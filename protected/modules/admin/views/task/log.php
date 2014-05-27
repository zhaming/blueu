<div class="row">
    <div class="col-xs-12">
        <form action="/admin/task/delete" method="POST">
        <p>
            <a href="/admin/task/add" class="btn btn-app btn-success btn-xs">
                <i class="icon-plus bigger-120"></i>
                <?php echo Yii::t('admin', 'Create'); ?>
            </a>
            
            <button type="submit" class="btn btn-app btn-danger btn-xs">
                <i class="icon-remove bigger-120"></i>
                <?php echo Yii::t('admin', 'Delete'); ?>
            </button>
        </p>
        </form>
        <?php $this->widget("AlterMsgWidget")?>
        
        <div class="table-header"><?php echo Yii::t('admin', 'SearchForm'); ?></div>
        <div class="table-responsive">
            <div class="row" style="margin-bottom:5px;">
                <div class="col-xs-12">
                    <form action="#" method="GET">
                    <div class="input-group">
                        <span class="input-icon">
                            <input type="text" class="form-control" placeholder="<?php echo Yii::t('admin', 'Username'); ?>">
                        </span>
                        <span class="input-icon" style="margin-left:10px;">
                            <input type="text" class="form-control" placeholder="Type your query">
                        </span>
                        <span class="input-group-btn float-right">
                            <button type="button" class="btn btn-purple btn-sm">
                                <?php echo Yii::t('admin', 'Search'); ?>
                                <i class="icon-search icon-on-right bigger-110"></i>
                            </button>
                        </span>
                    </div>
                    </form>
                </div>
            </div>
            
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="center">
                            <label><input type="checkbox" class="ace" /><span class="lbl"></span></label>
                        </th>
                        <th>名称/类型</th>
                        <th>参数</th>
                        <th class="hidden-480">其他</th>
                        <th>
                            <i class="icon-time bigger-110 hidden-480"></i>
                            创建/执行时间
                        </th>
                        <th class="hidden-480">运行情况</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                <?php if(!empty($list)):?>
                    <?php foreach ($list as $key => $value) :?>
                    <tr>
                        <td class="center">
                            <label><input type="checkbox" class="ace" /><span class="lbl"></span></label>
                        </td>
                        
                        <td title="<?php echo $value->memo; ?>">
                            <?php echo $value->name; ?><br>
                            <span style="font-style:italic"><?php echo $types[$value->type]; ?></span>
                        </td>
                        <td>
                            <?php echo MingString::str_cut($value->sql, 30); ?><br>
                            <?php echo $value->ext; ?>
                        </td>
                        <td>
                            是否有效:<strong><?php echo $value->disabled==0?'<font color=green>正常</font>':'<font color=red>禁用</font>'; ?></strong><br>
                            处理限制:<strong><?php echo $value->count==0?'无限制':$value->count; ?></strong>
                        </td>
                        <td>
                            <?php echo date('Y-m-d H:i:s', $value->created); ?><br>
                            <font color="green"><?php echo empty($value->lasttime)?'暂未执行':date('Y-m-d H:i:s', $value->lasttime); ?></font>
                        </td>
                        <td>
                            运行状态:<strong><?php echo $value->runtime==1?'<font color=green>运行中</font>':'<font color=blue>等待中</font>'; ?></strong><br>
                            成功处理条数:<strong><?php echo $value->exec_times; ?></strong>
                        </td>
                        <td>
                            <a href="<?php echo $this->createUrl('log?id=' . $item->id); ?>" title="<?php echo Yii::t('admin', 'Log'); ?>" class="btn btn-xs btn-success">
                                <i class="icon-external-link bigger-120"></i>
                            </a>
                            <a href="<?php echo $this->createUrl('edit?id=' . $item->id); ?>" title="<?php echo Yii::t('admin', 'Edit'); ?>" class="btn btn-xs btn-success">
                                <i class="icon-edit bigger-120"></i>
                            </a>
                            <a href="<?php echo $this->createUrl('delete?id=' . $item->id); ?>" title="<?php echo Yii::t('admin', 'Delete'); ?>" class="btn btn-xs btn-danger delete-confirm">
                                <i class="icon-trash bigger-120"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach;?>
                <?php endif;?>
                </tbody>
            </table>
            <?php $this->widget('application.modules.admin.widgets.BCLinkPager', array('pages' => $pager)); ?>
        </div>
        
        <div class="widget-box">
            <div class="widget-header widget-header-flat">
                <h4 class="smaller-80"><?php echo Yii::t('admin', 'TaskDefinition'); ?></h4>
            </div>
            <div class="widget-body">
                <div class="widget-main">
                    <dl id="dt-list-1">
                        <dt>Description lists</dt>
                        <dd>推送广告任务于每天6时至第二天1时5分开始执行，间隔时间为1个小时，总共执行20次，任务为单进程模式。</dd>
                        <dd>数据挖掘任务于每个小时的45分开始执行，间隔时间为1个小时，总共执行24次，任务为单进程模式。</dd>
                        <dd>若需调整，请立即联系开发人员&lt;<a href="mailto:zha_ming@163.com">一木</a>&gt;哦！</dd>
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

<?php echo CHtml::form(MingString::url($urls['log']), 'get'); ?>
<table cellpadding="0" cellspacing="1" class="table_form">
	<caption>日志搜索</caption>
	<tr>
		<td>
            任务名称：<?php echo CHtml::dropDownList('taskid', $this->_request->getQuery('taskid'), $tasks); ?>&nbsp;
            时间范围：<?php echo CHtml::textField('start', $this->_request->getQuery('start'), array('class'=>'input_blur')); ?> -
                <?php echo CHtml::textField('end', $this->_request->getQuery('end'), array('class'=>'input_blur')); ?>&nbsp;
            <?php echo CHtml::submitButton(' 搜索 ', array('class' => 'button_style')); ?>
		</td>
	</tr>
</table>
<?php echo CHtml::endForm(); ?>

<table cellpadding="0" cellspacing="1" class="table_list">
	<caption>日志列表</caption>
    <tr>
        <th id="order_taskid"><strong>任务名称</strong></th>
        <th id="order_start"><strong>开始时间</strong></th>
        <th id="order_end"><strong>结束时间</strong></th>
        <th><strong>耗费时长</strong></th>
        <th id="order_total"><strong>总影响数</strong></th>
        <th id="order_success"><strong>成功数</strong></th>
        <th><strong>失败数</strong></th>
        <th><strong>状态码</strong></th>
    </tr>

    <?php if(empty($list)){ ?>
    <tr><td colspan="8" class="align_c"><br>暂无数据<br><br></td></tr>
    <?php }else{ ?>
    <?php foreach($list as $v){ ?>
    <tr>
        <td class="align_c"><?php echo $tasks[$v['taskid']]; ?></td>
        <td class="align_c"><?php echo empty($v['start'])?'':date('Y-m-d H:i:s', $v['start']); ?></td>
        <td class="align_c"><?php echo empty($v['end'])?'':date('Y-m-d H:i:s', $v['end']); ?></td>
        <td class="align_c"><?php echo $v['interval']; ?>秒</td>
        <td class="align_c"><font color="blue"><?php echo $v['total']; ?></font></td>
        <td class="align_c"><font color="green"><?php echo $v['success']; ?></font></td>
        <td class="align_c"><font color="red"><?php echo $v['failed']; ?></font></td>
        <td class="align_c breakword">
            <?php echo $v['result']; ?>
        </td>
    </tr>
    <?php }} ?>
</table>
<div id="pages"><?php $this->widget("CLinkPager", array("pages" => $pages));?></div>

<table cellpadding="0" cellspacing="1" class="table_form">
	<caption>状态码说明</caption>
	<tr>
		<td>
            若状态码为空，说明任务设置的条件参数未能满足，或者程序出现异常。<br>
            <font color="green"><b>0</b></font> ：任务执行成功；<br>
            <font color="red"><b>1</b></font> ：任务不存在或参数设置有误；<br>
            <font color="red"><b>2</b></font> ：关键字不存在或数据获取有误；<br>
            <font color="red"><b>3</b></font> ：推送模板不存在或数据获取有误；<br>
            <font color="red"><b>4</b></font> ：推广商品URL生成失败；<br>
            <font color="red"><b>5</b></font> ：任务执行者不存在或数据获取有误；<br>
            <font color="red"><b>6</b></font> ：微博API调用出错；<br>
            <font color="red"><b>7</b></font> ：微博不存在或者搜索API条件未能满足；<br>
            <font color="red"><b>8</b></font> ：执行者账号被封（自动禁用）；<br>
            <font color="red"><b>9</b></font> ：SNS数据不存在或数据获取有误；<br>
		</td>
	</tr>
</table>

<script type="text/javascript">
$().ready(function(){
    Load.task_log();
});
</script>
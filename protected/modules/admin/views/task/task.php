<form id="taskform" method="post">
<table cellpadding="0" cellspacing="1" class="table_form">
    <caption><?php echo $this->pagename; ?></caption>
    <tr>
        <th width="30%"><strong>任务名称：</strong></th>
        <td>
            <?php echo CHtml::textField('name', isset($info['name'])?$info['name']:'', array('size' =>20, 'class'=>'input_blur')); ?>
        </td>
    </tr>
    <tr>
        <th><strong>任务类型：</strong></th>
        <td>
            <?php echo CHtml::dropDownList('type', isset($info['type'])?$info['type']:'push', $types, array('encode'=>false)); ?>
        </td>
    </tr>
    <tr>
        <th><strong>执行者：</strong><br />默认0，以相应平台的随机授权用户执行任务</th>
        <td>
            <?php echo CHtml::dropDownList('actor', isset($info['actor'])?$info['actor']:0, $appAuths, array('encode'=>false)); ?>
        </td>
    </tr>
    <tr>
        <th><strong>执行总数：</strong><br />默认0，不限次数</th>
        <td>
            <?php echo CHtml::textField('count', isset($info['count'])?$info['count']:0, array('size'=>5, 'class'=>'input_blur')); ?>
        </td>
    </tr>
    <tr>
        <th>
            <strong>参数：</strong><br>
            <font color="red">非开发人员，请勿修改</font><br><br>
            <font color="green">编辑</font><?php echo CHtml::checkBox('edit_params'); ?>
        </th>
        <td>
            <?php echo CHtml::textArea('sql', isset($info['sql'])?$info['sql']:'', array('cols'=>50, 'rows'=>5, 'disabled' => 'true')); ?>&nbsp;查询SQL<br>
            <?php echo CHtml::textField('ext', isset($info['ext'])?$info['ext']:'', array('size' =>50, 'class'=>'input_blur', 'disabled' => 'true')); ?>&nbsp;匹配参数
        </td>
    </tr>
    <tr>
        <th><strong>任务说明：</strong></th>
        <td>
            <?php echo CHtml::textArea('memo', isset($info['memo'])?$info['memo']:'', array('cols'=>50, 'rows'=>5)); ?>
        </td>
    </tr>
    <tr>
        <th><strong>是否有效：</strong></th>
        <td>
            <?php echo CHtml::radioButtonList('disabled', isset($info['disabled'])?$info['disabled']:0, $disableds, array('style'=>'height:14px')); ?>
        </td>
    </tr>
    
    <tr>
        <th></th>
        <td>
            <input type="hidden" id="id" name="id" value="<?php echo isset($info['id'])?$info['id']:0; ?>">
			<input type="submit" name="dosubmit" class="button_style" value=" 确认 ">
	    	<input type="reset" name="doreset" class="button_style" value=" 重置 ">
        </td>
    </tr>
</table>
</form>

<script type="text/javascript">
$().ready(function(){
    Load.task_task();
});
</script>
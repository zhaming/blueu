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
                        <th>消息模板</th>
                        <th style="width:12%">其他</th>
                        <th style="width:16%">
                            <i class="icon-time bigger-110 hidden-480"></i>
                            创建/执行时间
                        </th>
                        <th style="width:14%">状态</th>
                        <th style="width:14%"></th>
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
                            <span style="font-style:italic"><?php echo $value->type; ?>:<?php echo $value->item; ?></span>
                        </td>
                        <td title="<?php echo $value->msg; ?>">
                            <?php echo MingString::str_cut($value->msg, 60); ?>
                        </td>
                        <td>
                            任务类型:<strong><?php echo $value->immediately==1?'<font color=green>即时</font>':'<font color=blue>定时</font>'; ?></strong><br>
                            优先级:<strong><?php echo $value->priority; ?>级</strong>
                        </td>
                        <td>
                            <?php echo date('Y-m-d H:i:s', $value->created); ?><br>
                            <font color="green"><?php echo empty($value->lasttime)?'暂未执行':date('Y-m-d H:i:s', $value->lasttime); ?></font>
                        </td>
                        <td>
                            运行状态:<strong><?php echo $value->runtime==1?'<font color=green>运行中</font>':'<font color=blue>等待中</font>'; ?></strong><br>
                            是否有效:<strong><?php echo $value->disabled==0?'<font color=green>正常</font>':'<font color=red>禁用</font>'; ?></strong>
                        </td>
                        <td>
                            <a href="<?php echo $this->createUrl('log?id=' . $value->id); ?>" title="<?php echo Yii::t('admin', 'Log'); ?>" class="btn btn-xs btn-success">
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
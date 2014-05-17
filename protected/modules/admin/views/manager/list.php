<?php $this->widget('application.modules.admin.widgets.NavTabWidget',array('index'=>'manager'))?>


<table class='table table-bordered table-striped'>
    <tr>
        <th>姓名</th>
        <th>电话</th>
        <th>角色</th>
        <th>状态</th>
        <th>操作</th>
    </tr>
    <?php if (!empty($data['managers'])) { ?>
    <?php foreach ($data['managers'] as $manager) { ?>
        <tr>
            <td><?php echo $manager['name']; ?></td>
            <td><?php echo $manager['mobile']; ?></td>
            <td><?php echo $manager['role']; ?></td>
            <td>
                <?php if($manager['status'] == 0) { ?>
                    正常
                <?php  } else { ?>
                    禁用
                <?php } ?>
            </td>
            <td>
                <a href="/admin/manager/edit/id/<?php echo $manager['id']; ?>">更新</a>
                <?php if($manager['status'] == 0) { ?>
                    <a href="/admin/manager/disable">禁用</a>
                <?php  } else { ?>
                    <a href="/admin/manager/enable">启用</a>
                <?php } ?>
                <a href="/admin/manager/delete/id/<?php echo $manager['id']; ?>">删除</a>
            </td>
        </tr>
     <?php } ?>
    <?php } ?>
</table>

<!-- <form class="well form-inline" action="/admin/user/index" method="get">
    <p>
    <label>邮件：<input type="text" value="<?php if(!empty($filters['email'])) {echo $filters['email']; } ?>" name="filters[email]" /></label>
    <label>姓名：<input type="text" value="<?php if(!empty($filters['name'])) { echo $filters['name']; } ?>" name="filters[name]" /></label>
    <label>电话：<input type="text" value="<?php if(!empty($filters['phone'])) { echo $filters['phone']; } ?>" name="filters[phone]" /></label>
    <button class="btn" type="submit"><i class='icon-search'></i>查询</button>
    </p>
</form> -->

<table class='table table-bordered table-striped'>
    <tr>
        <th>编号</th>
        <th>名称</th>
        <th style="text-align:center;">坐标</th>
        <th>绑定商户</th>
        <th>基站描述信息</th>
        <th>操作</th>
    </tr>
    <?php if(!empty($listData)): ?>
        <?php foreach ($listData as $item): ?>
            <tr>
                <td><?php echo $item['id']; ?></td>
                <td><?php echo $item['name']; ?></td>
                <td style="text-align:center;"><?php echo empty($item['positionX'])|empty($item['positionY'])?'空':$item['positionX'].','.$item['positionY']; ?></td>
                <td>
                    <?php if (!is_null($item->merchant)): ?>
                        <?php echo $item->merchant->name; ?>
                    <?php else: ?>
                        未绑定
                    <?php endif; ?>
                </td>
                <td><?php echo $item['describ']; ?></td>
                <td>
                    <a href="<?php echo $this->createUrl('merchant/add?blueid='. $item['id']); ?>">绑定商户</a>
                    <a href="<?php echo $this->createUrl('edit?id='. $item['id']); ?>">编辑</a>
                    <a href="<?php echo $this->createUrl('delete?id='. $item['id']); ?>">删除</a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>
<?php //$this->widget('application.modules.admin.widgets.BCLinkPager', array('pages'=>$listData['pages']));?>

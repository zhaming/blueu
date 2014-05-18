<div class="page-header">
    <h1>商户管理<small><i class="icon-double-angle-right"></i>商户列表</small></h1>
</div>
<div class="row">
    <div class="col-xs-12">
        <p>
            <a href="/admin/merchant/create" class="btn btn-app btn-yellow btn-xs"><i class="icon-create bigger-120"></i>创建</a>
            <a href="/admin/merchant/delete" class="btn btn-app btn-danger btn-xs"><i class="icon-remove bigger-120"></i>删除</a>
        </p>
        <div class="table-responsive">
            <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="center">
                            <label>
                                <input type="checkbox" class="ace" />
                                <span class="lbl"></span>
                            </label>
                        </th>
                        <th>编号</th>
                        <th>名称</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <?php if (!empty($data)) { foreach ($data as $item) { ?>
                        <td class="center">
                            <label>
                                <input type="checkbox" class="ace" />
                                <span class="lbl"></span>
                            </label>
                        </td>
                        <td><?php echo $item->id; ?></td>
                        <td><?php echo $item->name; ?></td>
                        <td>
                            <a href="/admin/merchant/activity?id=<?php echo $item->id; ?>" title="活动" class="btn btn-xs btn-info">
                                <i class="icon-coffee bigger-120"></i>
                            </a>
                            <a href="/admin/merchant/stations?id=<?php echo $item->id; ?>" title="基站" class="btn btn-xs btn-yellow">
                                <i class="icon-signal bigger-120"></i>
                            </a>
                            <a href="/admin/merchant/mermber?id=<?php echo $item->id; ?>" title="会员" class="btn btn-xs btn-success">
                                <i class="icon-user bigger-120"></i>
                            </a>
                            <a href="/admin/merchant/edit?id=<?php echo $item->id; ?>" title="编辑" class="btn btn-xs btn-grey">
                                <i class="icon-edit bigger-120"></i>
                            </a>
                            <a href="" title="删除" class="btn btn-xs btn-danger">
                                <i class="icon-trash bigger-120"></i>
                            </a>
                        </td>
                    </tr>
                    <?php }} ?>
                </tbody>
            </table>
            <?php $this->widget('application.modules.admin.widgets.BCLinkPager', array('pages' => $pager)); ?>
        </div>
    </div>
</div>

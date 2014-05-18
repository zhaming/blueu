<div class="page-header">
    <h1>用户管理<small><i class="icon-double-angle-right"></i>列表</small></h1>
</div>
<div class="row">
    <div class="col-xs-12">
        <p>
            <a href="/admin/user/create" class="btn btn-app btn-yellow btn-xs"><i class="icon-create bigger-120"></i>创建</a>
            <a href="/admin/user/delete" class="btn btn-app btn-danger btn-xs"><i class="icon-remove bigger-120"></i>删除</a>
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
                        <th>状态</th>
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
                        <td><?php if ($item->account->status == 0) { ?>正常<?php } ?><?php if ($item->account->status == 1) { ?>禁用<?php } ?></td>
                        <td>
                            <div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
                                <?php if ($item->account->status == 1) { ?>
                                <a href="<?php echo $this->createUrl('enable?id=' . $item->id); ?>" class="btn btn-xs btn-success">
                                    <i class="icon-unlock bigger-120"></i>
                                </a>
                                <?php } else { ?>
                                <a href="<?php echo $this->createUrl('disable?id=' . $item->id); ?>" class="btn btn-xs btn-warning">
                                    <i class="icon-lock bigger-120"></i>
                                </a>
                                <?php } ?>
                                <a href="<?php echo $this->createUrl('delete?id=' . $item->id); ?>" class="btn btn-xs btn-danger">
                                    <i class="icon-trash bigger-120"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php }} ?>
                </tbody>
            </table>
            <?php $this->widget('application.modules.admin.widgets.BCLinkPager', array('pages' => $pager)); ?>
        </div>
    </div>
</div>
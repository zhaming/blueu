<div class="page-header">
    <h1>
        <?php echo Yii::t('admin', 'Merchant shop_manager');?> 
        <small><i class="icon-double-angle-right"></i>商铺列表</small>
    </h1>
</div>
<div class="row">
    <div class="col-xs-12">
        <p>
            <a href="/admin/merchantshop/create" class="btn btn-app btn-yellow btn-xs"><i class="icon-create bigger-120"></i>创建</a>
            <a href="/admin/merchantshop/delete" class="btn btn-app btn-danger btn-xs"><i class="icon-remove bigger-120"></i>删除</a>
        </p>
        <?php $this->widget("AlterMsgWidget")?>
        <div class="table-responsive">
            <form  action="#" method="get" class="well form-inline">
                <label class="inline">
                    商铺名：
                    <input type="text" name="name" value="<?php echo !empty($name)?$name:'' ;?>" />
                </label>
                <label class="inline ">
                    <input name="isonly" type="checkbox" class="ace" value="1" <?php echo !empty($isonly)?"checked":'' ;?>>
                    <span class="lbl"> 独家</span>
                </label>
                <label class="inline" >
                    <button type="submit" class="btn btn-xs btn-info">
                        <i class="icon-search"></i> 查询
                    </button>
                </label>
            </form>
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
                    </tr>
                </tbody>
            </table>
            <?php $this->widget('application.modules.admin.widgets.BCLinkPager', array('pages' => $pager)); ?>
        </div>
    </div>
</div>
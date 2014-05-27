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
        </p>
        <?php $this->widget("AlterMsgWidget")?>
        <div class="table-responsive">
            <form  action="/admin/merchantshop/index" method="get" class="well form-inline">
                <label class="inline">
                    商铺名：
                    <input type="text" name="name" value="<?php echo !empty($name)?$name:'' ;?>" />&emsp;
                </label>
                <label class="inline">
                    店主名：
                    <input type="text" name="owner" value="<?php echo !empty($owner)?$owner:'' ;?>" />&emsp;
                </label>
                <label class="inline ">
                    <input name="isonly" type="checkbox" class="ace" value="1" <?php echo !empty($isonly)?"checked":'' ;?>>
                    <span class="lbl"> 独家&emsp;</span>
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
                        <th>编号</th>
                        <th>店铺名</th>
                        <th>店主</th>
                        <th>联系电话</th>
                        <th>地址</th>
                        <th>是否总店</th>
                        <th>是否独家</th>
                        <th>操作</th>
                    </tr>
                </thead>

                <tbody>
                <?php if(!empty($data)):?>
                    <?php foreach ($data as $key => $value) :?>
                    <tr>
                        <td><?php echo $value->id?></td>
                        <td><?php echo $value->name?></td>
                        <td><?php echo $value->owner?></td>
                        <td><?php echo $value->telephone?></td>
                        <td><?php echo $value->address;?></td>
                        <td><?php echo $value->ismain ==1?"Y":"N";?></td>
                        <td><?php echo $value->isonly ==1?"Y":"N";?></td>
                        <td>
                            <a href="/admin/merchantshop/delete/id/<?php echo $value->id;?>"><i class="icon-remove red"></i>删除</a>
                            <a href="/admin/merchantshop/edit/id/<?php echo $value->id;?>"><i class="icon-edit"></i>详情</a>
                            <?php if(empty($value->selfid)): ?>
                            <a href="/admin/merchantshop/addshopaccount/id/<?php echo $value->id;?>"><i class="icon-plus"></i>开通分店账户</a>
                            <?php endif;?>
                        </td>
                    </tr>
                    <?php endforeach;?>
                <?php endif;?>
                </tbody>
            </table>
            <?php $this->widget('application.modules.admin.widgets.BCLinkPager', array('pages' => $pager)); ?>
        </div>
    </div>
</div>
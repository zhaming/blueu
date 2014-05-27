<div class="page-header">
    <h1>
        <?php echo Yii::t('admin', 'Merchant shop_manager');?>
        <small><i class="icon-double-angle-right"></i>商列表</small>
    </h1>
</div>
<div class="row">
    <div class="col-xs-12">
        <p>
            <a href="/admin/merchantproduct/create" class="btn btn-app btn-yellow btn-xs"><i class="icon-create bigger-120"></i>添加</a>
        </p>
        <?php $this->widget("AlterMsgWidget")?>
        <div class="table-responsive">
            <form  action="/admin/merchantproduct/index" method="get" class="well form-inline">
                <label class="inline">
                    商品名：
                    <input type="text" name="name" value="<?php echo !empty($name)?$name:'' ;?>" />&emsp;
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
                        <th width="45px" >编号</th>
                        <th>商品名</th>
                        <th>简介</th>
                        <th>价格</th>
                        <th>折扣</th>
                        <th>适用店铺</th>
                        <th>发布人</th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr>
                </thead>

                <tbody>
                <?php if(!empty($data)):?>
                    <?php foreach ($data as $key => $value) :?>
                    <tr>
                        <td width="45px"  class="center"><?php echo $value->id?></td>
                        <td><?php echo $value->name?></td>
                        <td><?php echo $value->intro?></td>
                        <td><?php echo $value->price?></td>
                        <td><?php echo $value->discount?></td>
                        <td><?php if(!empty($value->shop_product)):?>
                            <?php foreach ($value->shop_product as $k => $v) :?>
                                <?php  echo empty($v->shop)?"":$v->shop->name;?>&emsp;
                            <?php endforeach;?>
                            <?php endif;?>
                        </td>
                        <td><?php echo !empty($value->merchant)?$value->merchant->name:"";?></td>
                        <td><?php echo $value->status?></td>
                        <td>
                            <a href="/admin/merchantproduct/edit/id/<?php echo $value->id;?>" >编辑</a>
                            <a href="/admin/merchantproduct/delete/id/<?php echo $value->id;?>" >删除</a>
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
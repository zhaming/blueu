<div class="page-header">
    <h1>
        <?php echo Yii::t('shop', 'Coupon Manager');?>
        <small><i class="icon-double-angle-right"></i><?php echo Yii::t('shop', 'Coupon use');?></small>
    </h1>
</div>
<div class="row">
    <div class="col-xs-12">
        <?php $this->widget("AlterMsgWidget")?>
        <div class="table-responsive">
            <form  action="/admin/merchantcoupon/validatecoupon" method="get" class="well form-inline">
                <label class="inline">
                   <?php echo Yii::t('shop',"Coupon Code")?>：
                    <input type="text" name="code" value="<?php echo !empty($code)?$code:'' ;?>" />&emsp;
                </label>
                <label class="inline">
                   <?php echo Yii::t('admin',"Username")?>：
                    <input type="text" name="name" value="<?php echo !empty($name)?$name:'' ;?>" />&emsp;
                </label>
                <label class="inline">
                    <button type="submit" class="btn btn-xs btn-info">
                        <i class="icon-search"></i><?php echo Yii::t('comment', 'Select');?>
                    </button>
                </label>
            </form>
            <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th><?php echo Yii::t("shop","Coupon Name");?></th>
                        <th><?php echo Yii::t("comment","Price");?></th>
                        <th><?php echo Yii::t("shop","Coupon validity start");?></th>
                        <th><?php echo Yii::t("shop","Coupon validity end");?></th>
                        <th><?php echo Yii::t("shop","Is in validity");?></th>
                        <th><?php echo Yii::t("admin","Username");?></th>
                        <th><?php echo Yii::t("comment","Operate");?></th>
                    </tr>
                </thead>

                <tbody>
                <?php if(!empty($data)):?>
                    <?php foreach ($data as $key => $value) :?>
                    <tr>
                        <td><?php echo $value['name']?></td>
                        <td><?php echo $value['price']?></td>
                        <td><?php echo empty($value['validity_start'])?"":date("Y-m-d",$value['validity_start']);?></td>
                        <td><?php echo empty($value['validity_end'])?"":date("Y-m-d",$value['validity_end']);?></td>
                        <td>
                            <?php
                                $flag = true;
                                $now = strtotime(date("Y-m-d",time())); 
                                if($now > $value['validity_end']  || $now < $value['validity_start']){
                                    echo "<span style='color:red'>".Yii::t("shop","Not in validity")."</span>";
                                    $flag = false;
                                }else{
                                    echo Yii::t("shop","In validity");
                                }
                            ?>
                         </td>
                        <td><?php echo $value['username']?></td>
                        <td>
                        <?php if($flag):?>
                            <a href="/admin/merchantcoupon/usecoupon/uid/<?php echo $value['uid']?>/cid/<?php echo $value['id']?>"> 确定使用  </a>
                        <?php else:?>
                            <?php echo Yii::t("shop","Coupons expired");?>
                        <?php endif;?>
                        </td>
                    </tr>
                    <?php endforeach;?>
                <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
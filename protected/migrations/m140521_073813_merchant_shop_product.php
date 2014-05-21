<?php

class m140521_073813_merchant_shop_product extends CDbMigration
{
	public function up()
	{
		$options = "ENGINE=MyISAM DEFAULT COLLATE='utf8_general_ci' CHARSET=utf8";

        $rules = array(
            'shopid' => "int(11) not null" ,
            'productid' => "int(11) not null ",
            'UNIQUE INDEX'=> "'shopid_productid' ('shopid', 'productid')"
        );
        $this->createTable('{{merchant_shop_product}}', $rules, $options . "店铺-商品关联表");
	}

	public function down()
	{
		echo "m140521_073813_merchant_shop_product does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}
<?php

class m140324_012813_init extends CDbMigration
{
    public function up()
    {
        $options = "ENGINE=MyISAM DEFAULT COLLATE='utf8_general_ci' CHARSET=utf8";

        /**
         * BlueSations（蓝牙基站信息）
         * 字段  数据类型    注释
         * Id（PK）  CHAR(10)    
         * name    VARCHAR(32) 
         * describ VARCHAR(32) 基站描述信息
         */
        $rules = array(
            'id' => "varchar(10)",
            'name' => "varchar(32)",
            'describ' => "varchar(32)",
        );
        $this->createTable('{{blue_stations}}', $rules, $options . " COMMENT='蓝牙基站信息'");

        /**
         * Merchant （商户信息）
         * 字段  数据类型    注释
         * Id（PK）  CHAR(10)    
         * name    VARCHAR(32) 
         * describ VARCHAR(32) 商户描述信息
         * pic VARCHAR(32) 图片地址信息（demo实现方式为图片地址写死，直接根据地址获得图片返回给手机客户端）
         * blueid  CHAR(10)    基站外键
         */
        $rules = array(
            'id' => "varchar(10)",
            'name' => "varchar(32)",
            'describ' => "varchar(32)",
            'pic' => "varchar(32)",
            'blueid' => "varchar(10)",
        );
        $this->createTable('{{merchant}}', $rules, $options . " COMMENT='商户信息'");

        /**
         * User （用户信息）
         * 字段  数据类型    注释
         * id  CHAR(10)    
         * name    VARCHAR(32) 
         * blueid  CHAR(10)    基站外键
        */
        $rules = array(
            'id' => "varchar(10)",
            'name' => "varchar(32)",
            'blueid' => "varchar(10)",
        );
        $this->createTable('{{user}}', $rules, $options . " COMMENT='用户信息'");

        /**
         * Advertisement （广告信息）
         * 字段  数据类型    注释
         * id  CHAR(10)    
         * name    VARCHAR(32) 
         * merid   CHAR(10)    商户外键
         * pic VARCHAR(32) 图片地址信息（demo实现方式为图片地址写死，直接根据地址获得图片返回给手机客户端）
        */
        $rules = array(
            'id' => "varchar(10)",
            'name' => "varchar(32)",
            'merid' => "varchar(10)",
            'pic' => "varchar(32)",
        );
        $this->createTable('{{advertisement}}', $rules, $options . " COMMENT='广告信息'");
    }

    public function down()
    {
        echo "m140324_012813_init does not support migration down.\n";
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

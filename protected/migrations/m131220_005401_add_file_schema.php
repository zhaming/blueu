<?php

class m131220_005401_add_file_schema extends CDbMigration
{
    public function up()
    {
        $options = "ENGINE=MyISAM DEFAULT COLLATE='utf8_general_ci' CHARSET=utf8";

        $files = array(
            'id'             => "pk",
            'file_name'      => "VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '原文件名称'",
            'file_type'      => "VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '文件类型'",
            'file_size'      => "BIGINT(20) NULL DEFAULT NULL COMMENT '文件大小'",
            'file_extension' => "VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT '文件扩展名'",
            'ctime'          => "INT(11) NULL DEFAULT NULL COMMENT '创建时间'",
            'hash_code'      => "VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'MD5值'",
            'is_deleted'     => "TINYINT(1) NULL DEFAULT '0' COMMENT '是否删除，0：正常 1：删除'",
        );
        $this->createTable('{{files}}', $files, $options . " COMMENT='文件资源表'");
    }

    public function down()
    {
        $result = false;
        $transaction = $this->getDbConnection()->beginTransaction();
        try {
            $this->renameTable('{{files}}', '{{files_backup}}');
            $transaction->commit();
            $result = true;
        } catch (Exception $e) {
            echo "Exception: " . $e->getMessage()."\n";
            $transaction->rollback();
        }
        return $result;
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

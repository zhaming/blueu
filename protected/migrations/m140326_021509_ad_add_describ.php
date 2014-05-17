<?php

class m140326_021509_ad_add_describ extends CDbMigration
{
    public function up()
    {
        $this->addColumn('{{advertisement}}', 'describ', "TEXT");
    }

    public function down()
    {
        echo "m140326_021509_ad_add_describ does not support migration down.\n";
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

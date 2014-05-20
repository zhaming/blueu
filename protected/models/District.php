<?php
/**
 * 商圈model
 */
class District extends CActiveRecord {
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{district}}';
    }
}
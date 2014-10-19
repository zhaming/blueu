<?php

class Config extends CActiveRecord {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{config}}';
    }

    public function behaviors() {
        return array(
            'ConfigBehavior' => array(
                'class' => 'application.behaviors.ConfigBehavior',
                'enable' => false
            )
        );
    }

}

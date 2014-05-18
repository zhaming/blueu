<?php

class Account extends CActiveRecord {

    public $id;
    public $username;
    public $password;
    public $type;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{account}}';
    }

    public function primaryKey() {
        return "id";
    }

    public function relations() {
        $relations = array(
            'user' => array(
                self::HAS_ONE, 'User', 'id'
            ),
        );
        return $relations;
    }

    public function changePass($id, $oldpwd, $newPwd) {
        return true;
    }

    public function managers() {
        return $this->findByAttributes(array('type' => 0));
    }

}


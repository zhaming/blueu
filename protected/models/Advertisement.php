<?php
class Advertisement extends CActiveRecord
{
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return '{{advertisement}}';
    }

    public function primaryKey()
    {
        return "id";
    }

    public function relations()
    {
        $relations = array(
            'merchant'=>array(
                self::BELONGS_TO, 'Merchant', array('merid'=>'id'), 'with'=>'station'
                ),
            );
        return $relations;
    }
}














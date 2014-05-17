<?php
class Merchant extends CActiveRecord
{
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return '{{merchant}}';
    }

    public function primaryKey()
    {
        return "id";
    }

    public function relations()
    {
        $relations = array(
            'station'=>array(
                self::HAS_MANY, 'BlueStation', array('id'=>'blueid')
                ),
            );
        return $relations;
    }
}














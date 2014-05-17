<?php
class BlueStation extends CActiveRecord
{
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return '{{blue_stations}}';
    }

    public function primaryKey()
    {
        return "id";
    }

    public function relations()
    {
        $relations = array(
            'merchant'=>array(
                self::HAS_ONE, 'Merchant', 'blueid'
                ),
            );
        return $relations;
    }
}














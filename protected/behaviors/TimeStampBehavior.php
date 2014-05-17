<?php

class TimeStampBehavior extends CActiveRecordBehavior
{
    public $column_create = 'ctime';
    public $column_modify = 'mtime';
    public $column_access = 'atime';

    public function beforeSave($event)
    {
        //$schema = $this->getOwner()->getTableSchema();
        //print_r(array_keys($schema->columns));
        if ($this->getOwner()->getIsNewRecord()) {
            $this->getOwner()->{$this->column_create} = time();
        }
        $this->getOwner()->{$this->column_modify} = time();
    }
}
?>

<?php
/**
 *	任务表单
 *	@author		zham <zha_ming@163.com>
 *	@copyright	2014-2016
 *	@version	1.0
 *	@package	MING
 *
 *	$Id$
 */

class TaskForm extends BaseForm {
    
    public $id;
    public $name;
    public $type;
    public $item;
    public $immediately;
    public $msg;
    public $sql;
    public $ext;
    public $memo;
    public $priority;
    

    public function rules() {
        return array(
            array('name,type,item,immediately,priority,msg', 'required'),
            array('item', 'checkTaskOnly'),
            array('sql,ext,memo', 'safe')
        );
    }

    public function beforeValidate() {
        parent::beforeValidate();
        return true;
    }

    public function attributeLabels() {
        return array(
            'name' => Yii::t('admin', 'VTaskName'),
            'type' => Yii::t('admin', 'VTaskType'),
            'msg' => Yii::t('admin', 'VTaskMsg'),
            'sql' => Yii::t('admin', 'VTaskParam'),
            'memo' => Yii::t('admin', 'VTaskMemo'),
        );
    }

    public function checkTaskOnly() {
        /*$_task = new TaskBehavior();
        if ($_task->isExist($this->type, $this->item)) {
            $this->addError('item', Yii::t('admin', 'VTaskExist'));
        }*/
    }
}
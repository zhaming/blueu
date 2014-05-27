<?php
/**
 *	任务日志表模型
 *	@author		zham <zha_ming@163.com>
 *	@copyright	2014-2016
 *	@version	1.0
 *	@package	MING
 *
 *	$Id$
 */

class TaskLog extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function tableName()
	{
		return '{{task_log}}';
	}
    
    public function primaryKey()
    {
        return 'id';
    }
    
    public function getInterval()
    {
        if(empty($this->end) || empty($this->start)) return 0;
        return $this->end - $this->start;
    }
    
    public function getFailed()
    {
        if(empty($this->total) && empty($this->success)) return 0;
        return max($this->total - $this->success, 0);
    }
}
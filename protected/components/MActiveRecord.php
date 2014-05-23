<?php
/**
 *	多数据库AR
 *  数据库配置例子：
 *  'db' => array(
 *      ...
 *   ),
 *  'test' => array(
 *      'class' => 'CDbConnection',
 *      ...
 *   ),
 *  model例子：
 *  class test extends MActiveRecord
 *  {
 *      $dbname = 'test';
 *      ...
 * 
 *	@author		zham <zha_ming@163.com>
 *	@copyright	2012-2013
 *	@version	1.0
 *	@package	MING
 *
 *	$Id$
 */

class MActiveRecord extends CActiveRecord
{
    static $database = array();
    public $dbname = 'db';
    public function __construct($scenario='insert', $dbname='')
	{
		if(!empty($dbname)) $this->dbname = $dbname;
        parent::__construct($scenario);
	}
    
    public function getDbConnection()
	{
        $dbname = $this->dbname;
		if(self::$database[$dbname]!==null)
			return self::$database[$dbname];
		else
		{
            if($this->dbname == 'db')
                self::$database[$dbname] = Yii::app()->getDb();
			else
                self::$database[$dbname] = Yii::app()->$dbname;
			if(self::$database[$dbname] instanceof CDbConnection)
            {
                self::$database[$dbname]->setActive(true);
				return self::$database[$dbname];
            }
			else
				throw new CDbException(Yii::t('yii','Active Record requires a "db" CDbConnection application component.'));
		}
	}
}
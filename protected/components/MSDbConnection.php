<?php
/**
 *	主从库DbConnection
 *	@author		zham <zha_ming@163.com>
 *	@copyright	2012-2013
 *	@version	1.0
 *	@package	MING
 *
 *	$Id$
 */

class MSDbConnection extends CDbConnection
{
    public $slaveConfig  = array();
    
    private $_attributes = array();
	private $_active = false;
	private $_pdo;
	private $_transaction;
	private $_schema;
    private $_pdoMaster = null;
    private $_pdoSlave = null;
    
    public function __construct($dsn='',$username='',$password='',$slaveConfig=array())
	{
		$this->connectionString=$dsn;
		$this->username=$username;
		$this->password=$password;
        //设置从数据库配置
        $this->slaveConfig = $slaveConfig;
	}
    
    public function setSlaveConfig($value)
    {
        $this->slaveConfig = $value;
    }
    
    public function getActive()
	{
		return $this->_active;
	}
    
    public function setActive($value)
    {
        //改在getPdoInstance方法中创建，即按需创建
        unset($value);
        $this->_active = true;
    }
    
    protected function open($connectionString='',$username='',$password='')
	{
        //默认使用主库
        $connectionString = empty($connectionString) ? $this->connectionString : $connectionString;
        $username = empty($username) ? $this->username : $username;
        $password = empty($password) ? $this->password : $password;
        
        if(empty($this->connectionString))
            throw new CDbException(Yii::t('yii','CDbConnection.connectionString cannot be empty.'));
        $pdo = null;
        try
        {
            Yii::trace('Opening DB connection','system.db.CDbConnection');
            $pdo=$this->createPdoInstance();
            $this->initConnection($pdo);
        }
        catch(PDOException $e)
        {
            if(YII_DEBUG)
            {
                throw new CDbException(Yii::t('yii','CDbConnection failed to open the DB connection: {error}',
                    array('{error}'=>$e->getMessage())),(int)$e->getCode(),$e->errorInfo);
            }
            else
            {
                Yii::log($e->getMessage(),CLogger::LEVEL_ERROR,'exception.CDbException');
                throw new CDbException(Yii::t('yii','CDbConnection failed to open the DB connection.'),(int)$e->getCode(),$e->errorInfo);
            }
        }
        return $pdo;
	}
    
    protected function close()
	{
		Yii::trace('Closing DB connection','system.db.CDbConnection');
		$this->_pdo=null;
		$this->_active=false;
		$this->_schema=null;
        
        //删除主从库链接
        $this->_pdoMaster = null;
        $this->_pdoSlave = null;
	}
    
    public function getPdoInstance($useSlave = false)
	{
        //当且仅当从库存在和非事务操作时，使用从库
        if($useSlave && !empty($this->slaveConfig) && (!$this->_transaction || !$this->_transaction->getActive()))
        {
            if(!empty($this->_pdoSlave))
                $this->_pdo = $this->_pdoSlave;
            else
            {
                $randIndex = array_rand($this->slaveConfig);
                extract($this->slaveConfig[$randIndex]);
                $this->_pdoSlave = $this->open($connectionString, $username, $password);
                if(!empty($this->_pdoSlave))
                    $this->_pdo = $this->_pdoSlave;
                else
                {
                    if(!empty($this->_pdoMaster))
                        $this->_pdo = $this->_pdoMaster;
                    else
                        $this->_pdo = $this->_pdoMaster = $this->open();
                }    
            }
        }
        else
        {
            if(!empty($this->_pdoMaster))
                $this->_pdo = $this->_pdoMaster;
            else
                $this->_pdo = $this->_pdoMaster = $this->open();
        }
		return $this->_pdo;
	}
    
    public function createCommand($query=null)
	{
        //通过DbCommand类获取SQL读写状态
        if($this->getActive())
        {
            return new MSDbCommand($this, $query);
        }
        else
            throw new CDbException(Yii::t('yii','CDbConnection is inactive and cannot perform any DB operations.'));
	}
    
    public function beginTransaction()
	{
        if($this->getActive())
        {
            //将当前pdo链接设置为主库
            $this->_pdo = $this->getPdoInstance();
            if(!empty($this->_pdo))
            {
                $this->_pdo->beginTransaction();
                return $this->_transaction = new CDbTransaction($this);
            }
            else
                throw new CDbException(Yii::t('yii','CDbConnection is inactive and cannot perform any DB operations.'));
        }
        else
            throw new CDbException(Yii::t('yii','CDbConnection is inactive and cannot perform any DB operations.'));
	}
    
    public function getLastInsertID($sequenceName='')
	{
        //必须使用主库链接
		if($this->getActive() && !empty($this->_pdoMaster))
            return $this->_pdoMaster->lastInsertId($sequenceName);
        else
            throw new CDbException(Yii::t('yii','CDbConnection is inactive and cannot perform any DB operations.'));
	}
    
    public function quoteValue($str)
	{
        if(is_int($str) || is_float($str))
			return $str;
        
        if($this->getActive())
        {
            //若当前链接不存在，则创建从库链接
            if(empty($this->_pdo))
                $this->_pdo = $this->getPdoInstance (true);
            if(empty($this->_pdo))
                throw new CDbException(Yii::t('yii','CDbConnection is inactive and cannot perform any DB operations.'));
            
            if(($value = $this->_pdo->quote($str)) !== false)
                return $value;
            else  // the driver doesn't support quote (e.g. oci)
                return "'" . addcslashes(str_replace("'", "''", $str), "\000\n\r\\\032") . "'";
        }
        else
            throw new CDbException(Yii::t('yii','CDbConnection is inactive and cannot perform any DB operations.'));
	}
    
    public function getAttribute($name)
	{
        if($this->getActive())
        {
            //若当前链接不存在，则创建从库链接
            if(empty($this->_pdo))
                $this->_pdo = $this->getPdoInstance (true);
            if(empty($this->_pdo))
                throw new CDbException(Yii::t('yii','CDbConnection is inactive and cannot perform any DB operations.'));
            
            return $this->_pdo->getAttribute($name);
        }
        else
            throw new CDbException(Yii::t('yii','CDbConnection is inactive and cannot perform any DB operations.'));
	}
    
    public function setAttribute($name,$value)
	{
		if($this->_pdo instanceof PDO)
			$this->_pdo->setAttribute($name,$value);
		//主从库切换，属性重新设置
		$this->_attributes[$name]=$value;
	}
}
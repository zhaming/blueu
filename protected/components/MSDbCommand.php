<?php
/**
 *	主从库DbCommand
 *	@author		zham <zha_ming@163.com>
 *	@copyright	2012-2013
 *	@version	1.0
 *	@package	MING
 *
 *	$Id$
 */

class MSDbCommand extends CDbCommand
{
    public function prepare()
	{
		if($this->_statement==null)
		{
			try
			{
                $useSlave = $this->isReadSql($this->getText());
				$this->_statement=$this->getConnection()->getPdoInstance($useSlave)->prepare($this->getText());
				$this->_paramLog=array();
			}
			catch(Exception $e)
			{
				Yii::log('Error in preparing SQL: '.$this->getText(),CLogger::LEVEL_ERROR,'system.db.CDbCommand');
                $errorInfo = $e instanceof PDOException ? $e->errorInfo : null;
				throw new CDbException(Yii::t('yii','CDbCommand failed to prepare the SQL statement: {error}',
					array('{error}'=>$e->getMessage())),(int)$e->getCode(),$errorInfo);
			}
		}
	}
    
    /**
     * 判断SQL语句是否为读取语句
     * @staticvar array $readSqlPrefix
     * @param string $query
     * @return boolean 
     */
    private function isReadSql($query)
    {
        static $readSqlPrefix = array('SHOW', 'SELECT', 'DESCRIBE', 'DESC');
        $query = ltrim($query);
        if(empty($query)) return false;
        
        foreach($readSqlPrefix as $prefix)
        {
            $subStr = substr($query, 0, strlen($prefix) + 1);
            $subStr = strtoupper(rtrim($subStr));
            if($subStr == $prefix) return true;
        }
        return false;
    }
}
<?php
/**
 *	统计
 *	@author		zham <zha_ming@163.com>
 *	@copyright	2014-2016
 *	@version	1.0
 *	@package	
 *
 *	$Id$
 */

class StatBehavior extends BaseBehavior {
    
    
    /**
     * 获取注册用户统计数据
     * @param string $type
     * @param integer $limit
     * @return mixed
     */
    public function getUserRegistered($type, $limit)
    {
        $criteria = new CDbCriteria();
        $criteria->select = 'statdate,count';
        $criteria->addCondition("type = '$type'");
        $criteria->order = 'statdate DESC';
        $criteria->limit = $limit;
        return StatRegistered::model()->findAll($criteria);
    }
    
    /**
     * 获取用户性别年代统计数据
     * @param string $type
     * @return mixed
     */
    public function getUserSexAndCentury($type)
    {
        $criteria = new CDbCriteria();
        $criteria->select = 'item,count';
        $criteria->addCondition("type = '$type'");
        return StatUser::model()->findAll($criteria);
    }
    
    /**
     * 获取用户转化数据
     * @return mixed
     */
    public function getUserConvert()
    {
        $criteria = new CDbCriteria();
        $criteria->select = 'item,count';
        $criteria->order = 'count ASC';
        return StatTransform::model()->findAll($criteria);
    }
    
    /**
     * 获取用户分享数据
     * @return mixed
     */
    public function getUserShare()
    {
        $criteria = new CDbCriteria();
        $criteria->select = 'century,sex,count';
        $criteria->order = "FIELD(`century`,'00','90','80','70','other')";
        return StatShareUser::model()->findAll($criteria);
    }
    
    /**
     * 获取用户分享排行榜
     * @param int $source
     * @return mixed
     */
    public function getUserShareContent($source)
    {
        $criteria = new CDbCriteria();
        $criteria->addCondition("source = $source");
        $criteria->order = 'count DESC';
        return StatShareContent::model()->findAll($criteria);
    }
}
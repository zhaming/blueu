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
     * @param int $order
     * @param int $page
     * @return mixed
     */
    public function getUserShareContent($source, $page, $limit)
    {
        $criteria = new CDbCriteria();
        $criteria->addCondition("source = $source");
        $criteria->order = 'count DESC';
        
        if(empty($page)) $page = 1;
        $pageSize = $limit;
        $criteria->offset = $pageSize * ($page -1);
        $criteria->limit = $pageSize;
        
        $count = StatShareContent::model()->count($criteria);
        $rows = StatShareContent::model()->findAll($criteria);
        
        $pages = new CPagination($count);
        $pages->pageSize = $pageSize;
        $pages->applyLimit($criteria);
        
        $result = array(
            'list' => $rows,
            'pages' => $pages,
        );
        return $result;
    }
    
    /**
     * 获取整体统计数据
     * @param string $type
     * @param string $item
     * @param integer $limit
     * @return mixed
     */
    public function getIndustryTotal($type, $item, $limit)
    {
        $criteria = new CDbCriteria();
        $criteria->select = 'item,statdate,count';
        $criteria->addCondition("type = '$type'");
        $criteria->addCondition("item = '$item'");
        $criteria->order = 'statdate DESC';
        $criteria->limit = $limit;
        return StatTotal::model()->findAll($criteria);
    }
    
    /**
     * 获取热门行业统计数据
     * @param int $limit
     * @return mixed
     */
    public function getIndustryTop($limit)
    {
        $criteria = new CDbCriteria();
        $criteria->select = 'catid,sum(hot) as hot';
        $criteria->group = 'catid';
        $criteria->order = 'hot DESC';
        $criteria->limit = $limit;
        $rs = StatHot::model()->findAll($criteria);
        $_cat = new CategoryBehavior();
        foreach($rs as $k => $v){
            $names = $_cat->getNameById($v->catid, true);
            $v->name = implode('->', $names);
            $rs[$k] = $v;
        }
        return $rs;
    }
    
    /**
     * 获取热门商铺统计数据
     * @param int $limit
     * @return mixed
     */
    public function getIndustryShopTop($limit)
    {
        $criteria = new CDbCriteria();
        $criteria->order = 'hot DESC';
        $criteria->limit = $limit;
        $result = StatHot::model()->findAll($criteria);
        return $result;
    }
}
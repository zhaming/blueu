<?php

/*
 * 完成地图定位相关业务逻辑
 */

/**
 * 2014-5-20 15:00:00 UTF-8
 * @package application.behaviors
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * MapBehavior.php hugb
 *
 */
class MapBehavior extends BaseBehavior {

    public function getList() {
        $criteria = new CDbCriteria();
        $criteria->addCondition('disabled=0');
        $criteria->order = 'created desc';
        $count = Advertisement::model()->count($criteria);

        $pager = new CPagination($count);
        $pager->setPageSize(self::DEFAULT_PAGE_SIZE);
        $pager->applyLimit($criteria);

        $data = Map::model()->findAll($criteria);
        return array('pager' => $pager, 'data' => $data);
    }
    
    public function disable($id) {
        return Map::model()->updateByPk($id, array("disabled" => 1));
    }

    public function enable($id) {
        return Map::model()->updateByPk($id, array("disabled" => 0));
    }

    /**
     * 上传地图
     * @param array $data
     * @return boolean
     */
    public function upload($data) {
        $fileBehavior = new FileBehavior();
        if (!$fileBehavior->isHaveUploadFile()) {
            $this->error = Yii::t('admin', 'Please upload picture.');
            return false;
        }
        $file = $fileBehavior->saveUploadMap();
        if (!$file) {
            $this->error = Yii::t('admin', 'Save picture failure.');
            return false;
        }
        $map = new Map();
        $map->name = $data['name'];
        $map->marketplace = $data['marketplace'];
        $map->floor = $data['floor'];
        $map->map = $file['path'];
        $map->disabled = HelpTemplate::ENABLED;
        $map->created = time();
        return $map->save();
    }

}
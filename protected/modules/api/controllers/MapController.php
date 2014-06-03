<?php

/*
 * 地图API
 */

/**
 * 2014-5-20 14:58:43 UTF-8
 * @package application.modeules.api.controllers
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * MapController.php hugb
 *
 */
class MapController extends IController {

    protected $mapBehavior;

    public function init() {
        parent::init();
        $this->mapBehavior = new MapBehavior();
    }

    public function actionDetail() {
        if (!Yii::app()->request->getIsPostRequest()) {
            $this->error_code = self::ERROR_REQUEST_METHOD;
            $this->message = Yii::t('api', 'Please use POST method to submit data.');
            return;
        }
        $data = $this->getJsonFormData();
        if (!isset($data['marketplace'])) {
            $this->error_code = self::ERROR_REQUEST_PARAMS;
            $this->message = 'marketplace' . Yii::t('api', ' is not set.');
            return;
        }
        if (!isset($data['floor'])) {
            $this->error_code = self::ERROR_REQUEST_PARAMS;
            $this->message = 'floor' . Yii::t('api', ' is not set.');
            return;
        }
        $map = $this->mapBehavior->getApiDetail($data['marketplace'], $data['floor']);
        if (empty($map)) {
            $this->error_code = self::ERROR_REQUEST_FAILURE;
            $this->message = Yii::t('api', 'Map is not exist.');
            return;
        }
        $this->data = array(
            'id' => $map['id'],
            'name' => $map['name'],
            'marketplace' => $map['marketplace'],
            'floor' => $map['floor'],
            'map' => HelpTemplate::getMapUrl($map['map']),
            'created' => $map['created']
        );
    }

}
<?php

/*
 * 广告API
 */

/**
 * 2014-5-20 14:23:12 UTF-8
 * @package application.modeules.api.controllers
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * AdvertisementController.php hugb
 *
 */
class AdvertisementController extends IController {

    protected $advertisementBehavior;

    public function init() {
        parent::init();
        $this->advertisementBehavior = new AdvertisementBehavior();
    }

    public function actionList() {
        if (Yii::app()->request->getRequestType() != 'GET') {
            $this->error_code = self::ERROR_REQUEST_METHOD;
            $this->message = Yii::t('api', 'Please use GET method to get data.');
            return;
        }
        $page = Yii::app()->request->getQuery('page', 1);
        $pageSize = Yii::app()->request->getQuery('pagesize', 10);
        $tag = Yii::app()->request->getQuery('placetag');
        if (empty($tag)) {
            $this->error_code = self::ERROR_REQUEST_PARAMS;
            $this->message = 'placetag' . Yii::t('api', ' is not set.');
            return;
        }
        $filter = array(
            'where' => array('placetag' => $tag),
            'order' => 'created desc'
        );
        $advertisements = $this->advertisementBehavior->getList($filter, $page, $pageSize);
        if (empty($advertisements)) {
            return;
        }
        $this->data = array();
        foreach ($advertisements as $advertisement) {
            $this->data[] = array(
                'id' => $advertisement['id'],
                'pic' => HelpTemplate::getAdUrl($advertisement['pic']),
                'desc' => $advertisement['desc'],
                'url' => $advertisement['url'],
                'placetag' => $advertisement['placetag'],
                "source" => $advertisement['source'],
                "sid" => $advertisement['sid']
            );
        }
    }

    public function actionStation() {
        if (Yii::app()->request->getRequestType() != 'GET') {
            $this->error_code = self::ERROR_REQUEST_METHOD;
            $this->message = Yii::t('api', 'Please use GET method');
            return;
        }
        $uuid = Yii::app()->request->getQuery('uuid', 1);
        if (empty($uuid)) {
            $this->error_code = self::ERROR_REQUEST_PARAMS;
            $this->message = 'uuid' . Yii::t('api', ' is not set');
            return;
        }
        $rs = $this->advertisementBehavior->getStationAds($uuid);
        if (!$rs) {
            $this->error_code = self::ERROR_REQUEST_FAILURE;
            $this->message = $this->advertisementBehavior->getError();
        } else {
            $this->data = $rs;
        }
    }

}
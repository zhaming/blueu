<?php

/*
 * 广告业务
 */

/**
 * 2014-5-20 14:24:41 UTF-8
 * @package application.behaviors
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * AdvertisementBehavior.php hugb
 *
 */
class AdvertisementBehavior extends BaseBehavior {

    public function detail($tag) {
        $params = array('placetag' => $tag);
        $advertisement = Advertisement::model()->findByAttributes($params);
        if ($advertisement == null) {
            $this->error = Yii::t('api', 'Advertisement is no exist');
            return false;
        }
        return $advertisement;
    }

}
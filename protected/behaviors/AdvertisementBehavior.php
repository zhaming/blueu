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
    
    static $sourceMap = array(
        1 => 'MerchantShop',
        2 => 'MerchantProduct',
        3 => 'MerchantCoupon',
        4 => 'MerchantStamp',
    );

    public function detail($tag) {
        $params = array('placetag' => $tag);
        $advertisement = Advertisement::model()->findByAttributes($params);
        if ($advertisement == null) {
            $this->error = Yii::t('api', 'Advertisement is no exist.');
            return false;
        }
        return $advertisement;
    }

    /**
     * 广告详情
     * @param integer $userId
     * @return boolean or array
     */
    public function detailById($id) {
        $advertisement = Advertisement::model()->findByPk($id);
        if ($advertisement == null) {
            $this->error = Yii::t('api', 'Advertisement is no exist.');
            return false;
        }
        return $advertisement;
    }

    public function getList($filter = array(), $page = 1, $pagesize = 10) {
        $criteria = new CDbCriteria();
        $criteria->addCondition('disabled=0');
        $criteria->limit = $pagesize;
        $criteria->offset = ($page - 1) * $pagesize;
        foreach ($filter as $key => $value) {
            switch ($key) {
                case 'search':
                    foreach ($value as $column => $keyword) {
                        $criteria->addSearchCondition($column, $keyword);
                    }
                    break;
                case 'order':
                    $criteria->order = $value;
                    break;
                case 'where':
                    foreach ($value as $k => $v) {
                        $criteria->addCondition($k . '=:' . $k);
                        $criteria->params[':' . $k] = $v;
                    }
                    break;
                default:
                    break;
            }
        }

        return Advertisement::model()->with('account')->findAll($criteria);
    }

    public function getList1($filter = array(), $page = null, $pagesize = null) {
        $criteria = new CDbCriteria();
        $criteria->order = 'id desc';
        foreach ($filter as $key => $value) {
            switch ($key) {
                case 'search':
                    foreach ($value as $column => $keyword) {
                        $criteria->addSearchCondition($column, $keyword);
                    }
                    break;

                default:
                    break;
            }
        }

        $count = Advertisement::model()->count($criteria);

        $pager = new CPagination($count);
        $page != null && $pager->setCurrentPage($page - 1);
        $pagesize != null && $pager->setPageSize($pagesize);
        $pager->applyLimit($criteria);

        $data = Advertisement::model()->findAll($criteria);
        return array('pager' => $pager, 'data' => $data);
    }

    /**
     * 添加广告
     * @param array $data
     * @return boolean
     */
    public function create($data) {
        $fileBehavior = new FileBehavior();
        if (!$fileBehavior->isHaveUploadFile()) {
            $this->error = Yii::t('admin', 'Please upload picture.');
            return false;
        }
        $file = $fileBehavior->saveUploadAd();
        if (!$file) {
            $this->error = Yii::t('admin', 'Save picture failure.');
            return false;
        }
        $advertisement = new Advertisement();
        $advertisement->pic = $file['path'];
        $advertisement->url = $data['url'];
        $advertisement->desc = $data['desc'];
        $advertisement->placetag = $data['placetag'];
        $advertisement->owner = Yii::app()->user->getId();
        $advertisement->disabled = HelpTemplate::ENABLED;
        $advertisement->created = time();
        $advertisement->source = HelpTemplate::AD_SOURCE_MAN_MADE;
        return $advertisement->save();
    }

    /**
     * 禁用广告
     * @param mixed $id primary key value(s).
     * @return integer the number of rows being updated
     */
    public function disable($id) {
        return Advertisement::model()->updateByPk($id, array("disabled" => 1));
    }

    /**
     * 启用广告
     * @param mixed $id primary key value(s).
     * @return integer the number of rows being updated
     */
    public function enable($id) {
        return Advertisement::model()->updateByPk($id, array("disabled" => 0));
    }

    public function getStationAds($uuid) {
        $adsR = StationAds::model()->findAllByAttributes(array('uuid' => $uuid));
        if(empty($adsR)) return false;
        $result = array();
        foreach($adsR as $v) {
            $sourceR = $this->getDataBySource($v->source, $v->sid);
            if(empty($sourceR)) continue;
            $result[] = array(
                'name' => $sourceR->name,
                'pic' => HelpTemplate::getAdUrl($sourceR->pic),
                'intro' => $sourceR->intro,
                'shopid' => $v->shopid,
                'source' => $v->source,
                'sid' => $v->sid,
            );
        }
        return array_pop($result);
    }
    
    public function getDataBySource($source, $sid) {
        if(!array_key_exists($source, self::$sourceMap)) return false;
        $model = self::$sourceMap[$source];
        $rs = $model::model()->findByPk($sid);
        return $rs;
    }

    /**
     * 删除广告
     * @param mixed $id primary key value(s).
     * @return integer the number of rows being updated
     */
    public function delete($id) {
        return Advertisement::model()->deleteByPk($id);
    }

    public function update($id, $data) {
        unset($data['id']);
        return Advertisement::model()->updateByPk($id, $data);
    }

}
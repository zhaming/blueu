<?php
/**
 *	统计控制器
 *	@author		zham <zha_ming@163.com>
 *	@copyright	2014-2016
 *	@version	1.0
 *	@package	protected.modules.admin.controllers
 *
 *	$Id$
 */

class StatController extends BController {
    
    static $statMap = array(
        'user' => array('info', 'convert', 'share'),
        'industry' => array('total', 'shoptop', 'industrytop', 'coupontop', 'stamptop'),
        'shop' => array('toshop', 'coupontop', 'stamptop', 'realtime'),
    );
    static $limitMap = array(
        'user' => array(
            'day' => 15,
            'week' => 8,
            'month' => 4,
        ),
        'industry' => array(),
        'shop' => array(),
    );
    static $splitor = ':';
    static $splitorT = '|';
    
    private $_stat;
    
    protected function beforeAction($action) {
        parent::beforeAction($action);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->params->url_web.'js/html.js');
        $this->_stat = new StatBehavior();
        return true;
    }
    
    public function actionUser() {
        $action = Yii::app()->controller->getAction()->getId();
        $t = Yii::app()->request->getQuery('t');
        $t = empty($t) || !in_array($t, self::$statMap[$action]) ? 'info' : $t;
        switch($t){
            case 'convert':
                $this->setPageTitle(array(Yii::t('admin', 'VStatUserConvert')));
                break;
            case 'share':
                $this->setPageTitle(array(Yii::t('admin', 'VStatUserShare')));
                break;
            case 'info':
            default:
                $this->setPageTitle(array(Yii::t('admin', 'VStatUserInfo')));
        }
        $data = array(
            'limitMap' => self::$limitMap,
        );
        $this->render("user$t", $data);
    }
    
    public function actionIndustry() {
        $t = Yii::app()->request->getQuery('t');
        $t = empty($t) || !in_array($t, self::$statMap[Yii::app()->controller->id]) ? 'total' : $t;
        $this->render('industry');
    }
    
    public function actionShop() {
        $t = Yii::app()->request->getQuery('t');
        $t = empty($t) || !in_array($t, self::$statMap[Yii::app()->controller->id]) ? 'toshop' : $t;
        $this->render('shop');
    }
    
    public function actionUserData($t) {
        if(strpos($t, self::$splitor) === false) return false;
        list($source, $types) = explode(self::$splitor, $t);
        $types = explode(self::$splitorT, $types);
        
        $result = array();
        if($source == 'registered'){
            $xAxis = $yAxis = array();
            foreach($types as $type){
                $limit = self::$limitMap['user'][$type];
                $rs = $this->_stat->getUserRegistered($type, $limit);
                foreach($rs as $v){
                    switch($type){
                        case 'day':
                            $statdate = MingString::getFormatDate($type, $v->statdate, '');
                            break;
                        case 'week':
                            $month = MingString::getFormatDate('month', $v->statdate, Yii::t('admin', 'VStatMonth'));
                            $statdate = MingString::getFormatDate($type, $v->statdate, Yii::t('admin', 'VStatWeek'));
                            $statdate = $month . $statdate;
                            break;
                        case 'month':
                            $statdate = MingString::getFormatDate($type, $v->statdate, Yii::t('admin', 'VStatMonth'));
                            break;
                    }
                    $xAxis[] = $statdate;
                    $yAxis[] = $v->count;
                }
                $itemStyle ="{normal:{lineStyle:{shadowColor:'rgba(0,0,0,0.4)',shadowBlur:5,shadowOffsetX: 3,shadowOffsetY: 3}}}";
                $result[] = array(
                    'name' => Yii::t('admin', 'VStatUserRegistered'),
                    'xAxis' => array_reverse($xAxis),
                    'yAxis' => array_reverse($yAxis),
                    'extra' => array(
                        'itemStyle' => $itemStyle,
                    ),
                );
            }
        }elseif($source == 'user'){
            foreach($types as $type){
                $rs = $this->_stat->getUserSexAndCentury($type);
                $series = array();$itemStyle = '';
                foreach($rs as $v){
                    switch($type){
                        case 'sex':
                            $name = Yii::t('admin', 'VStatUserSex');
                            $radius = array(0, 60);
                            $itemStyle = "{normal:{label:{position:'inner'},labelLine:{show:false}}}";
                            break;
                        case 'century':
                            $name = Yii::t('admin', 'VStatUserCentury');
                            $radius = array(80, 120);
                            break;
                    }
                    $series[] = array(
                        'name' => Yii::t('admin', ucfirst($v->item)),
                        'value' => $v->count,
                    );
                }
                $result[] = array(
                    'name' => $name,
                    'series' => $series,
                    'extra' => array(
                        'radius' => $radius, 
                        'itemStyle' => $itemStyle,
                    ),
                );
            }
        }elseif($source == 'convert'){
            $rs = $this->_stat->getUserConvert();
            $xAxis = $yAxis = array();
            foreach($rs as $v){
                $xAxis[] = Yii::t('admin', $v->item);
                $yAxis[] = $v->count;
            }
            $result[] = array(
                'name' => Yii::t('admin', 'VStatUserCnt'),
                'xAxis' => $xAxis,
                'yAxis' => $yAxis,
            );
        }elseif($source == 'share'){
            $rs = $this->_stat->getUserConvert();
            $xAxis = $yAxis = array();
            foreach($rs as $v){
                $xAxis[] = Yii::t('admin', $v->item);
                $yAxis[] = $v->count;
            }
            $result[] = array(
                'name' => Yii::t('admin', 'VStatUserCnt'),
                'xAxis' => $xAxis,
                'yAxis' => $yAxis,
            );
        }
        
        echo json_encode($result);
    }
    
    public function actionIndustryData() {
        echo __METHOD__;
    }
    
    public function actionShopData() {
        echo __METHOD__;
    }
}
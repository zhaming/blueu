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
        'industry' => array('total', 'top', 'stop'),
        'shop' => array('toshop', 'stop', 'realtime'),
    );
    static $limitMap = array(
        'user' => array(
            'day' => 15,
            'week' => 8,
            'month' => 4,
        ),
        'industry' => array(
            'day' => 15,
            'week' => 8,
        ),
        'shop' => array(),
    );
    static $sourceMap = array(
        1 => 'Shop',
        2 => 'Product',
        3 => 'Coupon',
        4 => 'Stamp',
    );
    static $totalMap = array(
        'likecnt',
        'pclickcnt',
        'sclickcnt',
        'sharecnt',
    );
    static $topLimit = 20;
    static $splitor = ':';
    static $splitorT = '|';
    
    private $_stat;
    
    protected function beforeAction($action) {
        parent::beforeAction($action);
        Yii::app()->clientScript->registerScriptFile(Yii::app()->params->url_web.'js/html.js');
        $this->_stat = new StatBehavior();
        return true;
    }
    
    public function actionIndex()
    {
        $this->actionUser();
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
            'topLimit' => self::$topLimit,
        );
        $this->render("user$t", $data);
    }
    
    public function actionIndustry() {
        $action = Yii::app()->controller->getAction()->getId();
        $t = Yii::app()->request->getQuery('t');
        $t = empty($t) || !in_array($t, self::$statMap[$action]) ? 'total' : $t;
        switch($t){
            case 'stop':
                $this->setPageTitle(array(Yii::t('admin', 'VStatIndustrySTop')));
                break;
            case 'top':
                $this->setPageTitle(array(Yii::t('admin', 'VStatIndustryTop')));
                break;
            case 'total':
            default:
                $this->setPageTitle(array(Yii::t('admin', 'VStatIndustryTotal')));
        }
        $legend = array();
        foreach(self::$totalMap as $v){
            $legend[] = Yii::t('admin', $v);
        }
        $data = array(
            'limitMap' => self::$limitMap,
            'topLimit' => self::$topLimit,
            'legend' => implode(',', $legend),
        );
        $this->render("industry$t", $data);
    }
    
    public function actionShop() {
        $action = Yii::app()->controller->getAction()->getId();
        $t = Yii::app()->request->getQuery('t');
        $t = empty($t) || !in_array($t, self::$statMap[$action]) ? 'toshop' : $t;
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
                $series = array();$itemStyle = '';$suffix = '';
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
                            $suffix = Yii::t('admin', 'century');
                            break;
                    }
                    $series[] = array(
                        'name' => Yii::t('admin', ucfirst($v->item)) . $suffix,
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
            $rs = $this->_stat->getUserShare();
            $xAxis = $yAxis = $female = $male = array();
            foreach($rs as $v){
                $century = Yii::t('admin', ucfirst($v->century)) . Yii::t('admin', 'century');
                if(!in_array($century, $xAxis)) $xAxis[] = $century;
                if($v->sex == '1'){
                    $female[] = $v->count;
                }elseif($v->sex == '2'){
                    $male[] = $v->count;
                }
            }
            $result[] = array(
                'name' => Yii::t('admin', 'Female'),
                'xAxis' => $xAxis,
                'yAxis' => $female,
            );
            $result[] = array(
                'name' => Yii::t('admin', 'Male'),
                'xAxis' => $xAxis,
                'yAxis' => $male,
            );
        }
        
        echo json_encode($result);
    }
    
    public function actionUserShareTop() {
        $source = Yii::app()->request->getQuery('source');
        $page = Yii::app()->request->getQuery('page');
        $sourceName = Yii::t('admin', self::$sourceMap[$source]);
        $rs = $this->_stat->getUserShareContent($source, $page, self::$topLimit);
        $data = array(
            'sourceName' => $sourceName,
            'list' => $rs['list'],
            'pages' => $rs['pages'],
        );
        $this->renderPartial("usersharetop", $data);
    }
    
    public function actionIndustryData($t) {
        if(strpos($t, self::$splitor) === false) return false;
        list($source, $types) = explode(self::$splitor, $t);
        $types = explode(self::$splitorT, $types);
        
        $result = array();
        if($source == 'total'){
            $itemStyle ="{normal:{lineStyle:{shadowColor:'rgba(0,0,0,0.4)',shadowBlur:5,shadowOffsetX: 3,shadowOffsetY: 3}}}";
            foreach($types as $type){
                $limit = self::$limitMap['industry'][$type];
                foreach(self::$totalMap as $item){
                    $rs = $this->_stat->getIndustryTotal($type, $item, $limit);
                    
                    $xAxis = $yAxis = array();
                    for($i = count($rs) - 1; $i >= 0; $i--){
                        $v = $rs[$i];
                        switch($type){
                            case 'week':
                                $month = MingString::getFormatDate('month', $v->statdate, Yii::t('admin', 'VStatMonth'));
                                $statdate = MingString::getFormatDate($type, $v->statdate, Yii::t('admin', 'VStatWeek'));
                                $statdate = $month . $statdate;
                                break;
                            case 'day':
                            default:
                                $statdate = MingString::getFormatDate($type, $v->statdate, '');
                                break;
                        }
                        $name = Yii::t('admin', $v->item);
                        $xAxis[] = $statdate;
                        $yAxis[] = $v->count;
                    }
                    $result[] = array(
                        'name' => $name,
                        'xAxis' => $xAxis,
                        'yAxis' => $yAxis,
                        'extra' => array('itemStyle' => $itemStyle),
                    );
                }
            }
        }
        
        echo json_encode($result);
    }
    
    public function actionIndustryTop() {
        $source = Yii::app()->request->getQuery('source');
        $page = Yii::app()->request->getQuery('page');
        $sourceName = Yii::t('admin', self::$sourceMap[$source]);
        $rs = $this->_stat->getUserShareContent($source, $page, self::$topLimit);
        $data = array(
            'sourceName' => $sourceName,
            'list' => $rs['list'],
            'pages' => $rs['pages'],
        );
        $this->renderPartial("usersharetop", $data);
    }
    
    public function actionShopData($t) {
        echo __METHOD__;
    }
}
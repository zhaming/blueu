<?php

/*
 * 面包屑
 */

/**
 * 2014-6-2 9:52:24 UTF-8
 * @package application.modules.admin.widgets
 * @version 3.0
 *
 * @author hugb <hu198021688500@163.com>
 * @copyright (c) 2011-2015
 * @license ()
 * 
 * BreadcrumbsWidget.php hugb
 *
 */
class BreadcrumbsWidget extends CWidget {

    public function init() {
        parent::init();
    }

    public function run() {
        $viewData = array();
        $menusTree = array(
            'site' => array(
                'title' => Yii::t('admin', 'Console'),
                'actions' => array()
            ),
            'user' => array(
                'title' => Yii::t('admin', 'Client'),
                'actions' => array(
                    'create' => Yii::t('admin', 'Create')
                )
            ),
            'merchant' => array(
                'title' => Yii::t('admin', 'Merchant'),
                'actions' => array(
                    'create' => Yii::t('admin', 'Create')
                )
            ),
            'merchantproduct' => array(
                'title' => Yii::t('admin', 'ProductManager'),
                'actions' => array(
                    'create' => Yii::t('admin', 'Create'),
                    'edit' => Yii::t('admin', 'Edit')
                )
            ),
            'merchantcoupon' => array(
                'title' => Yii::t('shop', 'Coupon Manager'),
                'actions' => array(
                    'create' => Yii::t('admin', 'Create'),
                    'edit' => Yii::t('admin', 'Edit'),
                    'validatecoupon' => Yii::t('shop', 'Coupon use')
                )
            ),
            'merchantstamp' => array(
                'title' => Yii::t('shop', 'Stamp Manager'),
                'actions' => array(
                    'create' => Yii::t('admin', 'Create'),
                    'edit' => Yii::t('admin', 'Edit')
                )
            ),
            'merchantshop' => array(
                'title' => Yii::t('shop', 'Shop Manager'),
                'actions' => array(
                    'create' => Yii::t('admin', 'Create'),
                    'edit' => Yii::t('admin', 'Edit'),
                    'addshopaccount' => Yii::t("admin", "Create shop account")
                )
            ),
            'acl' => array(
                'title' => Yii::t('admin', 'Access control'),
                'actions' => array(
                    'create' => Yii::t('admin', 'Create')
                )
            ),
            'manager' => array(
                'title' => Yii::t('admin', 'Administrator'),
                'actions' => array(
                    'create' => Yii::t('admin', 'Create')
                )
            ),
            'stat' => array(
                'title' => Yii::t('admin', 'Statistic Manager'),
                'actions' => array(
                    'user' => Yii::t('admin', 'User Analytics')
                )
            ),
            'feedback' => array(
                'title' => Yii::t('admin', 'Feedback'),
                'actions' => array(
                    'create' => Yii::t('admin', 'Create')
                )
            ),
            'push' => array(
                'title' => Yii::t('admin', 'PushManager'),
                'actions' => array(
                    'add' => Yii::t('admin', 'Create'),
                    'edit' => Yii::t('admin', 'Edit')
                )
            ),
            'log' => array(
                'title' => Yii::t('admin', 'Log'),
                'actions' => array(
                    'create' => Yii::t('admin', 'Create')
                )
            ),
            'station' => array(
                'title' => Yii::t('station', 'Station Manager'),
                'actions' => array(
                    'create' => Yii::t('admin', 'Create'),
                    'edit' => Yii::t('admin', 'Edit'),
                    'adslist' => Yii::t('station', 'Station ads list')
                )
            ),
            'map' => array(
                'title' => Yii::t('admin', 'Map'),
                'actions' => array(
                    'create' => Yii::t('admin', 'Create')
                )
            ),
            'advertisement' => array(
                'title' => Yii::t('admin', 'Advertisement'),
                'actions' => array(
                    'create' => Yii::t('admin', 'Create')
                )
            ),
            'settings' => array(
                'title' => Yii::t('admin', 'Settings'),
                'actions' => array(
                    'create' => Yii::t('admin', 'Create')
                )
            ),
            'task' => array(
                'title' => Yii::t('admin', 'TaskManager'),
                'actions' => array(
                    'add' => Yii::t('admin', 'Create'),
                    'edit' => Yii::t('admin', 'Edit'),
                    'log' => Yii::t('admin', 'TaskLogkManager')
                )
            )
        );


        $controllerName = Yii::app()->controller->id;
        $actionName = Yii::app()->controller->getAction()->getId();
        if (key_exists($controllerName, $menusTree)) {
            $viewData['secondLevelTitle'] = $menusTree[$controllerName]['title'];
            if (key_exists($actionName, $menusTree[$controllerName]['actions'])) {
                $viewData['thirdLevelTitle'] = $menusTree[$controllerName]['actions'][$actionName];
            }
        }
        $this->render("breadcrumbs", $viewData);
    }

}

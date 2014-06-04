<?php
/**
 *	任务控制器
 *	@author		zham <zha_ming@163.com>
 *	@copyright	2014-2016
 *	@version	1.0
 *	@package	MING
 *
 *	$Id$
 */

class TaskController extends BController
{
    static $urls = array(
        'add' => 'task/add',
        'edit' => 'task/edit',
        'list' => 'task/list',
        'delete' => 'task/delete',
        'log' => 'task/log',
        'run' => 'task/run',
    );
    static $disableds = array(
        '0' => '正常',
        '1' => '禁用',
    );
    static $types = array(
        'push' => array(
            'welcome',
            'leave',
            'like',
            'manual',
        ),
        'stat' => array(
            'user',
            'industry',
        ),
    );
    static $command = '/opt/server/php/bin/php %s/console.php %s %s';
    private $_task;
    
    protected function beforeAction($action) {
        parent::beforeAction($action);
        $this->_task = new TaskBehavior();
        return true;
    }
    
    public function actionItems($type)
    {
        $items = isset(self::$types[$type]) ? self::$types[$type] : '';
        echo json_encode($items);
    }
    
    public function actionList()
    {
        $this->setPageTitle(array(Yii::t('admin', 'VTaskList')));
        $list = $this->_task->listinfo();
        $this->render('list', array('list' => $list));
    }
    
    public function actionAdd()
    {
        $this->setPageTitle(array(Yii::t('admin', 'VTaskAdd')));
        $kinds = array(
            0 => Yii::t('admin', 'VTaskKind0'),
            1 => Yii::t('admin', 'VTaskKind1'),
        );
        $viewData = array(
            'message' => null,
            'types' => self::$types,
            'kinds' => $kinds,
        );
        $_taskForm = new TaskForm();
        $viewData['info'] = $_taskForm->getAttributes();
        if (!Yii::app()->request->isPostRequest) {
            return $this->render("task", $viewData);
        }
        $info = Yii::app()->request->getPost('info');
        $_taskForm->setAttributes($info);
        if (!$_taskForm->validate()) {
            $viewData['message'] = $_taskForm->getFirstError();
            return $this->render("task", $viewData);
        }
        $rs = $this->_task->add($_taskForm->getAttributes());
        if (!$rs) {
            $viewData['message'] = Yii::t('admin', 'AAddFail');
            return $this->render("task", $viewData);
        }
        $this->showSuccess(Yii::t('admin', 'AAddSuccess'), $this->createUrl('list'));
    }
    
    public function actionEdit()
    {
        $this->setPageTitle(array(Yii::t('admin', 'VTaskEdit')));
        $kinds = array(
            0 => Yii::t('admin', 'VTaskKind0'),
            1 => Yii::t('admin', 'VTaskKind1'),
        );
        $viewData = array(
            'message' => null,
            'types' => self::$types,
            'kinds' => $kinds,
        );
        if (!Yii::app()->request->isPostRequest) {
            $id = Yii::app()->request->getQuery('id');
            $info = $this->_task->getById($id);
            $viewData['info'] = $info;
            return $this->render('task', $viewData);
        }
        $_taskForm = new TaskForm();
        $info = Yii::app()->request->getPost('info');
        $_taskForm->setAttributes($info);
        if (!$_taskForm->validate()) {
            $viewData['message'] = $_taskForm->getFirstError();
            $viewData['info'] = $_taskForm->getAttributes();
            return $this->render('task', $viewData);
        }
        $rs = $this->_task->edit($info['id'], $info);
        if (!$rs) {
            $viewData['message'] = Yii::t('admin', 'AEditFail');
            $viewData['info'] = $info;
            return $this->render("task", $viewData);
        }
        $this->showSuccess(Yii::t('admin', 'AEditSuccess'), $this->createUrl('list'));
    }
    
    public function actionDelete()
    {
        $id = Yii::app()->request->getQuery('id');
        $rs = $this->_task->delete($id);
        $message = $rs ? 'ADelSuccess' : 'ADelFail';
        $this->showError(Yii::t('admin', $message), $this->createUrl('list'));
    }
    
    public function actionLog()
    {
        Yii::app()->clientScript->registerScriptFile(Yii::app()->params->url_web.'js/html.js');
        
        $tasks = $this->_task->getTaskOption();
        $search = array(
            'taskid' => Yii::app()->request->getQuery('taskid'),
            'start' => Yii::app()->request->getQuery('start'),
            'end' => Yii::app()->request->getQuery('end'),
        );
        $order = Yii::app()->request->getQuery('order');
        if(!empty($order)) $order = str_replace('order_', '', $order);
        $page = Yii::app()->request->getQuery('page');
        $result = $this->_task->logListinfo($search, $order, $page);
        
        $this->setPageTitle(array(Yii::t('admin', 'VTaskLogList')));
        $data = array(
            'tasks' => $tasks,
            'list' => $result['list'],
            'pages' => $result['pages'],
        );
        $this->render('log', $data);
    }
}
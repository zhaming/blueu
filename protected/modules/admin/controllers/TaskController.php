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
        'push' => '推送通知',
        'stat' => '数据统计',
    );
    static $command = '/opt/server/php/bin/php %s/console.php %s %s';
    private $_task;
    
    protected function beforeAction($action) {
        parent::beforeAction($action);
        $this->_task = new TaskBehavior();
        return true;
    }
    
    public function actionList()
    {
        $this->setPageTitle(array(Yii::t('admin', 'VTaskList')));
        $list = $this->_task->listinfo();
        $this->render('list', array('list' => $list));
    }
    
    public function actionAdd()
    {
        if(Yii::app()->request->getPost('dosubmit'))
        {
            $info = array(
                'name' => Yii::app()->request->getPost('name'),
                'type' => Yii::app()->request->getPost('type'),
                'actor' => Yii::app()->request->getPost('actor'),
                'count' => Yii::app()->request->getPost('count'),
                'sql' => Yii::app()->request->getPost('sql'),
                'ext' => Yii::app()->request->getPost('ext'),
                'memo' => Yii::app()->request->getPost('memo'),
                'disabled' => Yii::app()->request->getPost('disabled'),
            );
            $errorCode = $this->_task->add($info);
            $errorMsg = '';
            $tUrl = 'goback';
            switch($errorCode)
            {
                case 0:
                    $errorMsg = '添加成功';
                    $tUrl = MingString::url(self::$urls['list']);
                    break;
                case 1:
                    $errorMsg = '添加出错';
                    break;
                default:
            }
            $this->redirect($tUrl, $errorMsg);
        }
        
        $_app = new AdminAppBehavior();
        $appAuths = $_app->getAppAuthOption();
        
        $this->setPageTitle(array('添加任务'));
        $data = array(
            'disableds' => self::$disableds,
            'types' => self::$types,
            'appAuths' => $appAuths,
            'info' => array(),
        );
        $this->render('task', $data);
    }
    
    public function actionEdit()
    {
        if(Yii::app()->request->getPost('dosubmit'))
        {
            $id = Yii::app()->request->getPost('id');
            $info = array(
                'name' => Yii::app()->request->getPost('name'),
                'type' => Yii::app()->request->getPost('type'),
                'actor' => Yii::app()->request->getPost('actor'),
                'count' => Yii::app()->request->getPost('count'),
                'memo' => Yii::app()->request->getPost('memo'),
                'disabled' => Yii::app()->request->getPost('disabled'),
            );
            if(Yii::app()->request->getPost('sql')) $info['sql'] = Yii::app()->request->getPost('sql');
            if(Yii::app()->request->getPost('ext')) $info['ext'] = Yii::app()->request->getPost('ext');
            $errorCode = $this->_task->edit($id, $info);
            $errorMsg = '';
            $tUrl = 'goback';
            switch($errorCode)
            {
                case 0:
                    $errorMsg = '编辑成功';
                    $tUrl = MingString::url(self::$urls['list']);
                    break;
                case 1:
                    $errorMsg = '编辑出错';
                default:
            }
            $this->redirect($tUrl, $errorMsg);
        }
        
        $id = Yii::app()->request->getQuery('id');
        $info = $this->_task->getById($id);
        
        $this->setPageTitle(array('编辑任务'));
        $data = array(
            'disableds' => self::$disableds,
            'types' => self::$types,
            'info' => $info,
        );
        $this->render('task', $data);
    }
    
    public function actionDelete()
    {
        $id = Yii::app()->request->getQuery('id');
        if(empty($id)) $this->showError(Yii::t('admin', 'Illegal request'), $this->createUrl('list'));
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
    
    public function actionRun()
    {
        $taskid = Yii::app()->request->getQuery('taskid');
        $type = Yii::app()->request->getQuery('type');
        
        
        /*$command = sprintf(self::$command, realpath(Yii::app()->basePath.DS.'..'), $type, $taskid);
        $result = exec($command);
        $this->redirect(MingString::url(self::$urls['list']), '状态码：'.$result);*/
    }
}
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
        $list = $this->_task->listinfo();
        
        $this->setPageTitle(array('任务列表'));
        $data = array(
            'types' => self::$types,
            'list' => $list,
        );
        $this->render('list', $data);
    }
    
    public function actionAdd()
    {
        if($this->_request->getPost('dosubmit'))
        {
            $info = array(
                'name' => $this->_request->getPost('name'),
                'type' => $this->_request->getPost('type'),
                'actor' => $this->_request->getPost('actor'),
                'count' => $this->_request->getPost('count'),
                'sql' => $this->_request->getPost('sql'),
                'ext' => $this->_request->getPost('ext'),
                'memo' => $this->_request->getPost('memo'),
                'disabled' => $this->_request->getPost('disabled'),
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
        if($this->_request->getPost('dosubmit'))
        {
            $id = $this->_request->getPost('id');
            $info = array(
                'name' => $this->_request->getPost('name'),
                'type' => $this->_request->getPost('type'),
                'actor' => $this->_request->getPost('actor'),
                'count' => $this->_request->getPost('count'),
                'memo' => $this->_request->getPost('memo'),
                'disabled' => $this->_request->getPost('disabled'),
            );
            if($this->_request->getPost('sql')) $info['sql'] = $this->_request->getPost('sql');
            if($this->_request->getPost('ext')) $info['ext'] = $this->_request->getPost('ext');
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
        
        $id = $this->_request->getQuery('id');
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
        $id = $this->_request->getQuery('id');
        $rs = $this->_task->delete($id);
        if($rs)
            $errorMsg = '删除成功';
        else
            $errorMsg = '删除失败';
        $this->redirect(MingString::url(self::$urls['list']), $errorMsg);
    }
    
    public function actionLog()
    {
        Yii::app()->clientScript->registerCssFile(Yii::app()->params->url_web.'styles/calendar.css');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->params->url_web.'scripts/calendar.js');
        
        $tasks = $this->_task->getTaskOption();
        $search = array(
            'taskid' => $this->_request->getQuery('taskid'),
            'start' => $this->_request->getQuery('start'),
            'end' => $this->_request->getQuery('end'),
        );
        $order = $this->_request->getQuery('order');
        if(!empty($order)) $order = str_replace('order_', '', $order);
        $page = $this->_request->getQuery('page');
        $result = $this->_task->logListinfo($search, $order, $page);
        
        $this->setPageTitle(array('日志列表'));
        $data = array(
            'urls' => self::$urls,
            'tasks' => $tasks,
            'list' => $result['list'],
            'pages' => $result['pages'],
        );
        $this->render('log', $data);
    }
    
    public function actionRun()
    {
        $taskid = $this->_request->getQuery('taskid');
        $type = $this->_request->getQuery('type');
        $command = sprintf(self::$command, realpath(Yii::app()->basePath.DS.'..'), $type, $taskid);
        $result = exec($command);
        $this->redirect(MingString::url(self::$urls['list']), '状态码：'.$result);
    }
}
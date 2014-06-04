<?php
/**
 *	后台任务behavior
 *	@author		zham <zha_ming@163.com>
 *	@copyright	2014-2016
 *	@version	1.0
 *	@package	MING
 *
 *	$Id$
 */

class TaskBehavior extends BaseBehavior
{
    /**
     * 获取任务option
     * @return array 
     */
    public function getTaskOption()
    {
        $tasks = $this->tasks('', true, false, false);
        $options = array('' => Yii::t('admin', 'TaskTotal'));
        foreach($tasks as $v)
            $options[$v['id']] = $v['name'];
        return $options;
    }

    /**
     * 获取任务列表
     * @param boolean $isdisabled
     * @param boolean $iswaiting
     * @return array 
     */
    public function tasks($type = '', $isdisabled = false, $iswaiting = true, $immediately = 1)
    {
        $type = strtolower($type);
        $criteria = new CDbCriteria();
        if(!empty($type)) $criteria->addCondition("type = '$type'");
        if($isdisabled == false) $criteria->addCondition('disabled = 0');
        if($iswaiting == true) $criteria->addCondition('runtime = 0');
        if(is_numeric($immediately)) $criteria->addCondition("immediately = '$immediately'");
        $criteria->order = 'priority ASC';
        return Task::model()->findAll($criteria);
    }
    
    /**
     * 设置运行状态
     * @param integer $id
     * @param array $info
     * @return integer 
     */
	public function setRuntime($id, $runtime)
	{
        $info = array('runtime' => $runtime);
        return Task::model()->updateByPk($id, $info);
	}
    
    /**
     * 成功执行次数递增
     * @param integer $id
     * @param integer $times
     * @return integer 
     */
    public function plusExecTimes($id, $times = 1)
    {
        return Task::model()->updateCounters(array('exec_times' => $times), "id = '$id'");
    }
    
    /**
     * 判断任务是否以存在
     * @param string $type
     * @param string $item
     * @return boolean
     */
    public function isExist($type, $item)
    {
        return Task::model()->exists("type = '$type' and item = '$item'");
    }

    /**
	 * 任务列表
	 * @return array
	 */
	public function listinfo()
	{
        return Task::model()->findAll();
	}
    
    /**
     * 根据ID获取任务信息
     * @param integer $id
     * @return object 
     */
	public function getById($id, $type = '')
	{
        $type = strtolower($type);
        if(empty($type))
            $rs = Task::model()->findByPk($id);
        else
            $rs = Task::model()->findByPk($id, "type = '$type'");
        return $rs;
	}
    
    /**
     * 添加任务
     * @param array $info
     * @return integer 
     */
    public function add($info)
	{
        $task = new Task();
        $task->name = $info['name'];
        $task->type = $info['type'];
        $task->item = $info['item'];
        $task->immediately = $info['immediately'];
        $task->priority = $info['priority'];
        $task->msg = $info['msg'];
        $task->sql = $info['sql'];
        $task->ext = $info['ext'];
        $task->memo = $info['memo'];
        $task->disabled = $info['disabled'];
        $task->created = time();
        return $task->save();
	}
	
	/**
     * 编辑任务
     * @param integer $id
     * @param array $info
     * @return integer 
     */
	public function edit($id, $info)
	{
        return Task::model()->updateByPk($id, $info);
	}
	
	/**
	 * 根据ID删除任务
	 * @param mixed $id
	 * @return boolean
	 */
	public function delete($id)
	{
        return Task::model()->deleteByPk($id);
    }
    
    /**
	 * 任务日志列表
     * @param array $search
     * @param string $order
     * @param integer $page
	 * @return array
	 */
	public function logListinfo($search, $order, $page)
	{
        $criteria = new CDbCriteria();
        if(!empty($search))
        {
            $condition = $params = array();
            if(!empty($search['taskid']))
            {
                $condition[] = 'taskid = :taskid';
                $params[':taskid'] = $search['taskid'];
            }
            if(!empty($search['start']))
            {
                if(strlen($search['start']) <= 10) $search['start'] .= '00:00:00';
                $condition[] = 'start >= :start';
                $params[':start'] = strtotime($search['start']);
            }
            if(!empty($search['end']))
            {
                if(strlen($search['end']) <= 10) $search['end'] .= '23:59:59';
                $condition[] = 'end <= :end';
                $params[':end'] = strtotime($search['end']);
            }
            $condition = implode(' and ', $condition);
            $criteria->condition = $condition;
            $criteria->params = $params;
        }
        $criteria->order = empty($order) ? 'id DESC' : $order;
        
        if(empty($page)) $page = 1;
        $pageSize = Yii::app()->params->page_size;
        $criteria->offset = $pageSize * ($page -1);
        $criteria->limit = $pageSize;
        
        $count = TaskLog::model()->count($criteria);
        $rows = TaskLog::model()->findAll($criteria);
        
        $pages = new CPagination($count);
        $pages->pageSize = $pageSize;
        $pages->applyLimit($criteria);
        
        $result = array(
            'list' => $rows,
            'pages' => $pages,
        );
        
        return $result;
	}
    
    /**
     * 添加任务日志
     * @param integer $taskid
     * @param array $info
     * @return integer 
     */
    public function logAdd($taskid, $info)
	{
        $taskLog = new TaskLog();
        $taskLog->taskid = $taskid;
        $taskLog->start = isset($info['start'])?$info['start']:0;
        $taskLog->end = isset($info['end'])?$info['end']:0;
        $taskLog->total = isset($info['total'])?$info['total']:0;
        $taskLog->success = isset($info['success'])?$info['success']:0;
        $taskLog->result = isset($info['result'])?$info['result']:0;
        $taskLog->save();
        return $taskLog->id;
	}
	
	/**
     * 编辑任务日志
     * @param integer $id
     * @param array $info
     * @return integer 
     */
	public function logEdit($id, $info)
	{
        return TaskLog::model()->updateByPk($id, $info);
	}
}
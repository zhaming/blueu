<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{

	public $controller_id;
	public $action_id;
	
	public $layout='//layouts/main';
	
	public $menu=array();
	
	public $breadcrumbs=array();

  
    public function beforeAction($action)
    {
        parent::beforeAction($action);
		$this->controller_id = $this->getId();
		$this->action_id = $this->getAction()->getId();

        return true;
    }

	protected function afterAction($action)
	{
		$message = Yii::app()->user->getFlash('alertmsg');
		if($message!=null)
		{
			if($message['type'])
				echo '<script>alert("'.$message['msg'].'");</script>';
			else
				echo '<script>alert("'.$message['msg'].'");</script>';
		}
	}


	public function checkParams($params,$keys,$type='empty')
	{
		if(!is_array($params))
			return false;
		foreach($keys as $key)
		{
			if($type=='empty')
			{
				if(empty($params[$key]))
					return false;
			}elseif($type=='isset')
			{
				if(!isset($params[$key]))
					return false;
			}else
				return false;
		}
		return true;
	}

	public function showMessage($msg, $url = '',$type=false)
    {
        $message = array();
        $message['type'] = $type;
        $message['msg'] = $msg;
        Yii::app()->user->setFlash('alertmsg', $message);
        if (!empty($url)) {
            $this->redirect($url);
        }
    }

}

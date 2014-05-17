<?php

class SiteController extends Controller
{

	public function actionIndex()
	{
        $this->redirect('/html/home.html');
		return false;
		$this->render('index');
	}


	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	/**
	 * This is the action to handle external exceptions.
	 */

    public function actionError()
    {
        if($error=Yii::app()->errorHandler->error)
        {
            if(Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->renderPartial('error', $error);
        }
    }
}

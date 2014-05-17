<?php
class SiteController extends Controller
{
    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest) {
                echo json_encode($error);
            } else {
                echo "<pre>";
                print_r($error);
            }
        }
    }
}
?>

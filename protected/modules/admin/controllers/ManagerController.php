<?php
class ManagerController extends BController{

    public function actionLogin()
    {
        if (Yii::app()->request->isPostRequest) {
            $loginForm = Yii::app()->request->getPost('LoginForm');
            $identity = new ManagerIdentity($loginForm['name'],$loginForm['pass']);
            if($identity->authenticate()) {
                if(empty($LoginForm['rememberme'])){
                    $duration = 0;
                }else{
                    $duration = 3600*24*1;
                }

                Yii::app()->user->login($identity,$duration);

                $this->redirect('/admin');
            }else {
                $this->showError($identity->errorMessage,'/admin/manager/login');
            }
        } else {
            if (Yii::app()->user->isGuest) {
                $this->layout="null";
                $this->render("login");
            } else {
                $this->redirect('/admin');
            }

        }
    }

    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect('/admin/manager/login');
    }

   public function actionMypass()
    {
        $newpass = Yii::app()->request->getPost("password");
        $oldpass = Yii::app()->request->getPost("oldpass");
        $repass = Yii::app()->request->getPost('repass');

        if(!empty($newpass) && !empty($oldpass)){

            if($newpass != $repass){
                $this->showError("密码和确认密码不相同");
                $this->redirect('/admin/manager/mypass');
            }

            $res = User::model()->changePass($id,$oldpass,$newpass);
            if(!empty($res)){
                $this->showSuccess("修改成功");
                // $manager['manager_pass'] =md5($newpass);
                // Yii::app()->session['manager']= $manager;
            }else{
                $this->showError("修改失败");
            }
            $this->redirect('/admin/manager/mypass');
        }

        $this->setPageTitle('修改我的密码');
        $this->render('password',compact('id'));
    }

    public function actionAddmanager()
    {
        if(Yii::app()->request->isPostRequest) {
            $manager = Yii::app()->request->getPost('manager');
            $status = Manager::model()->addManager($manager);
            if ($status > 0) {
                $this->showSuccess('添加成功');
            } else {
                $this->showError('添加失败');
            }
            $this->redirect(array('/admin/manager/list'));
        } else {
            $roles = Role::model()->roles();
            $this->render('add', array('roles' => $roles));
        }
    }
    public function actionEdit()
    {
        if (Yii::app()->request->isPostRequest) {
            $manager = Yii::app()->request->getPost('manager');
            $status = Manager::model()->edit($manager);
            if ($status) {
                $this->showSuccess('更新成功');
            } else {
                $this->showError('更新失败');
            }
            $this->redirect(array('/admin/manager/edit/id/'.$manager['id']));
        } else {
            $id = Yii::app()->request->getQuery('id');
            $manager = Manager::model()->getArrById($id);
            $roles = Role::model()->roles();
            $this->render('edit', array('manager' =>$manager, 'roles' => $roles));
        }
    }
    public function actionDisable()
    {
        $id = Yii::app()->request->getQuery('id');
        $status = Manager::model()->changeStatus($id, 'disable');
        if ($status > 0) {
            $this->showSuccess('禁用成功');
        } else {
            $this->showError('禁用失败');
        }
        $this->redirect('/admin/manager/list');
    }

    public function actionEnable()
    {
        $id = Yii::app()->request->getQuery('id');
        $status = Manager::model()->changeStatus($id, 'enable');
        if ($status > 0) {
            $this->showSuccess('启用成功');
        } else {
            $this->showError('启用失败');
        }
        $this->redirect('/admin/manager/list');
    }

    public function actionDelete()
    {
        $id = Yii::app()->request->getQuery('id');
        print_r($id);print_r(Yii::app()->session['manager_id']);
        if ($id == Yii::app()->session['manager_id']) {
            $this->showError('不能对自己进行该操作');
        } else {
            $status = Manager::model()->deleteById($id);
            if ($status) {
                $this->showSuccess('删除操作成功');
            } else {
                $this->showError('删除操作失败');
            }
        }
        $this->redirect('/admin/manager/list');
    }

    public function actionList()
    {
        $data = Manager::model()->managers();
        $this->render('list', array('data' => $data));
    }
}
?>

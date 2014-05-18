<?php

class NavListWidget extends CWidget {

    public function init() {
        parent::init();
    }

    public function run() {
        $category = array(
            'user' => '用户管理',
            'merchant' => '商户管理',
            'activity' => '活动管理',
            'statistics' => '统计管理',
            'push' => '推送管理',
            'sys' => '系统管理'
        );
        $menus = array(
            'user' => array(
                array('用户列表', '/admin/user/index')
            ),
            'merchant' => array(
                array('商户列表', '/admin/merchant/index'),
                array('添加商户', '/admin/merchant/add')
            ),
            'activity' => array(
                array('活动列表', '/admin/activity/index'),
                array('活动模版', '/admin/activitytpl/index')
            ),
            'statistics' => array(
                array('统计列表', '/admin/statistics/index')
            ),
            'push' => array(
                array('推送列表', '/admin/push/index')
            ),
            'sys' => array(
                array('帐号管理', '/admin/manager/list'),
                array('系统设置', '/admin/site/setting')
            )
        );
        $c = $this->controller->id;
        $a = $this->controller->action->id;
        $ac = '';
        $am = '';
        foreach ($menus as $ck => $ms) {
            foreach ($ms as $m) {
                if ('/admin/' . $c . '/' . $a == $m[1]) {
                    $ac = $ck;
                    $am = '/admin/' . $c . '/' . $a;
                }
            }
        }
        $this->render("NavList", compact('category', 'menus', 'c', 'a', 'ac', 'am'));
    }

}
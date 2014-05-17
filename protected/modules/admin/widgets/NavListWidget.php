<?php
class NavListWidget extends CWidget
{
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $category = array();
        $menus = array();
        $baseProj = '/blueu';

        $category['station'] = '基站管理';
        $menus['station'][] = array('基站列表', $baseProj.'/admin/station/index');
        $menus['station'][] = array('新增基站', $baseProj.'/admin/station/add');

        $category['merchant'] = '商户管理';
        $menus['merchant'][] = array('商户列表', $baseProj.'/admin/merchant/index');
        $menus['merchant'][] = array('添加商户', $baseProj.'/admin/merchant/add');

        $category['ad'] = '广告管理';
        $menus['ad'][] = array('广告列表', $baseProj.'/admin/ad/index');
        // $menus['ad'][] = array('添加广告', $baseProj.'/admin/ad/add');

        $category['user'] = '用户管理';
        $menus['user'][] = array('用户列表', $baseProj.'/admin/user/index');

        $category['sys'] = '系统管理';
        $menus['sys'][] = array('帐号管理', $baseProj.'/admin/manager/list');
        $menus['sys'][] = array('系统设置', $baseProj.'/admin/site/setting');
        $c = $this->controller->id;
        $a = $this->controller->action->id;
        $ac = '';
        $am = '';
        foreach ($menus as $ck => $ms) {
            foreach ($ms as $m) {
                if ('/admin/'.$c.'/'.$a == $m[1]) {
                    $ac = $ck;
                    $am = $baseProj.'/admin/'.$c.'/'.$a;
                }
            }
        }
        $this->render("NavList", compact('category', 'menus', 'c', 'a', 'ac', 'am'));
    }
}
?>

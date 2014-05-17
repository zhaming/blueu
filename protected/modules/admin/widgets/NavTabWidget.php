<?php
class NavTabWidget extends CWidget
{
    public $index;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $full_menu = array();

        $full_menu['manager'][]           = array('平台用户','/admin/manager/list');
        $full_menu['manager'][]           = array('新增','/admin/manager/addmanager');
        

        $full_menu['rule'][]           = array('权限列表','/admin/role/rulelist');
        $full_menu['rule'][]           = array('添加权限','/admin/role/ruleadd');
        
        $full_menu['role'][]           = array('角色列表','/admin/role/rolelist');
        $full_menu['role'][]           = array('添加角色','/admin/role/roleadd');


        $full_menu['category'][]           = array('分类列表','/admin/category/index');
        $full_menu['category'][]           = array('添加分类','/admin/category/add');


        $full_menu['document'][]           = array('文件管理','/admin/document/index');
        $full_menu['document'][]           = array('添加文件','/admin/document/add');

        $full_menu['agency'][] = array('机构列表','/admin/agency/index');
        $full_menu['agency'][] = array('机构分类','/admin/agencycategory/index');
        $full_menu['agency'][] = array('新增分类','/admin/agencycategory/add');

        $full_menu['project'][] = array('项目列表', '/admin/project/index');
        $full_menu['project'][] = array('项目分类','/admin/projectcategory/index');
        $full_menu['project'][] = array('新增分类','/admin/projectcategory/add');


		$full_menu['site'][]             = array('常规设置','/admin/site/setting');


        $full_menu['visit_stat'][]       =array('最近1天','/admin/stat/visit');
        $full_menu['visit_stat'][]       =array('最近7天','/admin/stat/visit_week');
        $full_menu['visit_stat'][]       =array('最近30天','/admin/stat/visit_month');
        $full_menu['user_stat'][]       =array('最近30天','/admin/stat/user');

        $menus = $full_menu[$this->index];
        $current_menu = '/admin/'.$this->controller->id.'/'.$this->controller->action->id;
        $this->render("NavTab", compact('menus', 'current_menu'));
    }
}
?>

<?php

use yii\helpers\Url;
use common\models\Setting;
use common\models\LoanProject;

const FINANCE = 'finance';
$topmenu = $menu = array();

// 一级菜单
$topmenu = array (
	'index'             => array('首页', Url::to(['main/home'])),
	'trip'            => array('行程管理', Url::to(['trip/list'])),
	'system'            => array('系统管理', Url::to(['admin-user/list'])),
	'system'            => array('系统管理', Url::to(['admin-user/list'])),
	'home'            => array('首页管理', Url::to(['home/list'])),
	'personcenter'            => array('个人中心', Url::to(['person-center/person-list'])),
	'content'           => array('内容管理', Url::to(['hq-attachment/list'])),

);

// 二级菜单
$menu['index'] 	= array(
	'menu_home'			=> array('管理中心首页', Url::to(['main/home'])),
);
$menu['trip'] = array(
	'menu_trip_begin'			=> array('行程管理', 'groupbegin'),
	'menu_trip_list'			=> array('行程列表', Url::to(['trip/list'])),
	'menu_trip_add'		=> array('添加行程', Url::to(['trip/add'])),
	'menu_trip_end'	 		=> array('行程管理', 'groupend'),
);

$menu['system'] = array(
	'menu_adminuser_begin'			=> array('系统管理员', 'groupbegin'),
	'menu_adminuser_list'			=> array('管理员管理', Url::to(['admin-user/list'])),
	'menu_adminuser_role_list'		=> array('角色管理', Url::to(['admin-user/role-list'])),
	'menu_adminuser_end'	 		=> array('系统管理员', 'groupend'),
);
$menu['home'] = array(
	'menu_home_begin'			=> array('首页管理', 'groupbegin'),
	'menu_home_banner_list'			=> array('首页banner列表', Url::to(['home/list'])),
	'menu_home_banner_add'		=> array('首页banner添加', Url::to(['home/banner-add'])),
	'menu_home_end'	 		=> array('首页管理', 'groupend'),
);
$menu['personcenter'] = array(
	'menu_personcenter_begin'			=> array('个人中心管理', 'groupbegin'),
	'menu_personcenter_person_list'			=> array('用户列表', Url::to(['person-center/person-list'])),
	'menu_personcenter_member_list'			=> array('会员列表', Url::to(['person-center/member-list'])),
    'menu_personcenter_order_list'			=> array('订单列表', Url::to(['person-center/order-list'])),
    'menu_personcenter_quene_list'			=> array('排队列表', Url::to(['person-center/quene-list'])),
	'menu_home_end'	 		=> array('个人中心管理', 'groupend'),
);
$menu['content'] = array(
	'menu_hfd_attachment_begin'		=> array('附件管理', 'groupbegin'),
	'menu_hfd_attachment_list'		=> array('附件列表', Url::to(['hq-attachment/list'])),
	'menu_hfd_attachment_add'		=> array('添加附件', Url::to(['hq-attachment/add'])),
	'menu_hfd_attachment_end'		=> array('附件管理', 'groupend'),
);




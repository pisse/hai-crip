<?php

namespace backend\components;

use Yii;
use yii\helpers\Html;

class View extends \yii\web\View
{
	/**
	 * 入口文件，不保护域名的目录
	 */
	public $baseUrl;
	
	/**
	 * 域名
	 */
	public $hostInfo;
	
	public function init()
	{
		parent::init();
		$this->baseUrl = Yii::$app->getRequest()->getBaseUrl();
		$this->hostInfo = Yii::$app->getRequest()->getHostInfo();
	}
	
	/**
	 * 显示导航
	 * @param string $topmenuKey	对应一级菜单配置中的key
	 * @param string $menuKey		对应二级菜单配置中的key
	 */
	public function shownav($topmenuKey = '', $menuKey = '')
	{
		include_once '../config/menu.php';
		$topmenuName = !empty($topmenu[$topmenuKey]) ? $topmenu[$topmenuKey][0] : '首页';
		$menuName = !empty($menu[$topmenuKey][$menuKey]) ? $menu[$topmenuKey][$menuKey][0] : '';
		$title = $topmenuName . ($menuName ? '&nbsp;&raquo;&nbsp;'.$menuName : '');
		echo '<script type="text/JavaScript">if(parent.$(\'admincpnav\')) parent.$(\'admincpnav\').innerHTML=\''.$title.'\';</script>';
	}
	
	/**
	 * 显示里页子导航
	 * 每个导航item都是一个页面链接
	 * @param string $title
	 * @param array	 $menus
	 */
	public function showsubmenu($title, $menus = array())
	{
		if (empty($menus)) {
			$s = '<div class="itemtitle"><h3>'.$title.'</h3></div>';
		} elseif (is_array($menus)) {
			$s = '<div class="itemtitle"><h3>'.$title.'</h3><ul class="tab1">';
			foreach ($menus as $k => $menu) {
				$s .= '<li'.($menu[2] ? ' class="current"' : '').'><a href="'.$menu[1].'"'.'><span>'.$menu[0].'</span></a></li>';
			}
			$s .= '</ul></div>';
		}
		echo !empty($menus) ? '<div class="floattop">'.$s.'</div><div class="floattopempty"></div>' : $s;
	}
	
	/**
	 * 显示里页子导航
	 * 每个导航item都是一个锚点，选中的显示，非选中隐藏
	 * @param string $title
	 * @param array	 $menus
	 */
	public function showsubmenuanchors($title, $menus = array())
	{
		if (empty($menus)) {
			$s = '<div class="itemtitle"><h3>'.$title.'</h3></div>';
		} elseif (is_array($menus)) {
			$s = '<div class="itemtitle"><h3>'.$title.'</h3><ul class="tab1" id="submenu">';
			foreach ($menus as $k => $menu) {
				$s .= '<li'.($menu[2] ? ' class="current"' : '').' id="nav_'.$menu[1].'" onclick="showanchor(this);"><a href="#"'.'><span>'.$menu[0].'</span></a></li>';
			}
			$s .= '</ul></div>';
		}
		echo !empty($menus) ? '<div class="floattop">'.$s.'</div><div class="floattopempty"></div>' : $s;
	}
	
	/**
	 * 显示提示信息
	 */
	public function showtips($title, $tips = [])
	{
		if (!$title) {
			$html = '';
		} else {
			$tipsHtml = '';
			if ($tips) {
				$tipsHtml = '<tr><td class="tipsblock"><ul>';
				foreach ($tips as $tip) {
					$tipsHtml .= "<li>{$tip}</li>";
				}
				$tipsHtml .= '</ul></td></tr>';
			}
			$html = <<<EOT
<table class="tb tb2 ">
	<tr><th class="partition">{$title}</th></tr>
	{$tipsHtml}
</table>
EOT;
		}
		echo $html;
	}
	
	/**
	 * 获得模型字段label，必填字段会加上红色"*"号
	 */
	public function activeLabel($model, $attribute, $options = [])
	{
		$requireHtml = '';
		if ($model->isAttributeRequired($attribute)) {
			$requireHtml .= '<font color="red">*</font>';
		}
		return $requireHtml . Html::activeLabel($model, $attribute, $options) . '：';
	}

	/**
	* 生成专属邀请码
	*/
	public function inviteKey($len=6,$format='[a-z0-9]'){
		switch($format){
			case '[A-Za-z0-9]':
			$chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
			break;
			case '[A-Za-z]':
			$chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
			break;
			case '[a-z0-9]':
			$chars='abcdefghijklmnopqrstuvwxyz0123456789';
			break;
			case '\d':
			$chars='0123456789';
			break;
		}
		$charlen = strlen($chars);
		$str = '';
		$len = rand($len,8);
		for($i=1;$i<=$len;$i++){
			$start = rand(0,$charlen);
			$str .= substr($chars,$start,1);
		}
		return $str;
	}

}
<?php
namespace frontend\components;

class ApiUrl extends \yii\helpers\BaseUrl
{
	public static function toRoute($route, $scheme = true)
	{
		$url = parent::toRoute($route, $scheme);
		if (strpos($url, '?') === false) {
			$url .= "?clientType=wap";
		} else {
			$url .= "&clientType=wap";
		}
		return str_replace(
			['frontend/', 'api.668ox.com', 'api.668ox.com'],
			$url
		);
	}
	
	public static function to($url = '', $scheme = true)
	{
		$url = parent::to($url, $scheme);
		if (strpos($url, '?') === false) {
			$url .= "?clientType=wap";
		} else {
			$url .= "&clientType=wap";
		}
		return str_replace(
			['frontend/', 'api.668ox.com', 'api.668ox.com'],
			$url
		);
	}
}
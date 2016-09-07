<?php

namespace frontend\components;

use common\models\Client;

class Request extends \yii\web\Request
{
	/**
	 * 客户端信息
	 */
	private $_client;
	
	public function getClient()
	{
		if (!$this->_client) {
			$this->_client = new Client();
			$this->_client->clientType = $this->get('clientType', '');
			$this->_client->deviceName = $this->get('deviceName', '');
			$this->_client->osVersion = $this->get('osVersion', '');
			$this->_client->appVersion = $this->get('appVersion', '');
			$this->_client->appMarket = $this->get('appMarket', '');
		}
		return $this->_client;
	}
	
	/**
	 * 获得包含host的baseUrl地址
	 */
	public function getAbsoluteBaseUrl()
	{
		return $this->getHostInfo() . $this->getBaseUrl();
	}
	
	/**
	 * 覆盖框架的获取IP地址的实现
	 */
	public function getUserIP()
	{
		if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
			$cip = $_SERVER["HTTP_CLIENT_IP"];
		} elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
			$cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		} elseif (!empty($_SERVER["REMOTE_ADDR"])) {
			$cip = $_SERVER["REMOTE_ADDR"];
		} else{
			$cip = "";
		}
		return $cip;
	}
	
	public function post($name = null, $defaultValue = null)
	{
		if ($this->getClient()->clientType != 'pc') {
			if ($name === null) {
	            return $this->getBodyParams();
	        } else {
	            return $this->getBodyParam($name, $defaultValue);
	        }
		} else {
			// 网站接口暂时特殊处理
			if ($name === null) {
				$value = $this->getBodyParams();
				if ($value === null) {
					return $this->get();
				}
				return $value;
			} else {
				$value = $this->getBodyParam($name, $defaultValue);
				if ($value === null) {
					return $this->get($name, $defaultValue);
				}
				return $value;
			}
		}
	}
}
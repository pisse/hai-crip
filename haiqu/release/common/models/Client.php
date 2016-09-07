<?php

namespace common\models;

/**
 * Client model
 */
class Client
{
	const TYPE_IOS = 'ios';            // ios客户端
	const TYPE_ANDROID = 'android';    // 安卓客户端
	const TYPE_PC = 'pc';              // pc端
	const TYPE_WAP = 'wap';            // m版官网
	const TYPE_H5 = 'h5';              // h5推广落地页
	
	// 终端类型
	public $clientType;
	// 设备名称
	public $deviceName;
	// app版本
	public $appVersion;
	// 终端操作系统版本
	public $osVersion;
	// app来源市场
	public $appMarket;
	
	// 序列化
	public function serialize()
	{
		return serialize([
			'clientType' => $this->clientType,
			'deviceName' => $this->deviceName,
			'appVersion' => $this->appVersion,
			'osVersion' => $this->osVersion,
			'appMarket' => $this->appMarket,
		]);
	}
}
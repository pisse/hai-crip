<?php
namespace console\models;

class XmlPacket {

	public static $XML_PREFIX = '<?xml version="1.0" encoding = "GBK" ?>';

	/*
	 * 生成请求xml格式的参数
	 */
	public static function toXml($xmlStr) {
		$xml_data = self::$XML_PREFIX."<CMBSDKPGK>";
		$xml_data .= $xmlStr;
		return $xml_data."</CMBSDKPGK>";
	}

	public static function getXmlStr($root_node, $param_array) {
		$str = "<$root_node>";
		foreach ($param_array as $key => $value) {
			$str .= "<$key>$value</$key>";
		}
		$str .= "</$root_node>";
		return $str;
	}

	/*
	 * 解析xml格式的返回参数
	 */
	public static function parseXml($xml_data) {  
	    $xml_parser = new XML();
	    $xml_data = stripslashes($xml_data);     
	    $data = &$xml_parser->parse($xml_data);     
	    $xml_parser->destruct();
	    if($data === null) {
	    	return false;
	    }
	    $ret_data = $data["CMBSDKPGK"];
	    echo $ret_data;
	    var_dump($ret_data);    
	    return $ret_data;

	}
}
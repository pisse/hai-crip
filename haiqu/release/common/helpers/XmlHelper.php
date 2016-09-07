<?php

namespace common\helpers;

class XmlHelper
{

	private $dom;

	public function __construct($version = '1.0', $charset = 'UTF-8') {
		$this->dom = new \DOMDocument($version, $charset);
	}

	public function arrayToXml($arr = array(), $firstNode = 'root', $xml = null) {

		if(!self::is_assoc($arr)) {
			return false;
		}

		$root = $this->dom->createElement($firstNode);
		$this->dom->appendChild($root);

		foreach ($arr as $key => $value) {
				
			if (self::is_assoc($value)) {
				
			}

			$$k = $this->dom->createElement($key);
			$root->appendChild($$k);
			$text = $this->dom->createTextNode($value);
			$$k->appendChild($text);
			
		}

		return $this->dom;	
		
	}


	public function is_assoc($arr) {
		if (!is_array($arr)) {
			return false;
		}
		if(count(array_filter(array_keys($arr), 'is_string')) == count($arr)) {
			return true;
		}
		return false;
	}
}


?>
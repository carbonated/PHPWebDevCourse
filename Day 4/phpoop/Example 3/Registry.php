<?php

class Registry {
	
	private static $data = array();
	
	public static function AddData($key, $value) {
		self::$data[$key] = $value;
	}
	
	public static function GetData($name) {
		return self::$data[$name];
	}
	
}

Registry::AddData('username', 'pesho');

echo Registry::GetData('username');
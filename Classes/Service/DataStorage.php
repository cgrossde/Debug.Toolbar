<?php
namespace Debug\Toolbar\Service;

/*                                                                        *
 * This script belongs to the FLOW3 framework.                            *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use TYPO3\FLOW3\Annotations as FLOW3;

/**
 */
class DataStorage {
	static protected $container = array();
	static protected $frozen = false;

	static function set($name, $mixed){
		if(self::$frozen)
			return;

		self::$container[$name] = $mixed;
	}

	static function get($name, $key = null){
		if(!is_null($key) && isset(self::$container[$name]) && is_array(self::$container[$name]))
			return isset(self::$container[$name][$key]) ? self::$container[$name][$key] : null;
		else
			return isset(self::$container[$name]) ? self::$container[$name] : null;
	}

	static function has($name){
		return array_key_exists($name,self::$container);
	}

	static function add($name, $key = null, $value = null){
		if(self::$frozen)
			return;

		if(isset(self::$container[$name]) && !is_array(self::$container[$name])){
			self::$container[$name] = array();
		}
		if($value === null)
			self::$container[$name][] = $key;
		else
			self::$container[$name][$key] = $value;
	}

	static function remove($name){
		if(self::$frozen)
			return;

		unset(self::$container[$name]);
	}

	static function init(){
		if(self::$frozen)
			return;

		self::set("Environment:Token", uniqid());
	}

	static function save() {
		if(self::$frozen)
			return;

		$token = self::$container["Environment:Token"];
		$filename = FLOW3_PATH_DATA . '/Logs/Debug/' . $token . '.debug';
		file_put_contents($filename, serialize(self::$container));
	}

	static function load($token) {
		$filename = FLOW3_PATH_DATA . '/Logs/Debug/' . $token . '.debug';
		$data = file_get_contents($filename);
		self::$container = @unserialize($data);
	}

	static function freeze(){
		self::$frozen = true;
	}
}

?>

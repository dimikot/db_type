<?php
/**
 * Created by PhpStorm.
 * User: nehxby
 * Date: 2 жовт 2010
 * Time: 0:17:57
 * To change this template use File | Settings | File Templates.
 */

function __autoload($classname) {
	if (class_exists($classname, false) || interface_exists($classname, false)) {
		return;
	}
	$path = dirname(__DIR__). DIRECTORY_SEPARATOR. 'lib'. DIRECTORY_SEPARATOR
			. str_replace('_', DIRECTORY_SEPARATOR, $classname). '.php';
	require $path;
}
spl_autoload_register('__autoload');

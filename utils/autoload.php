<?php

function __autoload($classname)
{
	if (class_exists($classname, false) || interface_exists($classname, false)) {
		return;
	}
	$path = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR
		. str_replace('_', DIRECTORY_SEPARATOR, $classname) . '.php';
	require $path;
}

spl_autoload_register('__autoload');

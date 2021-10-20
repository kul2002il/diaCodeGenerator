<?php
spl_autoload_register(function ($classname){
	require_once str_replace('\\', '/', $classname) . '.php';
});

use \DiaReader\DiaFile;

function debug($var)
{
	echo json_encode($var, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
	echo "\n";
}

function onPre()
{
	$file = new DiaFile('input/first.dia');
}

require 'view/index.php';

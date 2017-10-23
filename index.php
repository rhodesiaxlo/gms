<?php
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

//当前目录路径
define('SITE_PATH', getcwd() . '/');
//项目路径
define('APP_PATH', SITE_PATH . 'App/');

define('RUNTIME_PATH','./Runtime/');

define('APP_DEBUG',true);
require './ThinkPHP/ThinkPHP.php';
<?php

// change the following paths if necessary
$yii=dirname(__FILE__).'/../yii/framework/yii.php'; // Change to yiilite.php on production

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
$main_config = require( dirname(__FILE__).'/../protected/config/main.php');
$local_config = require(dirname(__FILE__).'/../protected/config/local.php');
$config = CMap::mergeArray(  $main_config,$local_config  );
Yii::createWebApplication($config)->run();

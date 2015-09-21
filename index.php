<?php

// change the following paths if necessary
$yii=dirname(__FILE__).'/../yii/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

defined('IMAGE_UPLOAD_PATH') or define('IMAGE_UPLOAD_PATH',dirname(__FILE__).DIRECTORY_SEPARATOR."upload/images");
defined('IMAGE_UPLOAD_URI') or define('IMAGE_UPLOAD_URI',"upload/images");

if (!is_dir(IMAGE_UPLOAD_PATH)) {
    mkdir(IMAGE_UPLOAD_PATH, 0755, true);
}

require_once($yii);
Yii::createWebApplication($config)->run();

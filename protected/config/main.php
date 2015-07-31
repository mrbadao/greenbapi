<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'GreenB API Server',
	'timeZone' => 'Asia/Saigon',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool

		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'1',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),

	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),

        // imgur.com upload component
        'imgUrUploader'=>array(
            'class'=>'ext.ImgurUploader',
            'refreshToken'=>'6e97118f0e829c64666042b8db5933e9dcd91490',
            'client_id'=>'9e8880b06317c45',
            'client_secret'=>'fdc4c1cd616d15aabb3bc2e5504a9916840b3e57',
            'user_id'=>'mrbadao',
        ),

		// uncomment the following to enable URLs in path-format

		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName' => false,
			'rules'=>array(
				'gii/<action:\w+>'=> 'gii/<action>',
				array('authentication/authenticate', 'pattern'=>'auth/authenticate', 'verb'=>'POST'),
				array('authentication/validatetoken', 'pattern'=>'auth/validatetoken', 'verb'=>'POST'),
				'posts/<tag:.*?>'=>'post/index',

				// Other controllers
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),

		// uncomment the following to use a MySQL database
        'db'=>array(
            'connectionString' => 'mysql:host=localhost;dbname=greenb_cms',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'initSQLs' => array("SET time_zone = '+07:00';"),
        ),

        'db_printer'=>array(
            'connectionString' => 'mysql:host=localhost;dbname=greenb_printer',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'class' => 'CDbConnection',
            'initSQLs' => array("SET time_zone = '+07:00';"),
        ),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'authentication/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels' => 'info, error, warning',
//					'categories' => 'application',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'duration'=>'7200',
		'cache_duration'=>'3600',
        'requestAgents' => array("Android", "Winform"),
	),
);
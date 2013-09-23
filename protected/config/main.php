<?php
// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'مبين',
	'sourceLanguage' => 'ar_jo',
        'language' => 'ar_jo',
	

	// preloading 'log' component
	'preload'=>array('log'  ),
	
	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.lib.*',
		'ext.imperavi-redactor-widget.*',
		'application.components.twitter.*',
		'application.extensions.MongoYii.*',
	),

	'modules'=>array(
		//'core',
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'gii',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
	),

	// application components
	'components'=>array(
						'badgeManager' => array(
								'class'=>'CBadgeManager',  
								),



    'authManager'=>array(
      'class'=>'CMongoDbAuthManager',
    ),
    


		'elastic' => array(
	      'class' => 'Elastic',
	      'index' => 'mobeen',
	      'host' => '127.0.0.1',
	    ),
/*
        'authManager'=>array(
            'class'=>'CPhpAuthManager',
            //'connectionID'=>'db',
        ),
*/
/*
          'clientScript' => array(
              'class' => 'ext.EClientScript.EClientScript',
              'combineScriptFiles' => true, // By default this is set to false, set this to true if you'd like to combine the script files
              'combineCssFiles' => true, // By default this is set to false, set this to true if you'd like to combine the css files
              'optimizeCssFiles' => true,  // @since: 1.1
              'optimizeScriptFiles' => true,   // @since: 1.1
            ),
*/

		'user'=>array(
			'class' => 'WebUser',

			// enable cookie-based authentication
		),
		'redis'=>array(
			'class'=> 'ext.redis.ARedisConnection',
			'hostname'=>'127.0.0.1',
			'port'=>6379,
			),
		'cache'=>array(
			'class'=>'ext.redis.ARedisCache',
			'hashKey'=>false,
			'keyPrefix'=>'appii:',
			),
		'session' => array(
			'class' => 'SelectiveCacheHttpSession',
			'timeout' => 604800, // 7 days
			'cookieParams' => array(
				//'cookieParams' => array('domain' => '.mydomain.com'), // to include all subdomains
				'httponly' => true,
				'lifetime' => 604800,
			),
		),
		'messages'=>array(
			'forceTranslation' => true,
			),



		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
				'<action:(about|tools|questions|articles)>'=>'site/<action>',
				'profile'=>'user/myprofile',


			),
		),

		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			
            'routes'=>array(
                  array('class'=>'CFileLogRoute', 'logFile' => 'error.log', 'levels'=>'error, warning',),
            ),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	
);

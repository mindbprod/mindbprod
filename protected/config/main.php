<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'MBP',

	// preloading 'log' component
	'preload'=>array('log','errorHandler'), // handle fatal errors),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',  
	),
        'sourceLanguage'=>'00',
        'language'=>'en',
        'aliases' => array(
            'audit' => realpath(__DIR__."/../../vendor/cornernote/yii-audit-module/audit"),
//            'vendor.twbs.bootstrap.dist' => realpath(__DIR__ . '/../extensions/bootstrap'),
            'vendor.twbs.bootstrap.dist'=>realpath(__DIR__."/../../vendor/twbs/bootstrap/dist"),
        ),
	'modules'=>array(
            // uncomment the following to enable the Gii tool
            'gii'=>array(
                    'class'=>'system.gii.GiiModule',
                    'password'=>'root',
                    // If removed, Gii defaults to localhost only. Edit carefully to taste.
                    'ipFilters'=>array('127.0.0.1','::1','192.168.0.*','192.168.1.*'),
            ),
            'audit' => array(
                // path to the AuditModule class
                'class' => 'audit.AuditModule',

                // set this to your user view url,
                // AuditModule will replace --user_id-- with the actual user_id
                'userViewUrl' => array('/user/view', 'iduser' => '--user_id--'),

                // Set to false if you do not wish to track database audits.
                'enableAuditField' => true,

                // The ID of the CDbConnection application component. If not set, a SQLite3
                // database will be automatically created in protected/runtime/audit-AuditVersion.db.
                'connectionID' => 'db',

                // Whether the DB tables should be created automatically if they do not exist. Defaults to true.
                // If you already have the table created, it is recommended you set this property to be false to improve performance.
                'autoCreateTables' => true,

                // The layout used for module controllers.
                'layout' => 'audit.views.layouts.column1',

                // The widget used to render grid views.
                'gridViewWidget' => 'bootstrap.widgets.TbGridView',

                // The widget used to render detail views.
                'detailViewWidget' => 'zii.widgets.CDetailView',

                // Defines the access filters for the module.
                // The default is AuditAccessFilter which will allow any user listed in AuditModule::adminUsers to have access.
                'controllerFilters' => array(
                    'auditAccess' => array('audit.components.AuditAccessFilter'),
                ),

                // A list of users who can access this module.
                'adminUsers' => array('user.admin'),

                // The path to YiiStrap.
                // Only required if you do not want YiiStrap in your app config, for example, if you are running YiiBooster.
                // Only required if you did not install using composer.
                // Please note:
                // - You must download YiiStrap even if you are using YiiBooster in your app.
                // - When using this setting YiiStrap will only loaded in the menu interface (eg: index.php?r=menu).
                'yiiStrapPath' => realpath(__DIR__."/../../vendor/crisu83/yiistrap"),
            ),
	),

	// application components
	'components'=>array(
                
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
//            'enableAutoLogin' => true,
		),
		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
                    'urlFormat'=>'path',
//                    'showScriptName'=>false,
//                    'caseSensitive'=>false,        
                    'rules'=>array(
                        '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                        '<controller:\w+>/<action:\w+>/<id:\d+>/*'=>'<controller>/<action>',
                        '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                    ),
		),
//		'db'=>array(
//			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
//		),
		// uncomment the following to use a MySQL database
		
		'db'=>array(
//			'connectionString' => 'mysql:host=mbpapp.db.3324307.3a8.hostedresource.net;dbname=mbpapp',
//			'emulatePrepare' => true,
//			'username' => 'mbpapp',
//			'password' => 'Mbap2017!',
                    'connectionString' => 'mysql:host=localhost;dbname=mbp',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'root',
			'charset' => 'utf8',
			// don't forget to put `profile` in the log route `levels` below
			
			'enableProfiling' => true,

			// set to true to replace the params with the literal values
			'enableParamLogging' => true,
		),
		
		'errorHandler'=>array(
			// path to the AuditErrorHandler class
                    'class' => 'audit.components.AuditErrorHandler',

                    // set this as you normally would for CErrorHandler
                    'errorAction' => 'site/error',

                    // Set to false to only track error requests.  Defaults to false.
                    'trackAllRequests' => true,

                    // Set to false to not handle fatal errors.  Defaults to true.
                    'catchFatalErrors' => true,

                    // Request keys that we do not want to save in the tracking data.
                    'auditRequestIgnoreKeys' => array('PHP_AUTH_PW', 'password'),
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
                            array(
                                    // path to the AuditLogRoute class
                                'class' => 'audit.components.AuditLogRoute',

                                // can be: trace, warning, error, info, profile
                                // can also be anything else you want to pass as a level to `Yii::log()`
                                'levels' => 'error, warning, profile, audit',
                            ),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
                'clientScript'=>array(
                    'packages'=>array(
                        'jquery'=>array(
                            'baseUrl'=>'https://code.jquery.com/',
                            'js'=>array('jquery-2.2.3.min.js'),
                        )
                    ),
                )
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);
<?php

$mailer = require __DIR__.'/mailer.php';
$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'name' => $params['name'],//'ООО «ДСК Прогресс»',
    'language' => 'ru',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'cvKBKSa9WtXOwfVaa3uqJ7qIL4udAlpn',
            'baseUrl' => ''
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport'        => $mailer,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'profile' => 'profile/index',
                'profile/view/<id:\d+>' => 'profile/view',
                'profile/update/<id:\d+>' => 'profile/update',
                'supplier' => 'supplier/index',
                'supplier/view/<id:\d+>' => 'supplier/view',
                'supplier/update/<id:\d+>' => 'supplier/update',
                'partner' => 'partner/index',
                'partner/view/<id:\d+>' => 'partner/view',
                'partner/update/<id:\d+>' => 'partner/update',
                'order' => 'order/index',
                'order/view/<id:\d+>' => 'order/view',
                'order/update/<id:\d+>' => 'order/update',
                'product' => 'product/index',
                'product/view/<id:\d+>' => 'product/view',
                'product/update/<id:\d+>' => 'product/update',
                'report' => 'report/index',
                'storage' => 'storage/index',
                'setting' => 'setting/index',
                'site' => 'site/index',
            ],
        ],
        'formatter' => [
            'class' => '\app\components\FormatterHelper',
            'defaultTimeZone' => 'Asia/Yekaterinburg',
            'timeZone' => 'Asia/Yekaterinburg',
            'thousandSeparator' => ' ',
            'locale' => 'ru-Ru',
            'currencyCode' => 'RUB',
        ],
        'i18n' => [
            'translations' => [
                'app' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'forceTranslation' => true,
                ],
            ],
        ],
        
        'view' => [
            'class' => 'yii\web\View',
            'renderers' => [
                'twig' => [
                    'class' => 'yii\twig\ViewRenderer',
                    'cachePath' => '@runtime/Twig/cache',
                    // Array of twig options:
                    'options' => [
                        'auto_reload' => true,
                        'debug' => true,
                    ],
                    // 'extensions' => ['\Twig_Extension_Debug'],
                    'globals' => [
                        'html' => ['class' => '\yii\helpers\Html'],
                        'array_helper' => ['class' => 'yii\helpers\ArrayHelper'],
                        'date_picker' => ['class' => 'yii\jui\DatePicker']
                    ],
                    'uses' => ['yii\bootstrap4'],
                ],
                // ...
            ],
        ],
        'response' => [
			'formatters' => [
				'pdf' => [
					'class' => 'robregonm\pdf\PdfResponseFormatter',
				],
			]
		],
    ],
    'params' => array_merge($params, ['mail' => $mailer]),
    'layout' => 'main.twig',
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;

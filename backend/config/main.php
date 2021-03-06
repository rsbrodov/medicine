<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php',
    require __DIR__ . '/main-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'homeUrl' =>'/',
    'language' =>'ru',
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'gridview' =>  [
            'class' => '\kartik\grid\Module',
        ],
    ],
    'layout' => 'admin/main',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
            'baseUrl' => '/admin',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
            'loginUrl' => array('/site/login'),
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
         'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=medicine',
            //'dsn' => 'mysql:host=localhost;port=2620;dbname=medicine',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.yandex.ru',
                'username' => '1@niig.su',
                'password' => 'Lampa6516',
                'port' => 465,
                'encryption' => 'ssl',
            ],
            'useFileTransport' => false,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                /*[
                    'class' => 'yii\log\EmailTarget',
                    'mailer' => 'mailer',
                    'levels' => ['error'],
                    'message' => [
                        'from' => ['1@niig.su'],
                        'to' => ['rsbrodov@mail.ru', 'esperos.nsk@gmail.com'],
                        'subject' => '???????????? ?? ?????????????????? ??????????????',
                    ],
                    'except' => [
                        'yii\web\HttpException:404',
                        'yii\web\HttpException:429',
                        'yii\web\HeadersAlreadySentException'
                    ],
                ],*/
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        /*'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@vendor/hail812/yii2-adminlte3/src/views/'
                ],
            ],
        ],*/
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/login' => 'site/login',
                'defaultRoute' => 'site/index',
                //'<controller><action>' => 'site/index',
            ],
        ],
        /*???????????? ?????? ?????????????????????? ????????????????????????????*/
        'i18n' => [
            'translations' => [
                'backend_navbar*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/translations',
                    //'sourceLanguage' => '',
                    'fileMap' => [
                        'backend_navbar' => 'backend_navbar.php',
                        'app/error' => 'error.php',
                    ],
                ],
            ],
        ],
    ],
    'params' => $params,
];

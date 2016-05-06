<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'v1' => [
            'class' => 'app\modules\v1\Module',
        ],
    ],
    'components' => [
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [

                'POST v1/session' => 'v1/session/login',
                'DELETE v1/session' => 'v1/session/logout',
                'GET v1/me' => 'v1/session/me',

                'PUT v1/account/member' => 'v1/account/register-member',
                'PUT v1/account/supplier' => 'v1/account/register-supplier',
                'GET v1/account/availability/mobile' => 'v1/account/availability-mobile',
                'GET v1/account/availability/email' => 'v1/account/availability-email',
                'PUT v1/account/mobile' => 'v1/account/update-mobile',
                'PUT v1/account/mobile/verify' => 'v1/account/mobile-verify',
                'POST v1/account/otp/resend' => 'v1/account/resend-verification-otp',
                'GET v1/me/basic' => 'v1/account/get-basic-profile',
                'PATCH v1/me/basic' => 'v1/account/update-basic-profile',

                'POST v1/password/reset'=>'v1/account/initiate-reset-password',
                'POST v1/password/token'=>'v1/account/get-password-reset-key',
                'PUT v1/password/update'=>'v1/account/update-password-reset-key',

                'GET v1/config' => 'v1/config/get-for-mobile',
                'GET v1/config/all' => 'v1/config/get-all-for-mobile',
                'GET v1/config/categories' => 'v1/config/get-all-categories',
                'GET v1/config/subcategories' => 'v1/config/get-all-subcategories',

            ],
        ],
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'user' => [
            'identityClass' => 'engine\components\UserIdentity',
            'enableSession' => false,
            'loginUrl' => null
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [

            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'params' => $params,
];

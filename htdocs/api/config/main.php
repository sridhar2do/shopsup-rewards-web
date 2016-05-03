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
                /* ['class' => 'yii\rest\UrlRule', 'pluralize'=>true, 'controller' => 'v1/user'],
                ['class' => 'yii\rest\UrlRule', 'pluralize'=>true, 'controller' => 'v1/city',
                    'tokens' => [
                            '{id}' => '<id:\\w+>',
                    ],
                    'extraPatterns' => [
                        'GET {id}/areas' => 'children',
                    ],
                ],
                ['class' => 'yii\rest\UrlRule', 'pluralize'=>true, 'controller' => 'v1/country',
                    'tokens' => [
                            '{id}' => '<id:\\w+>',
                    ],
                    'extraPatterns' => [
                            'GET {id}/states' => 'children',
                    ],
                ],
                ['class' => 'yii\rest\UrlRule', 'pluralize'=>true, 'controller' => 'v1/state',
                    'tokens' => [
                            '{id}' => '<id:\\w+>',
                    ],
                    'extraPatterns' => [
                            'GET {id}/cities' => 'children',
                    ],
                ],
                ['class' => 'yii\rest\UrlRule', 'pluralize'=>true, 'controller' => 'v1/area' ], */
                /* ['class' => 'yii\rest\UrlRule', 'pluralize'=>true, 'controller' => 'v1/category',
                    'tokens' => [
                            '{id}' => '<id:\\w+>',
                    ],
                    'extraPatterns' => [
                            'GET {id}/parent' => 'parent',
                            'GET {id}/children' => 'children',
                            'GET {id}/brands' => 'brands',
                    ],
                ],
                ['class' => 'yii\rest\UrlRule', 'pluralize'=>true, 'controller' => 'v1/brand',
                    'tokens' => [
                            '{id}' => '<id:\\w+>',
                    ],
                    'extraPatterns' => [
                            'GET {id}/categories' => 'categories',
                    ],
                ], */


                'GET v1/catalog/categories' => 'v1/catalog/get-top-categories',
                'GET v1/catalog/category/<id:\\d+>/' => 'v1/catalog/get-category',
                'GET v1/catalog/category/<id:\\d+>/brands/' => 'v1/catalog/get-category-brands',
                'GET v1/catalog/category/<id:\\d+>/sub' => 'v1/catalog/get-sub-categories',
                'GET v1/catalog/brand/<id:\\w+>/' => 'v1/catalog/get-brand',
                'GET v1/catalog/brands' => 'v1/catalog/get-all-brands',
                'GET v1/catalog/brand/<id:\\d+>/categories/' => 'v1/catalog/get-brand-categories',

                'GET v1/wishlist' => 'v1/wishlist/get-all',
                'GET v1/wishlist/<sku_id:\\w+>' => 'v1/wishlist/get',
                'POST v1/wishlist' => 'v1/wishlist/add-wishlist',
                'DELETE v1/wishlist' => 'v1/wishlist/remove-wishlist',

                'GET v1/product/<product_id:\\d+>' => 'v1/product/get',
                'GET v1/product/<product_id:\\d+>/reviews' => 'v1/product/get-reviews',
                'GET v1/sku/<sku_id:\\w+>' => 'v1/product/get-sku',
                'GET v1/sku/<sku_id:\\w+>/detail' => 'v1/product/get-product-by-sku',
                'GET v1/sku/<sku_id:\\w+>/stores' => 'v1/product/get-stores-by-sku',
                'GET v1/inventory/<inventory_id:\\w+>' => 'v1/product/get-inventory',
                'GET v1/store/contact'=>'v1/product/get-contact-number',

                'POST v1/search/image' => 'v1/search/image',
                'GET v1/search/image' => 'v1/search/image-url',
                'GET v1/search/color' => 'v1/search/color',
                'POST v1/search/detect' => 'v1/search/detect-image',
                'GET v1/search/detect' => 'v1/search/detect-image-url',

                'GET v1/sell/related' => 'v1/sell/related',
                'GET v1/sell/similar' => 'v1/sell/similar',

                'GET v1/stores' => 'v1/store/index',
                'GET v1/stores/<id:\\d+>/' => 'v1/store/view',

                'GET v1/option/<type:\\w+>/all' => 'v1/option/get-all-in-type',

                'GET v1/config' => 'v1/config/get-for-mobile',
                'GET v1/config/all' => 'v1/config/get-all-for-mobile',

                'GET v1/feed' => 'v1/feed/get',

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

                'GET v1/service/catalog' => 'v1/service/is-catalog-available-in-location',
                'GET v1/service/catalog/cities' => 'v1/service/catalog-service-cities',
                'GET v1/service/catalog/areas' => 'v1/service/catalog-service-areas'
            ],
        ],
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'user' => [
            'identityClass' => 'common\models\User',
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

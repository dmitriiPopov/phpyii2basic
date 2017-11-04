<?php
/**
 * File with common configuration (for WEB and CONSOLE)
 */

$params = \yii\helpers\ArrayHelper::merge(require(__DIR__ . '/params.php'), require(__DIR__ . '/local/params.php'));


return [

    'components' => [
//        'i18n' => [
//            'translations' => [
//                'user*' => [
//                    'class'          => 'yii\i18n\PhpMessageSource',
//                    'basePath'       => __DIR__ . '/messages',
//                    'sourceLanguage' => 'en-US'
//                ],
//            ],
//        ],
    ],

    'modules' => [

    ],

    'params'  => $params,

];
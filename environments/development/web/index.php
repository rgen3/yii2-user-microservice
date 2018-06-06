<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');
defined('ROOT_DIR') or define('ROOT_DIR', __DIR__ . '/..');

require ROOT_DIR . '/vendor/autoload.php';
require ROOT_DIR . '/vendor/yiisoft/yii2/Yii.php';

$config = yii\helpers\ArrayHelper::merge(
    require ROOT_DIR . '/config/main.php',
    require ROOT_DIR . '/config/main-local.php'
);

require ROOT_DIR . '/helpers.php';

(new yii\web\Application($config))->run();

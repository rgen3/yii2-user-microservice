<?php
declare(strict_types = 1);

if (!function_exists('db')) {
    /**
     * @return \yii\db\Connection
     */
    function db(): \yii\db\Connection
    {
        return Yii::$app->db;
    }
}

if (!function_exists('app')) {
    /**
     * @return Yii
     */
    function app(): \yii\web\Application
    {
        return Yii::$app;
    }
}

if (!function_exists('logger')) {
    /**
     * @param string $message
     * @param string $level
     */
    function logger(string $message, string $level = 'info'): void
    {
        switch ($level) {
            case 'error':
                Yii::error($message, \yii\log\Logger::LEVEL_ERROR);
                break;
            case 'warning':
                Yii::warning($message, \yii\log\Logger::LEVEL_WARNING);
                break;
            case 'info':
                Yii::info($message, \yii\log\Logger::LEVEL_INFO);
                break;
            default:
                throw new InvalidArgumentException("Invalid log level '$level'");

        }
    }
}

if (!function_exists('redis')) {
    /**
     * @return \yii\redis\Connection
     */
    function redis(): yii\redis\Connection
    {
       return Yii::$app->redis;
    }
}

if (!function_exists('jwt')) {
    /**
     * @return \app\models\JwtToken
     */
    function jwt(): \app\models\JwtToken
    {
        return new \app\models\JwtToken();
    }
}

if (!function_exists('sp')) {
    /**
     * @return \Rgen3\QueryBuilder
     */
    function sp(): \Rgen3\QueryBuilder
    {
        return new \Rgen3\QueryBuilder();
    }
}

if (!function_exists('execSp')) {
    /**
     * @param \Rgen3\QueryBuilder $builder
     * @return array
     * @throws \yii\db\Exception
     */
    function execSp(\Rgen3\QueryBuilder $builder)
    {
        return db()->createCommand(new \yii\db\Expression($builder->getSql()))->queryAll();
    }
}

if (!function_exists('execOneSp')) {
    /**
     * @param \Rgen3\QueryBuilder $builder
     * @return array|false
     * @throws \yii\db\Exception
     */
    function execOneSp(\Rgen3\QueryBuilder $builder)
    {
        return db()->createCommand(new \yii\db\Expression($builder->getSql()))->queryOne();
    }
}

if (!function_exists('dd')) {
    function dd($value)
    {
        var_dump($value);
        die();
    }
}

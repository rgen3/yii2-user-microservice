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

if (!function_exists('log')) {
    /**
     * @param string $message
     * @param string $level
     */
    function log(string $message, string $level = 'info'): void
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

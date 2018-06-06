<?php
declare(strict_types = 1);

namespace app\exceptions\jwt;

use app\exceptions\BaseException;

class InvalidTokenException extends BaseException
{
    protected $message = 'Token is invalid';
    protected $code = self::ERROR_TOKEN_IS_INVALID;
}
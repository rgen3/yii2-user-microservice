<?php
declare(strict_types = 1);

namespace app\exceptions\jwt;

use app\exceptions\BaseException;

class InvalidRefreshTokenException extends BaseException
{
    protected $message = 'Invalid refresh token exception';
    protected $code = self::ERROR_REFRESH_TOKEN_IS_INVALID;
}

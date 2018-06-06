<?php
declare(strict_types = 1);

namespace app\exceptions\jwt;

use app\exceptions\BaseException;

class TokenNotFoundException extends BaseException
{
    protected $message = 'Token not found';
    protected $code = BaseException::ERROR_TOKEN_NOT_FOUND;
}

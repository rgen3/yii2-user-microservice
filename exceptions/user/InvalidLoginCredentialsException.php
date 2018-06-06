<?php
declare(strict_types = 1);

namespace app\exceptions\user;

use app\exceptions\BaseException;

class InvalidLoginCredentialsException extends BaseException
{
    protected $message = 'Invalid user name or password';
    protected $code = BaseException::ERROR_INVALID_LOGIN_CREDENTIALS;
}
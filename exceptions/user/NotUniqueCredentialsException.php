<?php
declare(strict_types = 1);

namespace app\exceptions\user;

use app\exceptions\BaseException;

class NotUniqueCredentialsException extends BaseException
{
    protected $message = 'User name or email has already been taken';
    protected $code = BaseException::ERROR_USERNAME_OR_EMAIL_ALREADY_TAKEN;
}
<?php
declare(strict_types = 1);

namespace app\exceptions\jwt;

use app\exceptions\BaseException;

class FailedSavingJwtTokenException extends BaseException
{
    protected $message = 'Error saving jwt token';
    protected $code = BaseException::ERROR_SAVING_JWT_TOKEN;
}

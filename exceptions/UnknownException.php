<?php
declare(strict_types = 1);

namespace app\exceptions;

class UnknownException extends BaseException
{
    protected $code = BaseException::ERROR_UNKNOWN_EXCEPTION;
    protected $message = 'Something wrong';

    public function __construct(?string $message = null)
    {
        parent::__construct();
        if (!is_null($message))
        {
            $this->message = $message;
        }
    }
}
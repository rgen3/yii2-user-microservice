<?php
declare(strict_types = 1);

namespace app\exceptions;

use app\exceptions\jwt\FailedSavingJwtTokenException;
use app\exceptions\jwt\TokenNotFoundException;
use app\exceptions\user\InvalidLoginCredentialsException;
use app\exceptions\user\NotUniqueCredentialsException;

abstract class BaseException extends \Exception
{
    public const ERROR_UNKNOWN_EXCEPTION = 1;
    public const ERROR_USERNAME_OR_EMAIL_ALREADY_TAKEN = 1000;
    public const ERROR_INVALID_LOGIN_CREDENTIALS = 1010;

    public const ERROR_SAVING_JWT_TOKEN = 2000;
    public const ERROR_TOKEN_NOT_FOUND = 2001;
    public const ERROR_TOKEN_IS_INVALID = 2002;
    public const ERROR_REFRESH_TOKEN_IS_INVALID = 2003;

    public function __construct()
    {
        parent::__construct($this->message, $this->code);
    }

    /**
     * @param int $errorCode
     * @throws \Exception
     */
    public static function throwExceptionIfAny(int $errorCode)
    {
        if ($errorCode !== 0) {
            throw self::createFromErrorCode($errorCode);
        }
    }

    public static function createFromErrorCode(int $errorCode): \Exception
    {
        switch ($errorCode) {
            case self::ERROR_USERNAME_OR_EMAIL_ALREADY_TAKEN:
                return new NotUniqueCredentialsException();
            case self::ERROR_INVALID_LOGIN_CREDENTIALS:
                return new InvalidLoginCredentialsException();
            case self::ERROR_SAVING_JWT_TOKEN:
                return new FailedSavingJwtTokenException();
            case self::ERROR_TOKEN_NOT_FOUND:
                return new TokenNotFoundException();
            default:
                return new UnknownException('Unknown error code ' . $errorCode);
        }
    }
}

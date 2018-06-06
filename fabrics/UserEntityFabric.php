<?php
declare(strict_types = 1);

namespace app\fabrics;

use app\entities\User;
use app\http\requests\auth\LoginRequest;
use app\http\requests\auth\RegistrationRequest;

class UserEntityFabric
{
    public static function createFromDbRow(array $data): User
    {
        return new User();
    }

    public static function createById(int $userId): User
    {

    }

    public static function createFromRegistrationRequest(RegistrationRequest $request): User
    {
        return (new User())
            ->setEmail($request->email)
            ->setUsername($request->username)
            ->setPassword($request->password);
    }

    public static function createFromLoginRequest(LoginRequest $loginRequest): User
    {
        return (new User())
            ->setEmail($loginRequest->email)
            ->setUsername($loginRequest->username)
            ->setPassword($loginRequest->password);
    }
}
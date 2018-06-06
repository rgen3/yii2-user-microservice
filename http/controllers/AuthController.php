<?php
declare(strict_types = 1);

namespace app\http\controllers;

use app\http\requests\auth\LogoutRequest;
use app\models;
use app\exceptions\user\InvalidLoginCredentialsException;
use app\exceptions\user\NotUniqueCredentialsException;
use app\fabrics\UserEntityFabric;
use app\http\requests\auth\LoginRequest;
use app\http\requests\auth\RegistrationRequest;
use yii\web\BadRequestHttpException;

class AuthController extends BaseController
{
    /**
     * @param LoginRequest $loginRequest
     * @return array
     * @throws BadRequestHttpException
     * @throws \Rgen3\Exception\InvalidFieldType
     * @throws \yii\db\Exception
     */
    public function actionLogin(LoginRequest $loginRequest)
    {
        $user = UserEntityFabric::createFromLoginRequest($loginRequest);
        try {
            $userId = (new models\User($user))->checkLogin();
        } catch (InvalidLoginCredentialsException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        $token = jwt()->generate($userId, []);

        $refreshToken = jwt()->saveToken($token);

        return $this->success([
            'token' => (string) $token,
            'refreshToken' => $refreshToken,
        ]);
    }

    /**
     * @param LogoutRequest $logoutRequest
     * @return array
     * @throws \Rgen3\Exception\InvalidFieldType
     * @throws \yii\db\Exception
     */
    public function actionLogout(LogoutRequest $logoutRequest)
    {
        if ($this->rawClientToken !== $logoutRequest->token) {
            $this->hasAccess('admin');
        }

        $token = $logoutRequest->getToken();
        jwt()->revokeToken($token->getClaim('jti'));
        return $this->success(['tokenId' => $token->getClaim('jti')]);
    }

    /**
     * @param RegistrationRequest $registrationRequest
     * @return array
     * @throws InvalidLoginCredentialsException
     * @throws \Rgen3\Exception\InvalidFieldType
     * @throws \yii\db\Exception
     */
    public function actionRegistration(RegistrationRequest $registrationRequest)
    {
        $user = UserEntityFabric::createFromRegistrationRequest($registrationRequest);
        try {
            $model = (new models\User($user))->register();
        } catch (NotUniqueCredentialsException $e) {
            throw new InvalidLoginCredentialsException($e->getMessage());
        }
        // TODO: send confirmation code throughout a service
        return $this->success([
            'user_id' => $model->getId(),
        ]);
    }

    public function actionConnect()
    {}
}
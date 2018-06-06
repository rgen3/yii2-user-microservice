<?php
declare(strict_types = 1);

namespace app\http\controllers;

use app\exceptions\jwt\InvalidTokenException;
use app\http\requests\security\RefreshTokenRequest;
use app\http\requests\security\RevokeTokenRequest;
use app\http\requests\security\VerifyTokenRequest;
use app\models\JwtToken;
use Lcobucci\JWT\Parser;

class SecurityController extends BaseController
{
    /**
     * @param VerifyTokenRequest $verifyTokenRequest
     * @return array
     */
    public function actionVerifyToken(VerifyTokenRequest $verifyTokenRequest)
    {
        if (is_null($this->clientToken)) {
            return $this->success([
                'result' => 'false',
            ]);
        }

        return $this->success(['result' => (new JwtToken())->isVerified($verifyTokenRequest->getToken())]);
    }

    /**
     * @param RefreshTokenRequest $refreshTokenRequest
     * @return array
     * @throws InvalidTokenException
     * @throws \Rgen3\Exception\InvalidFieldType
     * @throws \app\exceptions\jwt\InvalidRefreshTokenException
     * @throws \yii\db\Exception
     */
    public function actionRefreshToken(RefreshTokenRequest $refreshTokenRequest)
    {
        $token = $refreshTokenRequest->getToken();
        if (!jwt()->isVerified($token)) {
            throw new InvalidTokenException();
        }

        $data = jwt()->refreshToken(
            $refreshTokenRequest->getToken(),
            $refreshTokenRequest->refreshToken
        );

        return $this->success($data);
    }

    /**
     * @param RevokeTokenRequest $revokeTokenRequest
     * @return array
     * @throws \Rgen3\Exception\InvalidFieldType
     * @throws \yii\db\Exception
     */
    public function actionRevokeToken(RevokeTokenRequest $revokeTokenRequest)
    {
        // TODO: check if user can revoke this token
        (new JwtToken())->revokeToken($revokeTokenRequest->tokenId);
        return $this->success([]);
    }

    public function actionRevokeAllTokens()
    {

    }

    public function actionGetPublicKey()
    {
        return $this->success(['key' => JwtToken::getPublicKey()]);
    }
}

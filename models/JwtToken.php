<?php
declare(strict_types = 1);

namespace app\models;

use app\exceptions\BaseException;
use app\exceptions\jwt\InvalidRefreshTokenException;
use app\exceptions\jwt\TokenNotFoundException;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Signer\Rsa\Sha512;
use Lcobucci\JWT\Token;

class JwtToken
{
    private const TOKEN_REFRESH_TIME = '60 minutes';
    private const TOKEN_LIFETIME = '14 days';
    // userId.id
    private const REDIS_KEY_TOKEN_SAVE = 'jwt.%s.%s';
    private const REDIS_KEY_REFRESH_TOKEN = 'jwt.refresh.%s';
    private const REDIS_KEY_TOKEN_REVOKE = 'jwt.revoked.%s';

    private $signer;

    public function __construct()
    {
        $this->signer = new Sha512();
    }

    private static function getPrivateKey(): string
    {
        return file_get_contents(\Yii::getAlias('@privateKey'));
    }

    public function getPublicKey(): string
    {
        return file_get_contents(\Yii::getAlias('@publicKey'));
    }

    /**
     * @param int $userId
     * @param array $scopes
     * @return Token
     */
    public function generate(int $userId, array $scopes): Token
    {
        $token = (new Builder())
            ->setIssuer('mu')
            ->setAudience('learnoff')
            ->setId($this->generateUUID(), true)
            ->setIssuedAt(time())
            ->setNotBefore(strtotime(self::TOKEN_REFRESH_TIME))
            ->setExpiration(strtotime(self::TOKEN_LIFETIME))
            ->set('userId', $userId)
            ->set('scope', $scopes)
            ->sign($this->signer, new Key(self::getPrivateKey()))
            ->getToken();

        return $token;
    }

    /**
     * @param Token $token
     * @return string refresh token
     * @throws \Rgen3\Exception\InvalidFieldType
     * @throws \yii\db\Exception
     */
    public function saveToken(Token $token): string
    {
        $row = execOneSp(
            sp()
                ->select([
                    'o_error:error',
                    'o_refresh_token:"refreshToken"'
                ])
                ->from('save_token')
                ->fields([
                    'i_token_id:uuid' => $token->getClaim('jti'),
                    'i_user_id:int' => $token->getClaim('userId'),
                    'i_token:text' => (string) $token,
                ])
        );

        BaseException::throwExceptionIfAny($row['error']);

        redis()->setex(
            sprintf(
                self::REDIS_KEY_TOKEN_SAVE,
                $token->getClaim('userId'),
                $token->getClaim('jti')
            ),
            strtotime(self::TOKEN_LIFETIME) - time(),
            (string) $token
        );

        redis()->setex(
            sprintf(
                self::REDIS_KEY_REFRESH_TOKEN,
                $token->getClaims('jti')
            ),
            strtotime(self::TOKEN_LIFETIME) - time(),
            $row['refreshToken']
        );

        return $row['refreshToken'];
    }

    /**
     * @param string $tokenId
     * @throws \Rgen3\Exception\InvalidFieldType
     * @throws \yii\db\Exception
     */
    public function revokeToken(string $tokenId, ?int $userId = null)
    {
        $row = execOneSp(
            sp()->select(['o_active_until:"activeUntil"'])
            ->from('revoke_token')
            ->fields([
                'i_token_id:uuid' => $tokenId,
                'i_user_id:bigint:nullable' => $userId
            ])
        );

        if (!is_null($row['activeUntil'])) {
            $date = \DateTime::createFromFormat('Y-m-d H:i:s.u', $row['activeUntil']);
            redis()->setex(
                sprintf(self::REDIS_KEY_TOKEN_REVOKE, $tokenId),
                $date->getTimestamp() - time(),
                true
            );
        } else {
            logger("Token $tokenId is not found");
        }
    }

    /**
     * @param Token $token
     * @param string $refreshToken
     * @return array
     * @throws InvalidRefreshTokenException
     * @throws \Rgen3\Exception\InvalidFieldType
     * @throws \yii\db\Exception
     */
    public function refreshToken(Token $token, string $refreshToken): array
    {
        $jti = $token->getClaim('jti');
        $savedRefreshToken = redis()->get(sprintf(self::REDIS_KEY_REFRESH_TOKEN, $jti));

        if ($savedRefreshToken !== $refreshToken) {
            throw new InvalidRefreshTokenException();
        }

        $this->revokeToken($jti, $token->getClaim('userId'));

        $token = $this->generate($token->getClaim('userId'), $token->getClaim('scope'));
        $refreshToken = $this->saveToken($token);

        return [
            'token' => $token,
            'refreshToken' => $refreshToken,
        ];
    }

    public function isVerified(Token $token): bool
    {
        if (!$token->verify($this->signer, new Key($this->getPublicKey()))) {
            return false;
        }

        if ($token->isExpired()) {
            return false;
        }

        try {
            return !$this->isRevoked($token);
        } catch (TokenNotFoundException $e) {
            logger($e->getMessage());
            return false;
        }
    }

    /**
     * @param string $token
     * @return Token
     */
    public function parseToken(string $token): Token
    {
        return (new Parser())->parse($token);
    }

    /**
     * @param Token $token
     * @return bool
     * @throws \Rgen3\Exception\InvalidFieldType
     * @throws \yii\db\Exception
     * @throws TokenNotFoundException
     */
    private function isRevoked(Token $token): bool
    {
        $result = redis()->mget(sprintf(self::REDIS_KEY_TOKEN_REVOKE, $token->getClaim('jti')));
        $isRevoked = current($result);

        if (is_null($isRevoked)) {
            $result = execOneSp(
                sp()->select(['o_error:error', 'o_is_revoked:"isRevoked"'])
                    ->from('is_token_revoked')
                    ->fields([
                        'i_token_id:uuid' => $token->getClaim('jti')
                    ])
            );

            BaseException::throwExceptionIfAny($result['error']);
            $isRevoked = $result['isRevoked'];
        }

        return (bool) $isRevoked;
    }

    /**
     * @return string
     */
    public function generateUUID(): string
    {
        return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
            mt_rand( 0, 0xffff ),
            mt_rand( 0, 0x0fff ) | 0x4000,
            mt_rand( 0, 0x3fff ) | 0x8000,
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        );
    }
}
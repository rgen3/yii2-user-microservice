<?php
declare(strict_types = 1);

namespace app\http\requests\security;

use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Token;
use yii\base\Model;

class RefreshTokenRequest extends Model
{
    public $token;
    public $refreshToken;

    public function rules()
    {
        return [
            ['token', 'string'],
            ['token', 'safe'],
            ['refreshToken', 'string'],
            ['refreshToken', 'safe'],
        ];
    }

    public function getToken(): Token
    {
        return (new Parser())->parse($this->token);
    }
}

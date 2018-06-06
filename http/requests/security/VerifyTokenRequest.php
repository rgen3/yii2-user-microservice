<?php
declare(strict_types = 1);

namespace app\http\requests\security;

use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Token;
use yii\base\Model;

class VerifyTokenRequest extends Model
{
    public $token;

    public function rules()
    {
        return [
            ['token', 'string'],
        ];
    }

    public function getToken(): Token
    {
        return (new Parser())->parse($this->token);
    }
}
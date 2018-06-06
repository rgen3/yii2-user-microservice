<?php
declare(strict_types = 1);

namespace app\http\requests\auth;

use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Token;
use yii\base\Model;

class LogoutRequest extends Model
{
    public $token;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            ['token', 'string'],
            ['token', 'safe'],
        ];
    }

    public function getToken(): Token
    {
        return (new Parser())->parse($this->token);
    }
}

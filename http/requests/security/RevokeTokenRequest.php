<?php
declare(strict_types = 1);

namespace app\http\requests\security;

use yii\base\Model;

class RevokeTokenRequest extends Model
{
    public $tokenId;
    public $refreshToken;

    public function rules()
    {
        return [
            ['tokenId', 'string'],
            ['tokenId', 'safe'],
            ['refreshToken', 'string'],
            ['refreshToken', 'safe'],
        ];
    }
}

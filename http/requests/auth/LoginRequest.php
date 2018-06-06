<?php
declare(strict_types = 1);

namespace app\http\requests\auth;

use yii\base\Model;

class LoginRequest extends Model
{
    public $username;
    public $email;
    public $password;

    public function rules()
    {
        return [
            [['username', 'email', 'password'], 'string'],
            [['username', 'email', 'password'], 'safe'],
            ['password', 'required'],
        ];
    }
}

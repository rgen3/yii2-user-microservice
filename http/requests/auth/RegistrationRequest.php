<?php
declare(strict_types = 1);

namespace app\http\requests\auth;

use app\entities\User;
use yii\base\Model;

class RegistrationRequest extends Model
{
    public $username;
    public $password;
    public $email;
    public $motherLanguage;

    public function rules()
    {
        return [
            ['username', 'safe'],
            ['username', 'string', 'max' => 255],
            ['password', 'safe'],
            ['password', 'string', 'min' => 6],
            ['email', 'email'],
            ['email', 'string', 'max' => 100],
            ['motherLanguage', 'safe'],
            ['motherLanguage', 'string', 'length' => 3],
            ['motherLanguage', 'default', 'value' => User::LANGUAGE_RUS],
            [['username', 'email', 'password'], 'required'],
        ];
    }
}

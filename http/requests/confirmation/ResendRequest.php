<?php
declare(strict_types = 1);

namespace app\http\requests\confirmation;

use yii\base\Model;

class ResendRequest extends Model
{
    public $type;
    public $contact;
    public $confirmationCode;

    public function rules()
    {
        return [
            ['type', 'in', 'range' => ['main', 'other']],
            ['contact', 'safe'],
            ['contact', 'string', 'max' => 100],
            ['confirmationCode', 'safe'],
            ['confirmationCode', 'string'],
        ];
    }
}
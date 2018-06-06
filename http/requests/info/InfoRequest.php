<?php
declare(strict_types = 1);

namespace app\http\requests\info;

use yii\base\Model;

class InfoRequest extends Model
{
    /** @var int */
    public $id;

    /** */
    public function rules()
    {
        return [
            ['id', 'integer'],
        ];
    }
}
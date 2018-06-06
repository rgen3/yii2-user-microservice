<?php
declare(strict_types = 1);

namespace app\http\requests\info;

use app\http\requests\BaseJsonRequest;

class JsonSchemaRequest extends BaseJsonRequest
{
    /** */
    public function schema(): string
    {
        return 'test.json';
    }
}
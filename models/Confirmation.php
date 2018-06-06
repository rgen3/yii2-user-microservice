<?php
declare(strict_types = 1);

namespace app\models;

class Confirmation
{
    public function userEmail($userId, $confirmationCode)
    {}

    public function confirmContact($userId, $confirmationCode, $contactType)
    {}
}
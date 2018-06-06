<?php
declare(strict_types = 1);

namespace app\models;

use app\fabrics\UserEntityFabric;

class UserSearch
{
    public function findById(int $id): \app\entities\User
    {
        $row = execOneSp(
            sp()
                ->from('find_user')
                ->fields([
                    'i_user_id:int' => $id
                ])
        );

        return UserEntityFabric::createFromDbRow($row);
    }

    public function findByIds()
    {}

    public function findByEmail()
    {}

    public function findByUsername()
    {}
}
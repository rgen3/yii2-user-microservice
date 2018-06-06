<?php
declare(strict_types = 1);

namespace app\repositories\driver;

use app\entities\User as UserEntity;
use app\fabrics\UserEntityFabric;

class User
{
    public function getById(int $id): UserEntity
    {
        return $this->findUser(['i_user_id:integer' => $id]);
    }

    /**
     * @param $username
     * @param $email
     * @param $password
     * @return bool
     * @throws \Rgen3\Exception\InvalidFieldType
     */
    public function isValidCredentials($username, $email, $password): bool
    {
        return execOneSp(
            sp()
                ->from('check_credentials')
            ->fields([
                'i_username:varchar:nullable' => $username,
                'i_email:varchar:nullable' => $email,
                'i_password:varchar' => $password,
            ])
        )['check_credentials'] ?? false;
    }

    public function getByIds()
    {

    }

    public function getByEmail(string $email): UserEntity
    {
       return $this->findUser(['i_email:varchar' => $email]);
    }

    public function getByUserName(string $username): UserEntity
    {
        return $this->findUser(['i_username:varchar' => $username]);
    }

    private function findUser(array $conditions)
    {
        $result = execOneSp(
            sp()->from('find_user')
                ->fields($conditions)
        );

        if (!$result) {
            throw new \Exception('User not found');
        }

        return UserEntityFabric::createFromDbRow($result);
    }
}

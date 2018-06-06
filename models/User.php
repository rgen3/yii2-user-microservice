<?php
declare(strict_types = 1);

namespace app\models;

use app\exceptions\BaseException;
use app\entities;

class User
{
    private $userEntity;

    public function __construct(\app\entities\User $entity)
    {
        $this->userEntity = $entity;
    }

    /**
     * @return int
     * @throws \Rgen3\Exception\InvalidFieldType
     * @throws \yii\db\Exception
     */
    public function register(): entities\User
    {
        $result = execOneSp(
            sp()
                ->from('create_user')
                ->fields([
                    'i_username:varchar' => $this->userEntity->getUserName(),
                    'i_email:varchar' => $this->userEntity->getEmail(),
                    'i_password:text' => $this->userEntity->getPassword(),
                    'i_status:int' => entities\User::STATUS_NEW,
                    'i_role:int' => entities\User::ROLE_USER,
                ])
        );

        BaseException::throwExceptionIfAny($result['o_error']);

        return $this
            ->userEntity
            ->setId($result['o_id'])
            ->setConfirmationCode($result['o_confirmation_code']);
    }

    /**
     * @return bool
     * @throws \Rgen3\Exception\InvalidFieldType
     * @throws \yii\db\Exception
     */
    public function checkLogin(): int
    {
        $result = execOneSp(
                sp()
                    ->select([
                        'o_user_id:"userId"',
                        'o_error:error'
                    ])
                    ->from('check_credentials')
                    ->fields([
                        'i_username:varchar:nullable' => $this->userEntity->getUsername(),
                        'i_email:varchar:nullable' => $this->userEntity->getEmail(),
                        'i_password:varchar' => $this->userEntity->getPassword(),
                    ])
            );

        BaseException::throwExceptionIfAny($result['error']);

        return $result['userId'];
    }

    public function update()
    {}

    public function confirmEmail()
    {}

}
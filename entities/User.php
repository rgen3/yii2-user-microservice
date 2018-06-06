<?php
declare(strict_types = 1);

namespace app\entities;

use app\http\requests\auth\RegistrationRequest;

class User
{
    const STATUS_DELETED = -100;
    const STATUS_BLOCKED = -2;
    const STATUS_BANNED = -1;
    const STATUS_NEW = 0;
    const STATUS_CONFIRMED = 1;

    const ROLE_USER = 10;
    const ROLE_MODERATOR = 20;
    const ROLE_ADMINISTRATOR = 30;

    const LANGUAGE_RUS = 'RUS';

    private $id;
    private $username;
    private $motherLanguage;
    private $firstName;
    private $lastName;
    private $patronymic;
    private $email;
    private $confirmationCode;
    private $password;
    private $passwordHash;
    private $newPassword;
    private $role;

    public function getId()
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }

    public function getConfirmationCode(): ?string
    {
        return $this->confirmationCode;
    }

    public function setConfirmationCode(string $confirmationCode): self
    {
        $this->confirmationCode = $confirmationCode;
        return $this;
    }

    public function getMotherLanguage()
    {
        return $this->motherLanguage ?? 'RUS';
    }

    public function setMotherLanguage(string $motherLanguage): self
    {
        $this->motherLanguage = $motherLanguage;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getPatronymic()
    {
        return $this->patronymic;
    }

    public function setPatronymic(string $patronymic): self
    {
        $this->patronymic = $patronymic;
        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getPasswordHash()
    {
        return $this->passwordHash;
    }

    public function setPasswordHash(string $passwordHash): self
    {
        $this->passwordHash = $passwordHash;
        return $this;
    }

    public function getNewPassword()
    {
        return $this->newPassword;
    }

    public function setNewPassword(string $newPassword): self
    {
        $this->newPassword = $newPassword;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole(int $role): self
    {
        $this->role = $role;
        return $this;
    }
}
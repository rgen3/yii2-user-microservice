<?php
declare(strict_types = 1);

namespace app\entities;

class Contact
{
    /** @var int */
    private $id;

    /** @var int */
    private $userId;

    /** @var int */
    private $contactType;

    /** @var string */
    private $contact;

    /** @var bool */
    private $isConfirmed;

    /** @var string|null */
    private $confirmationCode;

    /** @var \DateTime */
    private $createdAt;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Contact
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     * @return Contact
     */
    public function setUserId(int $userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return int
     */
    public function getContactType(): int
    {
        return $this->contactType;
    }

    /**
     * @param int $contactType
     * @return Contact
     */
    public function setContactType(int $contactType): self
    {
        $this->contactType = $contactType;
        return $this;
    }

    /**
     * @return string
     */
    public function getContact(): string
    {
        return $this->contact;
    }

    /**
     * @param string $contact
     * @return Contact
     */
    public function setContact(string $contact): self
    {
        $this->contact = $contact;
        return $this;
    }

    /**
     * @return bool
     */
    public function isConfirmed(): bool
    {
        return $this->isConfirmed;
    }

    /**
     * @param bool $isConfirmed
     * @return Contact
     */
    public function setIsConfirmed(bool $isConfirmed): self
    {
        $this->isConfirmed = $isConfirmed;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getConfirmationCode(): ?string
    {
        return $this->confirmationCode;
    }

    /**
     * @param null|string $confirmationCode
     * @return Contact
     */
    public function setConfirmationCode(?string $confirmationCode = null): self
    {
        $this->confirmationCode = $confirmationCode;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param string $createdAt
     * @return Contact
     */
    public function setCreatedAt(string $createdAt): self
    {
        $this->createdAt = \DateTime::createFromFormat('Y-m-d H:i:s', $createdAt);
        return $this;
    }
}
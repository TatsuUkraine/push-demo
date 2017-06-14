<?php

namespace PushDemo\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Settings
 * @package PushDemo\AppBundle\Entity
 *
 * @ORM\Table(name="settings")
 * @ORM\Entity(repositoryClass="PushDemo\AppBundle\Repository\SettingsRepository")
 */
class Settings
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", nullable=false)
     */
    private $token;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_deleted", type="boolean", nullable=false)
     */
    private $isDeleted = false;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Settings
     */
    public function setId(int $id): Settings
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     * @return Settings
     */
    public function setToken(string $token): Settings
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDeleted(): bool
    {
        return $this->isDeleted;
    }

    /**
     * @param bool $isDeleted
     * @return Settings
     */
    public function setIsDeleted(bool $isDeleted): Settings
    {
        $this->isDeleted = $isDeleted;
        return $this;
    }
}
<?php

namespace PushDemo\AppBundle\Repository\Contract;


use PushDemo\AppBundle\Entity\Settings;

interface SettingsRepository
{
    /**
     * @param Settings $entity
     * @return Settings
     */
    public function save(Settings $entity): Settings;

    /**
     * @param string $token
     * @return Settings|null
     */
    public function findByToken(string $token);

    /**
     * @return Settings[]
     */
    public function findActive(): array;
}
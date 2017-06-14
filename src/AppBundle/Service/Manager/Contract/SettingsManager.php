<?php

namespace PushDemo\AppBundle\Service\Manager\Contract;


use PushDemo\AppBundle\Entity\Settings;

interface SettingsManager
{
    /**
     * @param string $token
     * @return Settings
     */
    public function saveNotificationSettings(string $token): Settings;

    /**
     * @param Settings $settings
     * @return Settings
     */
    public function deleteNotificationSettings(Settings $settings): Settings;

    /**
     * @return Settings[]
     */
    public function findActiveSettings(): array;
}
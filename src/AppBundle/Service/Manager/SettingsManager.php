<?php

namespace PushDemo\AppBundle\Service\Manager;


use PushDemo\AppBundle\Entity\Settings;
use PushDemo\AppBundle\Repository\Contract\SettingsRepository;
use PushDemo\AppBundle\Service\Manager\Contract\SettingsManager as SettingsManagerContract;

class SettingsManager implements SettingsManagerContract
{

    /**
     * @var SettingsRepository
     */
    private $settingsRepository;

    public function __construct(SettingsRepository $settingsRepository)
    {
        $this->settingsRepository = $settingsRepository;
    }

    /**
     * @param string $token
     * @return Settings
     */
    public function saveNotificationSettings(string $token): Settings
    {
        $settings = $this->settingsRepository->findByToken($token);
        if (!$settings) {
            $settings = new Settings();
            $settings->setToken($token);
            $settings = $this->settingsRepository->save($settings);
        }
        return $settings;
    }

    /**
     * @param Settings $settings
     * @return Settings
     */
    public function deleteNotificationSettings(Settings $settings): Settings
    {
        $settings->setIsDeleted(true);
        return $this->settingsRepository->save($settings);
    }

    /**
     * @return Settings[]
     */
    public function findActiveSettings(): array
    {
        return $this->settingsRepository->findActive();
    }
}
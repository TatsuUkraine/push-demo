<?php

namespace PushDemo\AppBundle\Library\Firebase\Contracts;

interface Request
{
    /**
     * Set notification title
     *
     * @param string $title
     * @return Request
     */
    public function setTitle(string $title): Request;

    /**
     * Set notification body
     *
     * @param string $body
     * @return Request
     */
    public function setBody(string $body): Request;

    /**
     * Set notification sound
     *
     * @param string $sound
     * @return Request
     */
    public function setSound(string $sound): Request;

    /**
     * Set payload
     *
     * @param array $payload
     * @return Request
     */
    public function setPayload(array $payload): Request;

    /**
     * Get title
     *
     * @return string|null
     */
    public function getTitle();

    /**
     * Get Body
     *
     * @return string|null
     */
    public function getBody();

    /**
     * Get payload
     *
     * @return array
     */
    public function getPayload(): array;

    /**
     * Get notification sound
     *
     * @return string|null
     */
    public function getSound();

    /**
     * Set receivers
     *
     * @param array $receivers
     * @return Request
     */
    public function setReceivers(array $receivers): Request;

    /**
     * Get receivers
     *
     * @return array
     */
    public function getReceivers(): array;

    /**
     * Add receiver
     *
     * @param string $token
     * @return Request
     */
    public function addReceiver(string $token): Request;

    /**
     * Check is receivers set
     *
     * @return bool
     */
    public function hasReceivers(): bool;

    /**
     * Get request params
     *
     * @return array
     */
    public function getRequestParams(): array;

    /**
     * Set push priority
     *
     * @param string|null $priority
     * @return Request
     */
    public function setPriority(string $priority = null): Request;

    /**
     * Get push message priority
     *
     * @return string|null
     */
    public function getPriority();
}
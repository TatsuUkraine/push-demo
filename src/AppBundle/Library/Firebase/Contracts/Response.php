<?php
/**
 * Created by PhpStorm.
 * User: tatsudn
 * Date: 20.02.17
 * Time: 18:09
 */

namespace PushDemo\AppBundle\Library\Firebase\Contracts;


interface Response
{
    /**
     * Check is response has failed results
     *
     * @return boolean
     */
    public function hasErrors();
    /**
     * Is status code 200
     *
     * @return boolean
     */
    public function isSuccess();

    /**
     * Get Results
     *
     * @param string $receiver
     * @return array|null
     */
    public function getResult(string $receiver = null);

    /**
     * Get failed requests
     *
     * @return array
     */
    public function getFailed(): array;

    /**
     * Get Receivers that should be updated
     *
     * @return array
     */
    public function getRecipientsForUpdate(): array;

    /**
     * Get succeeded requests
     *
     * @return array
     */
    public function getSucceeded(): array;

    /**
     * Get receivers
     *
     * @return array
     */
    public function getReceivers(): array;

    /**
     * Is request failed
     *
     * @param string $receiver
     * @return bool
     */
    public function isFailed(string $receiver): bool;

    /**
     * Is request failed
     *
     * @param string $receiver
     * @return bool
     */
    public function isSucceeded(string $receiver): bool;
}
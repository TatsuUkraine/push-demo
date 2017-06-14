<?php

namespace PushDemo\AppBundle\Library\Firebase;


use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use PushDemo\AppBundle\Library\Firebase\Contracts\Response as ResponseContract;
use PushDemo\AppBundle\Library\Firebase\Contracts\Serializer as SerializerContract;

class Response implements ResponseContract
{
    /**
     * @var ResponseInterface
     */
    private $_response;

    /**
     * Body of HTTP Response
     *
     * @var array
     */
    private $_responseData;

    /**
     * Request results
     *
     * @var array
     */
    private $_responses = [];
    /**
     * Succeeded requests
     *
     * @var array
     */
    private $_succeeded = [];

    /**
     * Failed requests
     *
     * @var array
     */
    private $_failed = [];

    /**
     * Succeeded requests, but token should be updated
     *
     * @var array
     */
    private $_needUpdate = [];

    /**
     * List of Receiver FCM IDs
     *
     * @var array
     */
    private $_receivers;

    /**
     * Response constructor.
     * @param ResponseInterface $response
     * @param array $receivers
     * @param SerializerContract $serializer
     */
    public function __construct(ResponseInterface $response, array $receivers, SerializerContract $serializer)
    {
        $this->_receivers = $receivers;
        $this->_response = $response;
        $this->_responseData = $serializer->decode($response->getBody());

        $this->_parseResults();
    }

    /**
     * Check is response has failed results
     *
     * @return boolean
     */
    public function hasErrors()
    {
        return (
            !empty($this->_responseData['failure'])
            || !empty($this->_failed)
        );
    }

    /**
     * Is status code 200
     *
     * @return boolean
     */
    public function isSuccess()
    {
        return $this->_response->getStatusCode() === 200;
    }

    /**
     * Get Results from request
     *
     * @param string|null $receiver
     * @return array|null
     */
    public function getResult(string $receiver = null)
    {
        if ($receiver) {
            return !empty($this->_responses[$receiver]) ? $this->_responses[$receiver] : null;
        }
        return $this->_responseData['results'];
    }

    /**
     * Get failed requests
     *
     * @return array
     */
    public function getFailed(): array
    {
        return $this->_failed;
    }

    /**
     * Get receivers that should be updated
     *
     * @return array
     */
    public function getRecipientsForUpdate(): array
    {
        return $this->_needUpdate;
    }

    /**
     * Get succeeded requests
     *
     * @return array
     */
    public function getSucceeded(): array
    {
        return $this->_succeeded;
    }

    /**
     * Get receivers
     *
     * @return array
     */
    public function getReceivers(): array
    {
        return $this->_receivers;
    }

    /**
     * Is request failed
     *
     * @param string $receiver
     * @return bool
     */
    public function isFailed(string $receiver): bool
    {
        return isset($this->_failed[$receiver]);
    }

    /**
     * Is request failed
     *
     * @param string $receiver
     * @return bool
     */
    public function isSucceeded(string $receiver): bool
    {
        return isset($this->_succeeded[$receiver]);
    }

    /**
     * Parse results
     */
    private function _parseResults()
    {
        foreach ($this->_responseData['results'] as $i => $result) {
            if (!empty($this->_receivers[$i])) {
                $receiver = $this->_receivers[$i];

                $this->_responses[$receiver] = $result;

                if (!empty($result['error'])) {
                    $this->_failed[$receiver] = $result;
                } else {
                    $this->_succeeded[$receiver] = $result;

                    if (!empty($result['registration_id'])) {
                        $this->_needUpdate[$receiver] = $result;
                    }
                }
            }
        }
    }
}
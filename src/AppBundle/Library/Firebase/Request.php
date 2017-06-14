<?php

namespace PushDemo\AppBundle\Library\Firebase;


use PushDemo\AppBundle\Library\Firebase\Contracts\Request as RequestContract;

class Request implements RequestContract
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $body;

    /**
     * @var array
     */
    private $payload = [];

    /**
     * @var array
     */
    private $receivers = [];

    /**
     * @var string|null
     */
    private $sound = null;

    /**
     * @var string|null
     */
    private $priority = null;

    /**
     * Set notification title
     *
     * @param string $title
     * @return RequestContract
     */
    public function setTitle(string $title): RequestContract
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Set notification body
     *
     * @param string $body
     * @return RequestContract
     */
    public function setBody(string $body): RequestContract
    {
       $this->body = $body;
       return $this;
    }

    /**
     * Set payload
     *
     * @param array $payload
     * @return RequestContract
     */
    public function setPayload(array $payload): RequestContract
    {
        $this->payload = $payload;
        return $this;
    }

    /**
     * Get title
     *
     * @return string|null
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get Body
     *
     * @return string|null
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Get payload
     *
     * @return array
     */
    public function getPayload(): array
    {
        return $this->payload;
    }

    /**
     * Set receivers
     *
     * @param array $receivers
     * @return RequestContract
     */
    public function setReceivers(array $receivers): RequestContract
    {
        $this->receivers = $receivers;
        return $this;
    }

    /**
     * Add receiver
     *
     * @param string $token
     * @return RequestContract
     */
    public function addReceiver(string $token): RequestContract
    {
        if (!in_array($token, $this->receivers)) {
            $this->receivers[] = $token;
        }
        return $this;
    }

    /**
     * Get request params
     *
     * @return array
     */
    public function getRequestParams(): array
    {
        $result = [];

        if ($this->priority) {
            $result['priority'] = $this->priority;
        }

        if ($this->payload) {
            $result['data'] = $this->payload;
        }

        if ($this->title && $this->body) {
            $result['notification'] = [
                'title' => $this->title,
                'body' => $this->body
            ];

            if ($this->sound) {
                $result['notification']['sound'] = $this->sound;
            }
        }

        if (count($this->receivers) === 1) {
            $result['to'] = reset($this->receivers);
        } else {
            $result['registration_ids'] = $this->receivers;
        }

        return $result;
    }

    /**
     * Set notification sound
     *
     * @param string $sound
     * @return RequestContract
     */
    public function setSound(string $sound): RequestContract
    {
        $this->sound = $sound;
        return $this;
    }

    /**
     * Get notification sound
     *
     * @return string|null
     */
    public function getSound()
    {
        return $this->sound;
    }

    /**
     * Get receivers
     *
     * @return array
     */
    public function getReceivers(): array
    {
        return $this->receivers;
    }

    /**
     * Check is receivers set
     *
     * @return bool
     */
    public function hasReceivers(): bool
    {
        return !empty($this->receivers);
    }

    /**
     * Set push priority
     *
     * @param string|null $priority
     * @return RequestContract
     */
    public function setPriority(string $priority = null): RequestContract
    {
        $this->priority = $priority;
        return $this;
    }

    /**
     * Get push message priority
     *
     * @return string|null
     */
    public function getPriority()
    {
        return $this->priority;
    }
}
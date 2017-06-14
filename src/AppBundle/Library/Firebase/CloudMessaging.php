<?php

namespace PushDemo\AppBundle\Library\Firebase;

use GuzzleHttp\ClientInterface;
use PushDemo\AppBundle\Library\Firebase\Contracts\CloudMessaging as CloudMessagingContract;
use PushDemo\AppBundle\Library\Firebase\Contracts\Request;
use PushDemo\AppBundle\Library\Firebase\Contracts\Response as ResponseContract;
use PushDemo\AppBundle\Library\Firebase\Contracts\Serializer as SerializerContract;
use PushDemo\AppBundle\Library\Firebase\Exception\MissingData;
use PushDemo\AppBundle\Library\Firebase\Exception\MissingReceiver;

class CloudMessaging implements CloudMessagingContract
{

    /**
     * @var ClientInterface
     */
    private $_client;

    /**
     * @var string
     */
    private $_method = 'POST';

    /**
     * @var SerializerContract
     */
    private $serializer;

    /**
     * CloudMessaging constructor.
     * @param ClientInterface $client
     * @param SerializerContract $serializer
     */
    public function __construct(ClientInterface $client, SerializerContract $serializer)
    {
        $this->_client = $client;
        $this->serializer = $serializer;
    }

    /**
     * Send FCM
     * @param Request $request
     * @return ResponseContract
     * @throws MissingData
     * @throws MissingReceiver
     */
    public function send(Request $request): ResponseContract
    {
        if (!$request->hasReceivers()) {
            throw new MissingReceiver('At least one receiver should be added');
        }

        $params = $request->getRequestParams();

        if (empty($params['notification']) && empty($params['data'])) {
            throw new MissingData('Notification or Data payload should be set');
        }

        $response = $this->_client->request($this->_method, '/fcm/send', [
            'json' => $params
        ]);

        $response = new Response($response, $request->getReceivers(), $this->serializer);

        return $response;
    }
}
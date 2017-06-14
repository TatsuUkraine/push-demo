<?php

namespace PushDemo\AppBundle\Library\Firebase;


use Symfony\Component\Serializer\Encoder\DecoderInterface;
use PushDemo\AppBundle\Library\Firebase\Contracts\Serializer as SerializerContract;

class Serializer implements SerializerContract
{
    /**
     * @var DecoderInterface
     */
    private $serializer;

    public function __construct(DecoderInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * Decode Firebase response
     *
     * @param string $data
     * @return mixed
     */
    public function decode(string $data)
    {
        return $this->serializer->decode($data, 'json');
    }
}
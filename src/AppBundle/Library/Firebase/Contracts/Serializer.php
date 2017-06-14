<?php

namespace PushDemo\AppBundle\Library\Firebase\Contracts;


interface Serializer
{
    /**
     * Decode Firebase response
     *
     * @param string $data
     * @return mixed
     */
    public function decode(string $data);
}
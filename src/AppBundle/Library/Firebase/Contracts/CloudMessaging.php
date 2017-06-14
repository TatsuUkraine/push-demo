<?php

namespace PushDemo\AppBundle\Library\Firebase\Contracts;


interface CloudMessaging
{
    /**
     * Send FCM
     *
     * @param Request $request
     * @return Response
     */
    public function send(Request $request): Response;
}
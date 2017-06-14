<?php

namespace PushDemo\AppBundle\Controller;


use PushDemo\AppBundle\Entity\Settings;
use PushDemo\AppBundle\Library\Firebase\Contracts\CloudMessaging;
use PushDemo\AppBundle\Library\Firebase\Request as FirebaseRequest;
use PushDemo\AppBundle\Service\Manager\Contract\SettingsManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route(service="app.api_controller")
 */
class ApiController
{

    /**
     * @var SettingsManager
     */
    private $settingsManager;
    /**
     * @var CloudMessaging
     */
    private $cloudMessaging;

    public function __construct(SettingsManager $settingsManager, CloudMessaging $cloudMessaging)
    {
        $this->settingsManager = $settingsManager;
        $this->cloudMessaging = $cloudMessaging;
    }

    /**
     * @Route("/api/settings", name="save_setting")
     * @Method({"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function saveSettingsAction(Request $request): JsonResponse
    {
        $settings = $this->settingsManager->saveNotificationSettings($request->request->get('token'));
        return new JsonResponse(
            [
                'id' => $settings->getId(),
                'token' => $settings->getToken()
            ]
        );
    }

    /**
     * @Route("/api/settings/{settings}", name="delete_settings")
     * @Method({"DELETE"})
     * @param Settings $settings
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteSettingsAction(Settings $settings, Request $request): JsonResponse
    {
        $this->settingsManager->deleteNotificationSettings($settings);
        return new JsonResponse([]);
    }

    /**
     * @Route("/api/push/{settings}", name="send_push")
     * @Method({"GET"})
     * @param Settings $settings
     * @param Request $request
     * @return JsonResponse
     */
    public function sendPushAction(Settings $settings, Request $request): JsonResponse
    {
        $request = new FirebaseRequest();
        //$request->setTitle('Some Title');
        //$request->setBody('Some body');
        $request->setPayload([
            'title' => 'Some title',
            'body' => 'Some body',
            'actions' => [
                [
                    'action' => 'first_button',
                    'title' => 'First'
                ],
                [
                    'action' => 'second_button',
                    'title' => 'Second'
                ]
            ]
        ]);
        $request->addReceiver($settings->getToken());

        $response = $this->cloudMessaging->send($request);

        return new JsonResponse($response->getResult());
    }

    /**
     * @Route("/api/push", name="send_bulk_push")
     * @Method({"GET"})
     * @param Request $request
     * @return JsonResponse
     */
    public function sendPushToAllAction(Request $request): JsonResponse
    {
        $settings = $this->settingsManager->findActiveSettings();
        $request = new FirebaseRequest();
        //$request->setTitle('Some Title');
        //$request->setBody('Some body');
        $request->setPayload([
            'title' => 'Some title',
            'body' => 'Some body'
        ]);
        foreach ($settings as $setting) {
            $request->addReceiver($setting->getToken());
        }

        $response = $this->cloudMessaging->send($request);

        return new JsonResponse($response->getResult());
    }

    /**
     * @Route("/api/some-data", name="fetch_some_data")
     * @Method({"GET"})
     * @param Request $request
     * @return JsonResponse
     */
    public function someDataAction(Request $request): JsonResponse
    {
        return new JsonResponse([
            'someKey' => 'so1'
        ]);
    }
}
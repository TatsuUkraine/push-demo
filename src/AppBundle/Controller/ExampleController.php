<?php

namespace PushDemo\AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route(service="app.example_controller")
 */
class ExampleController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Method({"GET","HEAD"})
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/push_notification", name="push_notification")
     * @Method({"GET","HEAD"})
     */
    public function pushAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/push_notification.html.twig');
    }



    /**
     * @Route("/sync_example", name="sync")
     * @Method({"GET","HEAD"})
     */
    public function syncAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/sync.html.twig');
    }

    /**
     * @Route("/cache_example", name="cache")
     * @Method({"GET","HEAD"})
     */
    public function cacheAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/cache.html.twig');
    }

    /**
     * @Route("/fetch_example", name="fetch")
     * @Method({"GET","HEAD"})
     */
    public function fetchAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/fetch.html.twig');
    }
}
<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }

    /**
     * @Route("/messages", name="getMessages")
     * @Method({"GET"})
     */
    public function getMessagesAction(Request $request)
    {
        return new JsonResponse(array('name' => $name));
    }

    /**
     * @Route("/messages", name="postMessages")
     * @Method({"POST"})
     */
    public function postMessagesAction(Request $request)
    {
        return new JsonResponse(array('name' => $name));
    }
}

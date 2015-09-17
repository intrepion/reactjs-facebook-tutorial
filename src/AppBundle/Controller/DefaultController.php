<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Message;
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
        $entityManager = $this->getDoctrine()->getManager();
        $messageRepository = $entityManager->getRepository('AppBundle:Message');
        $messages = $messageRepository->findAll();

        $messageList = array();
        foreach ($messages as $message) {
            $messageItem = array();
            $messageItem['username'] = $message->getUsername();
            $messageItem['message'] = $message->getMessage();
            $messageItem['time'] = $message->getSent()->format('Y-M-d H:i:s');
            $messageList[] = $messageItem;
        }

        return new JsonResponse($messageList);
    }

    /**
     * @Route("/messages", name="postMessages")
     * @Method({"POST"})
     */
    public function postMessagesAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $message = new Message();
        $message->setUsername('user');
        $message->setMessage($request->request->get('msg'));
        $message->setSent(new \DateTime());
        $entityManager->persist($message);
        $entityManager->flush($message);

        $messageRepository = $entityManager->getRepository('AppBundle:Message');
        $messages = $messageRepository->findAll();

        $messageList = array();
        foreach ($messages as $message) {
            $messageItem = array();
            $messageItem['username'] = $messages->getUsername();
            $messageItem['message'] = $messages->getMessage();
            $messageItem['time'] = date('F j, Y, g:i a', $message->getSent());
            $messageList[] = $messageItem;
        }

        return new JsonResponse($messageList);
    }
}

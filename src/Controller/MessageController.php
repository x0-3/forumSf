<?php

namespace App\Controller;

use App\Entity\Topic;
use App\Entity\Message;
use App\Form\MessageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MessageController extends AbstractController
{
    #[Route('/message', name: 'app_message')]
    public function index(): Response
    {
        return $this->render('message/index.html.twig', [
            'controller_name' => 'MessageController',
        ]);
    }


    #[Route('/{topicId}/newMessage', name: 'new_message')]
    public function newMessage(Request $request, EntityManagerInterface $em, Topic $topicId): Response
    {

        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('detail_topic', ['id' => $topicId->getId()]);
        }

        // if the topic is locked block the messages form submission
        if ($topicId->isIslocked() == true) {

            // then redirect to the topic
            return $this->redirectToRoute('detail_topic', ['id' => $topicId->getId()]);
        }

        $message = new Message();

        $form = $this->createForm(MessageType::class, $message);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $message = $form->getData();

            $message->setCreatedAt(new \DateTime());
            $message->setUser($user);
            $message->setTopic($topicId);

            $em->persist($message);

            $em->flush();

            return $this->redirectToRoute('detail_topic', ['id' => $topicId->getId()]);
        }

        return $this->render('message/newMessage.html.twig', [
            'form' => $form,
            'description' => 'create a new message',
        ]);

    }
}

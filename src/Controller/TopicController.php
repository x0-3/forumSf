<?php

namespace App\Controller;

use App\Entity\Topic;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TopicController extends AbstractController
{
    #[Route('/topic', name: 'app_topic')]
    public function index(): Response
    {
        return $this->render('topic/index.html.twig', [
            'controller_name' => 'TopicController',
            'description' => 'CategoryController',
        ]);
    }

    #[Route('/topic/{id}', name: 'detail_topic')]
    public function detailTopic(Topic $topic): Response
    {

        return $this->render('topic/detailTopic.html.twig', [
            'topic' => $topic,
            'description' => 'CategoryController',
        ]);
    }
}

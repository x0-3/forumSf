<?php

namespace App\Controller;

use DateTime;
use App\Entity\Topic;
use App\Form\TopicType;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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


    #[Route('/{id}/newTopic', name: 'new_topic')]
    public function newTopic(Request $request, EntityManagerInterface $em, Category $category): Response
    {

        $user = $this->getUser();

        if (!$user){
            
            return $this->redirectToRoute('app_home');
        }

        $topic = new Topic();

        $form = $this->createForm(TopicType::class, $topic);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $topic = $form->getData();

            $topic->setCreatedAt(new DateTime());
            $topic->setIslocked(0);
            $topic->setCategory($category);
            $topic->setUser($user);

            $em->persist($topic);
            $em->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('topic/newTopic.html.twig', [
            'form' => $form,
            'description' => 'create a new topic',
        ]);
    }


    #[Route('/{categoryId}/editTopic/{id}', name: 'edit_topic')]
    public function editTopic(Request $request, EntityManagerInterface $em, Category $categoryId, Topic $topic): Response
    {

        $user = $this->getUser();
        $ownerTopic = $topic->getUser();

        if (!$user || $ownerTopic != $user){
            
            return $this->redirectToRoute('app_home');
        }

        $form = $this->createForm(TopicType::class, $topic);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $topic = $form->getData();

            $topic->setCreatedAt(new \DateTime());
            $topic->setIslocked(0);
            $topic->setCategory($categoryId);
            $topic->setUser($user);

            $em->persist($topic);
            $em->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('topic/newTopic.html.twig', [
            'form' => $form,
            'description' => 'edit topic',
        ]);
    }


    #[Route('/{categoryId}/deleteTopic/{id}', name: 'delete_topic')]
    public function deleteTopic(Category $categoryId, Topic $topic, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $ownerTopic = $topic->getUser();

        if(!$user){
            return $this->redirectToRoute('app_home');
        }

        if ($user === $ownerTopic) {

            $em->remove($topic);
            $em->flush();

            return $this->redirectToRoute('app_profile');
        }

        return $this->redirectToRoute('app_home');
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

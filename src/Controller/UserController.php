<?php

namespace App\Controller;

use App\Entity\Topic;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }


    #[Route('/profile', name: 'app_profile')]
    public function profile(EntityManagerInterface $em): Response
    {

        $user = $this->getUser();

        if($user instanceof User) {
            // if the user is not logged in
            if (!$user) {
                return $this->redirectToRoute('app_home');
            }

            $topics = $em->getRepository(Topic::class)->findByUser($user->getId(), 5);
        
            return $this->render('user/profile.html.twig', [
                'topics' => $topics,
                'description' => 'profile page'
            ]);
        }

    }
}

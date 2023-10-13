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

        // get user 
        $user = $this->getUser();

        if($user instanceof User) {
            // if the user is not logged in
            if (!$user) {
                return $this->redirectToRoute('app_home');
            }

            // find the topics created by the user that is logged in
            $topics = $em->getRepository(Topic::class)->findByUser($user->getId(), 5);
        
            return $this->render('user/profile.html.twig', [
                'topics' => $topics,
                'description' => $user->getUsername() . 'profile page'
            ]);
        }

    }


    #[Route('/user/{id}', name: 'app_user')]
    public function detailUser(User $user, EntityManagerInterface $em): Response
    {

        $loggedUser = $this->getUser(); // get the user currently logged in

        // if the logged in user is the same as the user in the user details page
        if ($loggedUser == $user) {
            return $this->redirectToRoute('app_profile');
        }

        // find the topics created by the user that is logged in
        $topics = $em->getRepository(Topic::class)->findByUser($user->getId(), 5);

        return $this->render('user/detailUser.html.twig', [
            'user' => $user,
            'topics' => $topics,
            'description' => $user->getUsername() . 'page'
        ]);

    }
}

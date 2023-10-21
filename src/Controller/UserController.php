<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Topic;
use App\Form\EditUserType;
use App\Service\FileUpload;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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
            // $topics = $em->getRepository(Topic::class)->findByUser($user->getId(), 5);
        
            return $this->render('user/profile.html.twig', [
                // 'topics' => $topics,
                'description' => $user->getUsername() . 'profile page'
            ]);
        }

    }


    #[Route('/editProfile', name: 'edit_profile')]
    public function editProfile(Request $request, EntityManagerInterface $em, FileUpload $fileUploader): Response
    {

        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('app_home');
        }

        $form = $this->createForm(EditUserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $imageFile = $form->get('avatar')->getData();
            if ($imageFile) {
                $imageFileName = $fileUploader->upload($imageFile);
                $user->setAvatar($imageFileName);
            }


            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('app_profile');
        }

        return $this->render('user/editUser.html.twig', [
            'form' => $form,
            'description' => 'create a new message',
        ]);

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
        // $topics = $em->getRepository(Topic::class)->findByUser($user->getId(), 5);

        return $this->render('user/detailUser.html.twig', [
            'user' => $user,
            // 'topics' => $topics,
            'description' => $user->getUsername() . 'page'
        ]);

    }
}

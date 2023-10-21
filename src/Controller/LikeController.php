<?php

namespace App\Controller;

use App\Entity\Topic;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LikeController extends AbstractController
{
    #[Route('/like/topic/{id}', name: 'app_like')]
    public function index(Topic $topic, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();

        // if the user has already liked this topic
        if ($topic->isLikedByUser($user)) {
            
            $topic->removeLike($user); // remove the like
            $em->flush();

            return $this->json([
                'message' => 'The like has been deleted',
                'nbLike' => $topic->howManyLikes()
            ]);
        }

        $topic->addLike($user);
        $em->flush();

        return $this->json([
            'message' => 'The like has been added',
            'nbLike' => $topic->howManyLikes()
        ]);

    }
}

<?php

namespace App\Controller;

use App\Entity\Topic;
use App\Model\Searchbar;
use App\Form\SearchBarType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(EntityManagerInterface $em, Request $request): Response
    {

        $topics = $em->getRepository(Topic::class)->findBy([], ['createdAt' => 'DESC'], 5);

        // search bar
        $search = new Searchbar();

        $form = $this->createForm(SearchBarType::class, $search);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // put the request query at getInt to get new post from value
            $search->page = $request->query->getInt('page', 1);

            $topics = $em->getRepository(Topic::class)->findBySearch($search, 5);

            return $this->render('home/index.html.twig', [
                'form' => $form->createView(),
                'topics' => $topics,
                'description' => 'HomeController'
            ]);
        }


        return $this->render('home/index.html.twig', [
            'form' => $form->createView(),
            'topics' => $topics,
            'description' => 'HomeController'
        ]);
    }
}

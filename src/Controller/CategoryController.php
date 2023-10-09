<?php

namespace App\Controller;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/category', name: 'app_category')]
    public function index(EntityManagerInterface $em): Response
    {

        $categories = $em->getRepository(Category::class)->findAll();

        return $this->render('category/index.html.twig', [
            'categories' => $categories,
            'description' => 'CategoryController',
        ]);
    }

    #[Route('/category/{id}', name: 'detail_category')]
    public function detailCategory(Category $category): Response
    {

        // dd($category);

        return $this->render('category/detailCategory.html.twig', [
            'category' => $category,
            'description' => 'CategoryController',
        ]);
    }
}

<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Topic;
use App\Entity\Message;
use Symfony\Component\HttpFoundation\Response;
use App\Controller\Admin\MessageCrudController;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // return parent::index();

        $routeBuilder = $this->container->get(AdminUrlGenerator::class);
        $url = $routeBuilder->setController(MessageCrudController::class)->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('ForumSf');
    }

    public function configureMenuItems(): iterable
    {

        yield MenuItem::linktoRoute('Back to the website', 'fas fa-home', 'app_home');
        yield MenuItem::linkToCrud('Messages', 'fas fa-map-marker-alt', Message::class);
        yield MenuItem::linkToCrud('Topics', 'fas fa-comments', Topic::class);
        yield MenuItem::linkToCrud('Users', 'fas fa-comments', User::class);
    }
}

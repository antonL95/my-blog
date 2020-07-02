<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/{_locale}/al-admin445",
     *     name="admin_index",
     *     host="blog.antonloginov.local",)
     * @return Response
     */
    public function index(): Response
    {
        return parent::index();
//        $routeBuilder = $this->get(CrudUrlGenerator::class)->build();
//
//        return $this->redirect($routeBuilder->setController(ArticleCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('EasyAdmin');
    }

    public function configureCrud(): Crud
    {
        return Crud::new();
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        return UserMenu::new()
            ->displayUserAvatar(false);
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Article', 'fas fa-folder-open', Article::class);
    }
}

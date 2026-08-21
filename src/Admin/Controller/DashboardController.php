<?php

declare(strict_types=1);

namespace App\Admin\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use App\Knowledge\Entity\KnowledgeReference;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(
    routePath: '/8f4a9c_admin',
    routeName: 'admin',
)]
final class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Airways Orthodontics');
    }

    public function configureAssets(): Assets
    {
        return Assets::new()
            ->addAssetMapperEntry('admin');
    }

    public function configureMenuItems(): iterable
    {
        /*
         * Dashboard
         */
        yield MenuItem::linkToDashboard(
            'Dashboard',
            'fas fa-gauge-high',
        );

    /*
    * Kennisbank
    */
    yield MenuItem::section('Kennisbank');

    yield MenuItem::linkTo(
        KnowledgeCategoryCrudController::class,
        'Categorieën',
        'fas fa-folder-open',
    )
        ->setAction(Action::INDEX);

    yield MenuItem::linkTo(
        KnowledgeArticleCrudController::class,
        'Artikelen & dossiers',
        'fas fa-newspaper',
    )
        ->setAction(Action::INDEX);

    yield MenuItem::linkTo(
        KnowledgeReferenceCrudController::class,
        'Wetenschappelijke publicaties',
        'fas fa-book-medical',
    )
        ->setAction(Action::INDEX);

    yield MenuItem::linkTo(
        KnowledgeImageCrudController::class,
        'Afbeeldingen',
        'fas fa-image',
    )
        ->setAction(Action::INDEX);

        /*
         * Website
         */
        yield MenuItem::section('Website');

        yield MenuItem::linkToRoute(
            'Publieke website',
            'fas fa-globe',
            'home',
        );

        /*
         * Sessie
         */
        yield MenuItem::section('Account');

        yield MenuItem::linkToLogout(
            'Uitloggen',
            'fas fa-right-from-bracket',
        );
    }
}
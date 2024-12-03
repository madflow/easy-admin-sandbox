<?php

namespace App\Controller\Admin;

use App\Entity\Pokemon;
use App\Entity\PokemonMove;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    public function __construct(private EntityManagerInterface $entityManager)
    {

    }

    #[Route('/', name: 'admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(PokemonCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()->setTitle('Easy Admin Sandbox');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::subMenu('Pokemons', 'fas fa-list')->setSubItems([
            MenuItem::linkToCrud('Search', 'fas fa-search', Pokemon::class),
            MenuItem::linkToCrud('Create', 'fas fa-plus', Pokemon::class)->setAction(Crud::PAGE_NEW),
        ]);

        yield MenuItem::section('Detail');

        $pokemons = $this->entityManager->getRepository(Pokemon::class)->findBy([], ['id' => 'desc'], 3);

        foreach ($pokemons as $pokemon) {
            yield MenuItem::subMenu($pokemon->getName(), 'fa fa-list')->setSubItems([
                MenuItem::linkToCrud('Details', 'fa fa-tags', Pokemon::class)->setAction(Crud::PAGE_DETAIL)->setEntityId($pokemon->getId()),
                MenuItem::linkToCrud('Moves', 'fa fa-list', PokemonMove::class)->setAction(Crud::PAGE_INDEX)->setQueryParameter('pokemon', $pokemon->getId()),
            ]);
        }
    }
}

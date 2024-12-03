<?php

namespace App\Controller\Admin;

use App\Entity\PokemonMove;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;

class PokemonMoveCrudController extends AbstractCrudController
{
    public function __construct(private EntityRepository $entityRepository)
    {
    }

    public static function getEntityFqcn(): string
    {
        return PokemonMove::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Move')
            ->setEntityLabelInPlural('Moves')
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        $name = TextField::new('name');
        $pokemon = AssociationField::new('pokemon');

        return [$name, $pokemon];
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $pokemon = $searchDto->getRequest()->query->get('pokemon');
        $response = $this->entityRepository->createQueryBuilder($searchDto, $entityDto, $fields, $filters);

        $response->andWhere('entity.pokemon = :pokemon')->setParameter('pokemon', $pokemon);

        return $response;
    }
}

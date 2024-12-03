<?php

namespace App\Controller\Admin;

use App\Entity\Pokemon;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class PokemonCrudController extends AbstractCrudController
{
    public function configureActions(Actions $actions): Actions
    {
        $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
        ;

        return $actions;
    }

    public function configureFields(string $pageName): iterable
    {
        $id = IdField::new('id');
        $name = Field::new('name');

        if (Crud::PAGE_DETAIL === $pageName) {
            return [
                $id,
                $name,
            ];
        } elseif (Crud::PAGE_NEW === $pageName || Crud::PAGE_EDIT === $pageName) {
            return [$name];
        } else {
            return [$id, $name];
        }

    }
    public static function getEntityFqcn(): string
    {
        return Pokemon::class;
    }
}

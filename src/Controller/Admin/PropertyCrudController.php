<?php

namespace App\Controller\Admin;

use App\Entity\Property;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PropertyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Property::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // ->renderSidebarMinimized()
            ->setEntityLabelInPlural('Propriétés')
            ->setEntityLabelInSingular('Propriété')
            ->setEntityPermission('ROLE_ADMIN')
            ->setPageTitle('new', "Ajouter une %entity_label_singular%")
        ;
    }

    public function createEntity(string $entityFqcn)
    {
        $property = new Property;
        $property->setEmployee($this->getUser())
            ->setSell(false);

        return $property;
    }
}

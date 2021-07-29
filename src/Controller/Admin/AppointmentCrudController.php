<?php

namespace App\Controller\Admin;

use Swift_Mailer;
use Swift_Message;
use App\Entity\Appointment;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;

class AppointmentCrudController extends AbstractCrudController
{

    public function __construct(Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public static function getEntityFqcn(): string
    {
        return Appointment::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            DateTimeField::new('appointmentDate', "Date de rendez-vous"),
            TextField::new('property.title', "titre")->hideOnForm(),
            ChoiceField::new('property', "propriété")
                ->onlyOnForms()
                ,
            TextField::new('email'),
            TextField::new('phone'),
            TextField::new('lastname'),
            TextField::new('firstname'),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->renderSidebarMinimized()
            ->setEntityLabelInPlural("Rendez-vous")
            ->setEntityLabelInSingular("Rendez-Vous")
            ->setPageTitle("new", "Prendre un %entity_label_singular%")
            ;
    }


    public function deleteEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $email = (new Swift_Message("Annulation du rendez-vous"))
                ->setFrom($this->getUser()->getEmail())
                ->setTo($entityInstance->getEmail())
                ->setBody("Bonjour, nous sommes au regret de vous informer que votre rendez-vous est annulé.");
        
        $this->mailer->send($email);

        $entityManager->remove($entityInstance);
        $entityManager->flush();
        ;
    }
}

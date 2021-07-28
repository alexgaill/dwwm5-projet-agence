<?php

namespace App\Form;

use App\Entity\Appointment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class AppointmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                "label" => "Prénom"
            ])
            ->add('lastname', TextType::class, [
                "label" => "Nom"
            ])
            ->add('email', EmailType::class, [
                "label" => "Email"
            ])
            ->add('phone', TextType::class, [
                "label" => "Téléphone"
            ])
            ->add('appointmentDate', DateTimeType::class, [
                "label" => "Date de rendez-vous"
            ])
            ->add("submit", SubmitType::class, [
                "label" => "Prendre rdv"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Appointment::class,
        ]);
    }
}

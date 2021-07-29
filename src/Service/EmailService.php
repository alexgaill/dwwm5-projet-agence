<?php
namespace App\Service;

use Swift_Mailer;
use Swift_Message;
use Swift_Transport;
use App\Entity\Property;
use App\Entity\Appointment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EmailService {

    public function sendConfirmationAppointment (Appointment $appointment, Property $property) 
    {
        $mailer = new Swift_Mailer(new Swift_Transport);
        $controller = new AbstractController;
        
        $email = (new Swift_Message("Confirmation de rendez-vous pour visite du bien ".$property->getTitle()))
                        ->setFrom("no-reply@agency.fr")
                        ->setTo($appointment->getEmail())
                        ->setCc($property->getEmployee()->getEmail())
                        ->setBody(
                            $controller->renderView(
                                'email/sendAppointmentConfirmation.html.twig',
                                [
                                    "appointment" => $appointment,
                                    "property" => $property
                                ]
                            )
                        );
        $mailer->send($email);
    }
}
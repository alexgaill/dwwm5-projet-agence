<?php

namespace App\Controller;

use App\Entity\Appointment;
use App\Entity\Property;
use App\Form\AppointmentType;
use Knp\Component\Pager\PaginatorInterface;
use Swift_Mailer;
use Swift_Message;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PropertyController extends AbstractController
{
    /**
     * @Route("/", name="home")
     *
     * @return Response
     */
    public function index(): Response
    {
        $properties = $this->getDoctrine()->getRepository(Property::class)->findLast5();
        return $this->render('property/index.html.twig', [
            "properties" => $properties,
        ]);
    }

    /**
     * @Route("/properties", name="properties")
     *
     * @return Response
     */
    public function biens (PaginatorInterface $paginator, Request $request): Response
    {
        // dump($request->query->all());
        // if ($request->get("sort") !== null && !empty($request->get("sort"))) {
        //     $properties = $this->getDoctrine()->getRepository(Property::class)->findBy(
        //         ["sell" => false], 
        //         [$request->get("sort") => $request->get("direction")]
        //     );
        // } else {
        //     $properties = $this->getDoctrine()->getRepository(Property::class)->findBy(["sell" => false]);
        // }
            $properties = $this->getDoctrine()->getRepository(Property::class)->findFilterProperties($request->query->all());

        $pagination = $paginator->paginate($properties, $request->query->getInt("page", 1), 8);
        return $this->render("property/properties.html.twig", [
            "pagination" => $pagination,
            "filter" => $request->query->all()
        ]);
    }

    /**
     * @Route("/property/{id}", name="singleProperty")
     *
     * @param Property $property
     * @return Response
     */
    public function single (Property $property, Request $request, Swift_Mailer $mailer): Response
    {
        $appointment = new Appointment;
        $form = $this->createForm(AppointmentType::class, $appointment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $appointment = $form->getData();
                $appointment->setEmployee($property->getEmployee())
                ->setProperty($property);
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($appointment);
                $manager->flush();
                $this->addFlash("success", "Le rendez-vous est enregistré, vous allez recevoir un mail de confirmation."
                );

                $email = (new Swift_Message("Confirmation de rendez-vous pour visite du bien ".$property->getTitle()))
                        ->setFrom("no-reply@agency.fr")
                        ->setTo($appointment->getEmail())
                        ->setCc($property->getEmployee()->getEmail())
                        ->setBody(
                            $this->renderView(
                                'email/sendAppointmentConfirmation.html.twig',
                                [
                                    "appointment" => $appointment,
                                    "property" => $property
                                ]
                            )
                        );
                $mailer->send($email);
            } catch (\Throwable $th) {
                $this->addFlash("danger", "Le rendez-vous n'a pas pu être pris, merci de réessayer.");
            }
        }

        return $this->render("property/single.html.twig", [
            "property" => $property,
            "form" => $form->createView()
        ]);
    }
}

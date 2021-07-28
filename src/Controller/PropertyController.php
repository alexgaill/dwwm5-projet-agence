<?php

namespace App\Controller;

use App\Entity\Property;
use Knp\Component\Pager\PaginatorInterface;
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
        $properties = $this->getDoctrine()->getRepository(Property::class)->findBy(["sell" => false]);

        $pagination = $paginator->paginate($properties, $request->query->getInt("page", 1), 8);
        return $this->render("property/properties.html.twig", [
            "pagination" => $pagination
        ]);
    }
}

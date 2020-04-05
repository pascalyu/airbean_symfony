<?php

namespace App\Controller;

use App\Entity\Property;
use App\Entity\Rent;
use App\Form\Property1Type;
use App\Form\RentType;
use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/property")
 */
class PropertyController extends AbstractController
{
    /**
     * @Route("/", name="property_index", methods={"GET"})
     */
    public function index(PropertyRepository $propertyRepository): Response
    {


        return $this->render('property/index.html.twig', [
            'properties' =>  $propertyRepository->findBy(['user' => $this->getUser()->getId()]),
        ]);
    }

    /**
     * @Route("/admin", name="property_index_as_admin", methods={"GET"})
     */
    public function indexAsAdmin(PropertyRepository $propertyRepository): Response
    {


        return $this->render('property/index.html.twig', [
            'properties' =>  $propertyRepository->findAll(),
        ]);
    }


    /**
     * @Route("/new", name="property_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $property = new Property();
        $form = $this->createForm(Property1Type::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $entityManager = $this->getDoctrine()->getManager();
            $property->setUser($this->getUser());
            $entityManager->persist($property);
            $entityManager->flush();

            return $this->redirectToRoute('property_index');
        }

        return $this->render('property/new.html.twig', [
            'property' => $property,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}", name="property_show_custom", methods={"GET","POST"})
     */
    public function customShow(Request $request, Property $property): Response
    {
        $rent = new Rent();
        $form = $this->createForm(RentType::class, $rent);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $rent->setProperty($property);
            $rent->setUser($this->getUser());


            $interval = date_diff($rent->getStartDateAt(),  $rent->getEndDateAt());
            $dayNbr = $interval->format('%a');
            $rent->setPrice(($dayNbr+1) * $property->getPricePerDay() * $rent->getPersonNbr());

            $rent->setPaid(true);
            $entityManager->persist($rent);
            $entityManager->flush();

            return $this->redirectToRoute('property_index');
        }

        return $this->render('property/custom_show.html.twig', [
            'rentForm' => $form->createView(),
            'property' => $property,
        ]);
    }

    /**
     * @Route("/{id}", name="property_show", methods={"GET"})
     */
    public function show(Property $property): Response
    {
        return $this->render('property/show.html.twig', [
            'property' => $property,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="property_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Property $property): Response
    {
        $form = $this->createForm(Property1Type::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('property_index');
        }

        return $this->render('property/edit.html.twig', [
            'property' => $property,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="property_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Property $property): Response
    {
        if ($this->isCsrfTokenValid('delete' . $property->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($property);
            $entityManager->flush();
        }

        return $this->redirectToRoute('property_index');
    }

    /**
     * @Route("/{id}", name="show_from_city", methods={"GET"})
     */
    public function showFromCity(Request $request, Property $property): Response
    {
        if ($this->isCsrfTokenValid('delete' . $property->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($property);
            $entityManager->flush();
        }

        return $this->redirectToRoute('property_index');
    }
}

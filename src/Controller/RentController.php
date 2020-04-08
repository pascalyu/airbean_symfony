<?php

namespace App\Controller;

use App\Entity\Rent;
use App\Form\Rent1Type;
use App\Repository\RentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/rent")
 */
class RentController extends AbstractController
{
    /**
     * @Route("/", name="rent_index", methods={"GET"})
     */
    public function index(RentRepository $rentRepository): Response
    {
        return $this->render('rent/index.html.twig', [
            'rents' => $rentRepository->findBy(['user' => $this->getUser()]),
        ]);
    }

    /**
     * @Route("/new", name="rent_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $rent = new Rent();
        $form = $this->createForm(Rent1Type::class, $rent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rent);
            $entityManager->flush();

            return $this->redirectToRoute('rent_index');
        }

        return $this->render('rent/new.html.twig', [
            'rent' => $rent,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="rent_show", methods={"GET"})
     */
    public function show(Rent $rent): Response
    {
        return $this->render('rent/show.html.twig', [
            'rent' => $rent,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="rent_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Rent $rent): Response
    {
        $form = $this->createForm(Rent1Type::class, $rent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('rent_index');
        }

        return $this->render('rent/edit.html.twig', [
            'rent' => $rent,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="rent_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Rent $rent): Response
    {
        if ($this->isCsrfTokenValid('delete' . $rent->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($rent);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rent_index');
    }
}

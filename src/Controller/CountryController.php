<?php

namespace App\Controller;

use App\Entity\Country;
use App\Entity\Picture;
use App\Form\CountryType;
use App\Repository\CountryRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Vich\UploaderBundle\Entity\File;

/**
 * @Route("/c")
 */
class CountryController extends AbstractController
{
    /**
     * @Route("/", name="country_index", methods={"GET"})
     */
    public function index(CountryRepository $countryRepository): Response
    {
        return $this->render('country/index.html.twig', [
            'countries' => $countryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="country_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $country = new Country();
        $form = $this->createForm(CountryType::class, $country);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $createdAt = new DateTime();
            $country->setCreatedAt($createdAt);
         
            $file = $form['pictureFile']->getData();
            $file->move("images/global", $file->getClientOriginalName());
            $picture = new Picture();
            $picture->setName($file->getClientOriginalName());

            $picture->setCreatedAt($createdAt);
            $country->addPicture($picture);

            $entityManager->persist($picture);
            $entityManager->persist($country);
            $entityManager->flush();

            return $this->redirectToRoute('country_index');
        }

        return $this->render('country/new.html.twig', [
            'country' => $country,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{name}", name="custom_show", methods={"GET"})
     */
    public function customShow(string $name, CountryRepository $countryRepository, Request $request): Response
    {

        $country = $countryRepository->findOneBy(['name' => $name]);
        return $this->render('country/custom_show.html.twig', [
            'country' => $country,
            'cities' =>  $country->getCities()
        ]);
    }




    /**
     * @Route("/{id}", name="country_show", methods={"GET"})
     */
    public function show(Country $country): Response
    {
        return $this->render('country/show.html.twig', [
            'country' => $country,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="country_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Country $country): Response
    {
        $form = $this->createForm(CountryType::class, $country);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $entityManager = $this->getDoctrine()->getManager();
            $updatedAt = new DateTime();
            $country->setUpdatedAt($updatedAt);
            $file = $form['pictureFile']->getData();
            $file->move("images/global", $file->getClientOriginalName());
            $picture = new Picture();
            $picture->setName($file->getClientOriginalName());

            $picture->setCreatedAt($updatedAt);
            $country->addPicture($picture);

            $entityManager->persist($picture);

            $entityManager->persist($country);
            $entityManager->flush();



            return $this->redirectToRoute('country_index');
        }

        return $this->render('country/edit.html.twig', [
            'country' => $country,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="country_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Country $country): Response
    {
        if ($this->isCsrfTokenValid('delete' . $country->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($country);
            $entityManager->flush();
        }

        return $this->redirectToRoute('country_index');
    }
}

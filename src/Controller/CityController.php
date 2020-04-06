<?php

namespace App\Controller;

use App\Entity\City;
use App\Entity\Picture;
use App\Form\CityType;
use App\Repository\CityRepository;
use App\Repository\PropertyRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/city")
 */
class CityController extends AbstractController
{
    /**
     * @Route("/", name="city_index", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(CityRepository $cityRepository): Response
    {
        return $this->render('city/index.html.twig', [
            'cities' => $cityRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="city_new", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request): Response
    {
        $city = new City();
        $form = $this->createForm(CityType::class, $city);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dateNow = new DateTime();
            $entityManager = $this->getDoctrine()->getManager();
            $updatedAt = new DateTime();
            $file = $form['pictureFile']->getData();
            $file->move("images/global", $file->getClientOriginalName());
            $picture = new Picture();
            $picture->setName($file->getClientOriginalName());
            $picture->setCreatedAt($updatedAt);
            $city->addPicture($picture);

            $city->setCreatedAt($dateNow);
            $city->setUpdatedAt($dateNow);

            $entityManager->persist($picture);
            $entityManager->persist($city);
            $entityManager->flush();

            return $this->redirectToRoute('city_index');
        }

        return $this->render('city/new.html.twig', [
            'city' => $city,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{name}", name="custom_show_city", methods={"GET"})
     * 
     */
    public function customShow(string $name, CityRepository $cityRepository, PropertyRepository $propertyRepository, Request $request): Response
    {
        $city = $cityRepository->findOneBy(['name' => $name]);
        return $this->render('city/custom_show.html.twig', [

            "city" => $city,
            "properties" => $propertyRepository->findByAddressCity($name)
        ]);
    }

    /**
     * @Route("/{id}", name="city_show", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function show(City $city): Response
    {
        return $this->render('city/show.html.twig', [
            'city' => $city,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="city_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, City $city): Response
    {
        $form = $this->createForm(CityType::class, $city);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dateNow = new DateTime();
            $entityManager = $this->getDoctrine()->getManager();
            $updatedAt = new DateTime();
            $file = $form['pictureFile']->getData();
            $file->move("images/global", $file->getClientOriginalName());
            $picture = new Picture();
            $picture->setName($file->getClientOriginalName());
            $picture->setCreatedAt($updatedAt);
            $city->addPicture($picture);

            $city->setCreatedAt($dateNow);
            $city->setUpdatedAt($dateNow);

            $entityManager->persist($picture);
            $entityManager->persist($city);
            $entityManager->flush();

            return $this->redirectToRoute('city_index');




            return $this->redirectToRoute('city_index');
        }

        return $this->render('city/edit.html.twig', [
            'city' => $city,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="city_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, City $city): Response
    {
        if ($this->isCsrfTokenValid('delete' . $city->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($city);
            $entityManager->flush();
        }

        return $this->redirectToRoute('city_index');
    }
}

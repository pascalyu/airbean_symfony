<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\SearchType;
use App\Form\SubscribeType;
use App\Repository\CountryRepository;
use App\Repository\PropertyRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(CountryRepository $countryRepository)
    {

        return $this->render(
            'home/index.html.twig',
            [
                'countries' => $countryRepository->findAll(),
            ]
        );
    }

    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {

        $user = new User();
        $form = $this->createForm(SubscribeType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);


            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('app_login');
        }
        return $this->render('home/register.html.twig', [
            'userForm' => $form->createView(),
        ]);
    }


    /**
     * @Route("/searchbar", name="search_bar")
     */
    public function searchbarRender(CountryRepository $countryRepository, Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {




        if ($request->getMethod() == Request::METHOD_POST) {

            $country = $request->request->get('country');

            return $this->redirectToRoute('custom_show', ['name' =>  $country[0]]);
        }
        return $this->render('addon/search.html.twig', [
            'countries' => $countryRepository->findAll(),
        ]);
    }
}

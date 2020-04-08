<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ParameterUserType;
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
    /**
     * @Route("/parameter", name="parameter_user")
     */
    public function parameterUser(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        $user = $this->getUser();
        $form = $this->createForm(ParameterUserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $manager->persist($user);
            $manager->flush();
        }
        return $this->render('home/parameter_user.html.twig', [
            'userForm' => $form->createView(),
        ]);
    }


    /**
     * @Route("/dashboardAdmin", name="dashboard_admin")
     */
    public function dashboardAdmin()
    {
        $dashboardList = array();
        $dashboardList[] = [
            "title" => "Utilisateur",
            "path" => "user_index",
            "path_name" => "Liste des utilisateurs"
        ];
        $dashboardList[] = [
            "title" => "Pays",
            "path" => "country_index",
            "path_name" => "liste des pays"
        ];
        $dashboardList[] = [
            "title" => "Ville",
            "path" => "city_index",
            "path_name" => "Liste des villes"
        ];
        return $this->render('home/dashboard_admin.html.twig', [
            'dashboardList' => $dashboardList,

        ]);
    }
}

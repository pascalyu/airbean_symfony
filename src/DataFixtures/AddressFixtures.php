<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends Fixture
{



    public function load(ObjectManager $objectManager)
    {

        $objectManager->persist($this->makeAddress("92 avenue maurice thorez", "94200", "Ivry sur seine", "France"));
        $objectManager->persist($this->makeAddress("56 Boulevard Saint-Marcel", "75005", "Paris", "France"));
        $objectManager->persist($this->makeAddress("Boulevard du 14 Juillet", "10000", "Troyes", "France"));
        $objectManager->persist($this->makeAddress("Circonvallazione dalla Chiesa, 671", "01034", "Fabrica di Roma", "Italy"));
        $objectManager->persist($this->makeAddress("RADIOLE, Calle Gran Vía, 32", "28013", "Madrid", "Spain"));
        $objectManager->persist($this->makeAddress("Farmacia Julia Campos, Av. de Cervantes, 8", "10005", "Cáceres", "Spain"));
        $objectManager->persist($this->makeAddress("test", "999999", "Ivry sur test", "test"));

        $objectManager->flush();
    }
    public function makeAddress($streetName, $zipCode, $city, $country)
    {
        $address = new Address();
        $address->setStreetName($streetName);
        $address->setZipCode($zipCode);
        $address->setCity($city);
        $address->setCountry($country);

        return $address;
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\Property;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class PropertyFixtures extends Fixture
{



    public function load(ObjectManager $objectManager)
    {
        for ($i = 0; $i < 10; $i++) {
            $objectManager->persist($this->makeProperty($i * 10, "description " . $i, ($i % 3) + 1, ($i % 2) + 1, ($i % 4) + 1, $i * 10));
        }
        $objectManager->flush();
    }
    public function makeProperty($surfaceArea, $description, $roomnbr, $bedSmallNbr, $bedBigNbr, $pricePerDay)
    {
        $property = new Property();
        $property->setSurfaceArea($surfaceArea);
        $property->setDescription($description);
        $property->setRoomNbr($roomnbr);
        $property->setBedSmallNbr($bedSmallNbr);
        $property->setBedBigNbr($bedBigNbr);
        $property->setPricePerDay($pricePerDay);
        return $property;
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $objectManager)
    {
        for ($i = 0; $i < 10; $i++) {
            $objectManager->persist($this->makeUser("userfix" . $i . "@yopmail.com", "0000"));
        }
        $objectManager->flush();
    }
    public function makeUser($email, $password)
    {
        $user = new User();
        $user->setEmail($email);
        $user->setPassword($password);
        return $user;
    }
}

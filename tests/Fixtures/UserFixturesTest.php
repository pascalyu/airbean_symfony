<?php 

namespace App\DataFixtures;
use app\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;



class UserFixtures extends Fixture{
    
    public function load(ObjectManager $objectManager){
        for($i=0;$i<10;$i++){
            $user= new User();
            $user->setEmail("userfix".$i."@yopmail.com");
            $user->setPassword("0000");

            $objectManager->persist($user);
        }
        $objectManager->flush();
    }

}
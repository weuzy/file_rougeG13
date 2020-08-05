<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $user=new User();
        $user->setUsername('admin');
        $user->setPassword('diakhate');
        $user->setRoles(["ROLE_ADMIN"]);
        $manager->persist($user);

        $manager->flush();
    }
}

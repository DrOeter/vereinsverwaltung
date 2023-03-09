<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setUsername('superadmin');
        $user->setProfession(1);
        $user->setBirthday(new \DateTime('1990-10-3'));
        $user->setPlainPassword('superadmin');
        $manager->persist($user);
        $this->addReference('superadmin', $user);

        $user = new User();
        $user->setUsername('kalle');
        $user->setProfession(1);
        $user->setBirthday(new \DateTime('1990-10-3'));
        $user->setPlainPassword('superadmin');
        $manager->persist($user);
        $this->addReference('kalle', $user);

        $user = new User();
        $user->setUsername('marianne');
        $user->setProfession(2);
        $user->setBirthday(new \DateTime('1990-10-3'));
        $user->setPlainPassword('superadmin');
        $manager->persist($user);
        $this->addReference('marianne', $user);

        $user = new User();
        $user->setUsername('zork');
        $user->setProfession(3);
        $user->setBirthday(new \DateTime('1990-10-3'));
        $user->setPlainPassword('superadmin');
        $manager->persist($user);
        $this->addReference('zork', $user);

        $manager->flush();
    }

}

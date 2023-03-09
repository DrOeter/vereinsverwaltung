<?php

namespace App\DataFixtures;

use App\Entity\Account;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AccountFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $account = new Account();
        $account->setAccountHolderName('superadmin');
        $account->setAccountNumber(420);
        $account->setAccountType('DNP');
        $account->setStatusOfAccount(1);
        $account->setIban('wet8ug4iugu4gh4');
        $account->setBic('cock');
        $account->setUser($this->getReference('superadmin'));
        $account->setBalance(100.00);
        $manager->persist($account);

        $account = new Account();
        $account->setAccountHolderName('kalle');
        $account->setAccountNumber(420);
        $account->setAccountType('DNP');
        $account->setStatusOfAccount(1);
        $account->setIban('wet8ug4iugu4gh4');
        $account->setBic('cock');
        $account->setUser($this->getReference('kalle'));
        $account->setBalance(100.00);
        $manager->persist($account);

        $account = new Account();
        $account->setAccountHolderName('marianne');
        $account->setAccountNumber(420);
        $account->setAccountType('DNP');
        $account->setStatusOfAccount(1);
        $account->setIban('wet8ug4iugu4gh4w');
        $account->setBic('cockc');
        $account->setUser($this->getReference('marianne'));
        $account->setBalance(100.00);
        $manager->persist($account);

        $account = new Account();
        $account->setAccountHolderName('zork');
        $account->setAccountNumber(420);
        $account->setAccountType('DNP');
        $account->setStatusOfAccount(1);
        $account->setIban('wet8ug4iugu4gh344');
        $account->setBic('coc121k');
        $account->setUser($this->getReference('zork'));
        $account->setBalance(100.00);
        $manager->persist($account);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }

}

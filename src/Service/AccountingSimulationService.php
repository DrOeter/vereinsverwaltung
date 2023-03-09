<?php
namespace App\Service;

use App\Entity\AccountActivity;
use App\Entity\User;
use App\Repository\AccountActivityRepository;
use App\Repository\UserRepository;
use App\Service\MembershipFeeService;
use Doctrine\ORM\EntityManagerInterface;

class AccountingSimulationService
{
    private $feeService;
    private $accountActivityRepository;
    private $userRepository;
    private $em;

    public function __construct(MembershipFeeService $feeService, AccountActivityRepository $accountActivityRepository, UserRepository $userRepository, EntityManagerInterface $em)
    {
        $this->feeService = $feeService;
        $this->accountActivityRepository = $accountActivityRepository;
        $this->userRepository = $userRepository;
        $this->em = $em;
    }

    
    public function executeSepa(User $user)
    {
        //simulation von Sepa mit bank
    //    $sepa = new Sepa();

        if ($user->isSepaAllowed())
        {
            $amount = $this->feeService->calculateFee($user);
            $this->createAccountActivity($user, $amount);
        } else {
            // send email etc...
        }

    }

    public function createAccountActivity(User $user, float $amount)
    {
        if (!empty($user->getAccount())) {

            $superadmin = $this->userRepository->findOneBy(['userName' => 'superadmin']);

            $superadminAccount = $superadmin->getAccount();

            $accountActivity = new AccountActivity();
            $accountActivity->setAccount($superadminAccount);
            $accountActivity->setAccountNumber($superadminAccount->getAccountNumber());
            $accountActivity->setTransactionDate(new \DateTime());
            $accountActivity->setTransactionType(2);
            $accountActivity->setAmount($amount);

            $this->accountActivityRepository->add($accountActivity, true);

            $newBalance = $superadminAccount->getBalance() + $amount;
            $superadminAccount->setBalance($newBalance);

            $userAccount = $user->getAccount();

            $accountActivity = new AccountActivity();
            $accountActivity->setAccount($userAccount);
            $accountActivity->setAccountNumber($userAccount->getAccountNumber());
            $accountActivity->setTransactionDate(new \DateTime());
            $accountActivity->setTransactionType(2);
            $accountActivity->setAmount(-$amount);

            $this->accountActivityRepository->add($accountActivity, true);

            $newBalance = $userAccount->getBalance() - $amount;
            $userAccount->setBalance($newBalance);

            $this->em->flush();
        }
    }

    // TODO: Jahresbilianz berechnen
    // summe aller amounts aller accountaktivitäten einer jahres
    public function calculateAnnualBalance(string $year)
    {
        return $this->accountActivityRepository->getSumOfAllAccountActivities($year);
    }

    public function getMoney()
    {
        $users = $this->userRepository->findAll();
        foreach($users as $user)
        {
            $this->executeSepa($user);
        }

        return 0;
    }

}
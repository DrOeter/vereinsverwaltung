<?php
namespace App\Service;

use App\Entity\AccountActivity;
use App\Entity\User;
use App\Repository\AccountActivityRepository;
use App\Repository\UserRepository;
use App\Service\MembershipFeeService;

class AccountingSimulationService
{
    private $feeService;
    private $accountActivityRepository;
    private $userRepository;

    public function __construct(MembershipFeeService $feeService, AccountActivityRepository $accountActivityRepository, UserRepository $userRepository)
    {
        $this->feeService = $feeService;
        $this->accountActivityRepository = $accountActivityRepository;
        $this->userRepository = $userRepository;
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
            $accountActivity = new AccountActivity();
            $accountActivity->setAccount($user->getAccount());
            $accountActivity->setAccountNumber($user->getAccount()->getAccountNumber());
            $accountActivity->setTransactionDate(new \DateTime());
            $accountActivity->setTransactionType(2);
            $accountActivity->setAmount($amount);

            $this->accountActivityRepository->add($accountActivity, true);
        }
    }

    // TODO: Jahresbilianz berechnen
    // summe aller amounts aller accountaktivitäten einer jahres
    public function calculateAnnualBalance(\DateTIme $from, \DateTime $to)
    {
        return $this->accountActivityRepository->getSumOfAllAccountActivities($from, $to);
    }

    public function getMoney()
    {
        $users = $this->userRepository->findAll();
        foreach($users as $user)
        {
            $this->executeSepa($user);
        }
dump($this->accountActivityRepository->findAll());
        return 0;
    }

}
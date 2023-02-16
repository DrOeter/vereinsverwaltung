<?php
namespace App\Service;

use App\Entity\AccountActivity;
use App\Entity\User;
use App\Repository\AccountActivityRepository;
use App\Service\MembershipFeeService;

class AccountingSimulationService
{
    private $feeService;
    private $accountActivityRepository;

    public function __construct(MembershipFeeService $feeService, AccountActivityRepository $accountActivityRepository)
    {
        $this->feeService = $feeService;
        $this->accountActivityRepository = $accountActivityRepository;
    }
    
    
    public function executeSepa(User $user)
    {
        //simulation von Sepa mit bank
    //    $sepa = new Sepa();
        
        $amount = $this->feeService->calculateFee($user);
        $this->createAccountActivity($user, $amount);

    }

    public function createAccountActivity(User $user, float $amount)
    {
        $accountActivity = new AccountActivity();
        $accountActivity->setAccount($user->getAccount());
        $accountActivity->setAccountNumber($user->getAccount()->getAccountNumber());
        $accountActivity->setTransactionDate(new \DateTime());
        $accountActivity->setTransactionType(2);
        $accountActivity->setAmount($amount);

        $this->accountActivityRepository->add($accountActivity, true);
    }

    // TODO: Jahresbilianz berechnen
    // summe aller amounts aller accountaktivitäten einer jahres

}
<?php

namespace App\Controller;

use App\Service\AccountingSimulationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/annual-balance")
 */
class AnnualBalanceController extends AbstractController
{
    /**
     * @Route("/", name="app_annual_balance_index", methods={"GET"})
     */
    public function index(AccountingSimulationService $accountingSimulationService): Response
    {
        $from = new \DateTime('01-01-2023');
        $to = new \DateTime('31-01-2023');
        $thisYear = $from->format('Y');

        $annualBalance = $accountingSimulationService->calculateAnnualBalance($from, $to);

        return $this->render('annual_balance/index.html.twig', [
            'annualBalance' => $annualBalance ?? 'no account activities found',
            'year' => $thisYear
        ]);
    }

    /**
     * @Route("/get-money", name="app_annual_balance_get_money", methods={"GET"})
     */
    public function getMoney(AccountingSimulationService $accountingSimulationService): Response
    {
        $accountingSimulationService->getMoney();

        return new JsonResponse();
    }

}

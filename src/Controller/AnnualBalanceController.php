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
        $thisYear = '2023';

        $annualBalance = $accountingSimulationService->calculateAnnualBalance($thisYear);

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

        return new JsonResponse('get rich or die trying');
    }

}

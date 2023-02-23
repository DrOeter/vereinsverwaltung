<?php

namespace App\Controller;

use App\Entity\AccountActivity;
use App\Form\AccountActivityType;
use App\Repository\AccountActivityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/account/activity")
 */
class AccountActivityController extends AbstractController
{
    /**
     * @Route("/", name="app_account_activity_index", methods={"GET"})
     */
    public function index(AccountActivityRepository $accountActivityRepository): Response
    {
        return $this->render('account_activity/index.html.twig', [
            'account_activities' => $accountActivityRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_account_activity_new", methods={"GET", "POST"})
     */
    public function new(Request $request, AccountActivityRepository $accountActivityRepository): Response
    {
        $accountActivity = new AccountActivity();
        $form = $this->createForm(AccountActivityType::class, $accountActivity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $accountActivityRepository->add($accountActivity, true);

            return $this->redirectToRoute('app_account_activity_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('account_activity/new.html.twig', [
            'account_activity' => $accountActivity,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_account_activity_show", methods={"GET"})
     */
    public function show(AccountActivity $accountActivity): Response
    {
        return $this->render('account_activity/show.html.twig', [
            'account_activity' => $accountActivity,
        ]);
    }

    // account activity should not be editable, as the data only reflects data from third-party systems
    //
    // /**
    //  * @Route("/{id}/edit", name="app_account_activity_edit", methods={"GET", "POST"})
    //  */
    // public function edit(Request $request, AccountActivity $accountActivity, AccountActivityRepository $accountActivityRepository): Response
    // {
    //     $form = $this->createForm(AccountActivityType::class, $accountActivity);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $accountActivityRepository->add($accountActivity, true);

    //         return $this->redirectToRoute('app_account_activity_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->renderForm('account_activity/edit.html.twig', [
    //         'account_activity' => $accountActivity,
    //         'form' => $form,
    //     ]);
    // }

    // account activity should not be deleted, as the data only reflects data from third-party systems
    //
    // /**
    //  * @Route("/{id}", name="app_account_activity_delete", methods={"POST"})
    //  */
    // public function delete(Request $request, AccountActivity $accountActivity, AccountActivityRepository $accountActivityRepository): Response
    // {
    //     if ($this->isCsrfTokenValid('delete'.$accountActivity->getId(), $request->request->get('_token'))) {
    //         $accountActivityRepository->remove($accountActivity, true);
    //     }

    //     return $this->redirectToRoute('app_account_activity_index', [], Response::HTTP_SEE_OTHER);
    // }
}

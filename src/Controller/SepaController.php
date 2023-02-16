<?php

namespace App\Controller;

use App\Entity\Sepa;
use App\Form\SepaType;
use App\Repository\SepaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sepa")
 */
class SepaController extends AbstractController
{
    /**
     * @Route("/", name="app_sepa_index", methods={"GET"})
     */
    public function index(SepaRepository $sepaRepository): Response
    {
        return $this->render('sepa/index.html.twig', [
            'sepas' => $sepaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_sepa_new", methods={"GET", "POST"})
     */
    public function new(Request $request, SepaRepository $sepaRepository): Response
    {
        $sepa = new Sepa();
        $form = $this->createForm(SepaType::class, $sepa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sepaRepository->add($sepa, true);

            return $this->redirectToRoute('app_sepa_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sepa/new.html.twig', [
            'sepa' => $sepa,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_sepa_show", methods={"GET"})
     */
    public function show(Sepa $sepa): Response
    {
        return $this->render('sepa/show.html.twig', [
            'sepa' => $sepa,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_sepa_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Sepa $sepa, SepaRepository $sepaRepository): Response
    {
        $form = $this->createForm(SepaType::class, $sepa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sepaRepository->add($sepa, true);

            return $this->redirectToRoute('app_sepa_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sepa/edit.html.twig', [
            'sepa' => $sepa,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_sepa_delete", methods={"POST"})
     */
    public function delete(Request $request, Sepa $sepa, SepaRepository $sepaRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sepa->getId(), $request->request->get('_token'))) {
            $sepaRepository->remove($sepa, true);
        }

        return $this->redirectToRoute('app_sepa_index', [], Response::HTTP_SEE_OTHER);
    }
}

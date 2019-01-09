<?php

namespace App\Controller;

use App\Entity\Tornooi;
use App\Form\TornooiType;
use App\Repository\TornooiRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tornooi")
 */
class TornooiController extends AbstractController
{
    /**
     * @Route("/", name="tornooi_index", methods={"GET"})
     */
    public function index(TornooiRepository $tornooiRepository): Response
    {
        return $this->render('tornooi/index.html.twig', [
            'tornoois' => $tornooiRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="tornooi_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $tornooi = new Tornooi();
        $form = $this->createForm(TornooiType::class, $tornooi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tornooi);
            $entityManager->flush();

            return $this->redirectToRoute('tornooi_index');
        }

        return $this->render('tornooi/new.html.twig', [
            'tornooi' => $tornooi,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tornooi_show", methods={"GET"})
     */
    public function show(Tornooi $tornooi): Response
    {
        return $this->render('tornooi/show.html.twig', [
            'tornooi' => $tornooi,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tornooi_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Tornooi $tornooi): Response
    {
        $form = $this->createForm(TornooiType::class, $tornooi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tornooi_index', [
                'id' => $tornooi->getId(),
            ]);
        }

        return $this->render('tornooi/edit.html.twig', [
            'tornooi' => $tornooi,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tornooi_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Tornooi $tornooi): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tornooi->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tornooi);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tornooi_index');
    }
}

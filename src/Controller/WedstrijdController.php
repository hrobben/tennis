<?php

namespace App\Controller;

use App\Entity\Wedstrijd;
use App\Form\WedstrijdType;
use App\Repository\WedstrijdRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/wedstrijd")
 */
class WedstrijdController extends AbstractController
{
    /**
     * @Route("/", name="wedstrijd_index", methods={"GET"})
     */
    public function index(WedstrijdRepository $wedstrijdRepository): Response
    {
        return $this->render('wedstrijd/index.html.twig', [
            'wedstrijds' => $wedstrijdRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="wedstrijd_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $wedstrijd = new Wedstrijd();
        $form = $this->createForm(WedstrijdType::class, $wedstrijd);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($wedstrijd);
            $entityManager->flush();

            return $this->redirectToRoute('wedstrijd_index');
        }

        return $this->render('wedstrijd/new.html.twig', [
            'wedstrijd' => $wedstrijd,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="wedstrijd_show", methods={"GET"})
     */
    public function show(Wedstrijd $wedstrijd): Response
    {
        return $this->render('wedstrijd/show.html.twig', [
            'wedstrijd' => $wedstrijd,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="wedstrijd_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Wedstrijd $wedstrijd): Response
    {
        $form = $this->createForm(WedstrijdType::class, $wedstrijd);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('wedstrijd_index', [
                'id' => $wedstrijd->getId(),
            ]);
        }

        return $this->render('wedstrijd/edit.html.twig', [
            'wedstrijd' => $wedstrijd,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="wedstrijd_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Wedstrijd $wedstrijd): Response
    {
        if ($this->isCsrfTokenValid('delete'.$wedstrijd->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($wedstrijd);
            $entityManager->flush();
        }

        return $this->redirectToRoute('wedstrijd_index');
    }
}

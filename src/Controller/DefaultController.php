<?php

namespace App\Controller;

use App\Repository\WedstrijdRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index()
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/makeGame", name="makeGame")
     */
    public function makeGame(WedstrijdRepository $wedstrijdRepository): Response
    {
        $em = $this->getDoctrine()->getManager();
        $spelers = $em->getRepository('App:Speler')->findAll();

        $wedstrijd = [];
        foreach ($spelers as $speler) {
            array_push($wedstrijd, $speler->getId());
        }

        // maximaal 128 deelnemers, formule voor rest is
        if (shuffle($wedstrijd)) {
            dump($wedstrijd);


        }

        return $this->render('wedstrijd/index.html.twig', [
            'wedstrijds' => $wedstrijdRepository->findAll(),
        ]);
    }

}

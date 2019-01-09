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

        /* maximaal 128 deelnemers, formule voor rest is    ( er zijn b.v. 100 deelnemers)
         * secuence is 128, 64, 32, 16, 8, 4, 2 ronde 1, 2, 3, 4, 5, 6, 7
         * formule 1:  aantal_deelnemers - (128 - aantal_deelnemers) = deelnemers_ronde_1    (72) (36 wedstrijden)
         * er gaan ;  naar_ronde_2 = aantal_deelnemers - deelnemers_ronde_1     (28 gaan er zo door).
         *
         * als er teveel aanmeldingen zijn dan alle spelers boven 128 uitsluiten.
         */
        if (shuffle($wedstrijd)) {
            dump($wedstrijd);
            if (count($wedstrijd) < 128) {
                // gaan spelers direct naar ronde 2.
                if (count($wedstrijd) < 64 ) {
                    // we slaan ronde 1 over.
                }
            }


        }

        return $this->render('wedstrijd/index.html.twig', [
            'wedstrijds' => $wedstrijdRepository->findAll(),
        ]);
    }

}

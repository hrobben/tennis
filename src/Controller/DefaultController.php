<?php

namespace App\Controller;

use App\Entity\Speler;
use App\Entity\Wedstrijd;
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

        $speler=$em->getRepository('App:Speler')->findOneBy(['id' => $wedstrijd[0]]);
        $tornooi = $speler->getTornooi();
        //dump($tornooi[0]);
        /* maximaal 128 deelnemers, formule voor rest is    ( er zijn b.v. 100 deelnemers)
         * secuence is 128, 64, 32, 16, 8, 4, 2 ronde 1, 2, 3, 4, 5, 6, 7
         * formule 1:  aantal_deelnemers - (128 - aantal_deelnemers) = deelnemers_ronde_1    (72) (36 wedstrijden)
         * er gaan ;  naar_ronde_2 = aantal_deelnemers - deelnemers_ronde_1     (28 gaan er zo door).
         *
         * als er teveel aanmeldingen zijn dan alle spelers boven 128 uitsluiten.
         */
        if (shuffle($wedstrijd)) {
            if (count($wedstrijd) == 128) {
                // genoeg spelers.
                for ($i = 1; $i < count($wedstrijd); $i++) {
                    $game = new Wedstrijd();
                    $game->setRonde(1);
                    $game->setSpeler1($em->getRepository('App:Speler')->findOneBy(['id' => $wedstrijd[$i-1]]));
                    $game->setSpeler2($em->getRepository('App:Speler')->findOneBy(['id' => $wedstrijd[++$i-1]]));
                    $game->setTornooi($tornooi[0]);
                    $em->persist($game);
                    $em->flush();
                }
            } elseif (count($wedstrijd) > 64) {
                // eerst de rest al naar ronde twee zetten.
                $ronde1 = count($wedstrijd) - (128 - count($wedstrijd));  // 72 36games.
                $ronde2 = count($wedstrijd) - $ronde1;  // 28 meteen naar ronde 2.
                for ($i = 1; $i < $ronde2; $i++) {
                    // de eerste 28 stuks ronde 2
                    $game = new Wedstrijd();
                    $game->setRonde(2);
                    $game->setSpeler1($em->getRepository('App:Speler')->findOneBy(['id' => $wedstrijd[$i-1]]));
                    $game->setSpeler2($em->getRepository('App:Speler')->findOneBy(['id' => $wedstrijd[++$i-1]]));
                    $game->setTornooi($tornooi[0]);
                    $em->persist($game);
                    $em->flush();
                }
                for ($i = $ronde2; $i < count($wedstrijd); $i++) {
                    $game = new Wedstrijd();
                    $game->setRonde(1);
                    $game->setSpeler1($em->getRepository('App:Speler')->findOneBy(['id' => $wedstrijd[$i-1]]));
                    $game->setSpeler2($em->getRepository('App:Speler')->findOneBy(['id' => $wedstrijd[++$i-1]]));
                    $game->setTornooi($tornooi[0]);
                    $em->persist($game);
                    $em->flush();
                }
            } else {
                return $this->render('default/index.html.twig', [
                    'controller_name' => 'DefaultController',
                ]);
            }

        }

        return $this->render('wedstrijd/index.html.twig', [
            'wedstrijds' => $wedstrijdRepository->findAll(),
        ]);
    }

}

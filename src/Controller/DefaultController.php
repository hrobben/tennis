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
            // als speler ingeschreven is.
            array_push($wedstrijd, $speler->getId());
        }

        $speler = $em->getRepository('App:Speler')->findOneBy(['id' => $wedstrijd[0]]);
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
                    $game->setSpeler1($em->getRepository('App:Speler')->findOneBy(['id' => $wedstrijd[$i - 1]]));
                    $game->setSpeler2($em->getRepository('App:Speler')->findOneBy(['id' => $wedstrijd[++$i - 1]]));
                    $game->setTornooi($tornooi[0]);
                    $em->persist($game);
                    $em->flush();
                }
            } elseif ((count($wedstrijd) > 64) and (count($wedstrijd) < 128)) {  // moet dus tussen 64 en 128 zitten.
                // eerst de rest al naar ronde twee zetten.
                $ronde1 = count($wedstrijd) - (128 - count($wedstrijd));  // 72 36games.
                $ronde2 = count($wedstrijd) - $ronde1;  // 28 meteen naar ronde 2.
                for ($i = 1; $i < $ronde2; $i++) {
                    // de eerste 28 stuks ronde 2
                    $game = new Wedstrijd();
                    $game->setRonde(2);
                    $game->setSpeler1($em->getRepository('App:Speler')->findOneBy(['id' => $wedstrijd[$i - 1]]));
                    $game->setSpeler2($em->getRepository('App:Speler')->findOneBy(['id' => $wedstrijd[++$i - 1]]));
                    $game->setTornooi($tornooi[0]);
                    $em->persist($game);
                    $em->flush();
                }
                for ($i = $ronde2; $i < count($wedstrijd); $i++) {
                    $game = new Wedstrijd();
                    $game->setRonde(1);
                    $game->setSpeler1($em->getRepository('App:Speler')->findOneBy(['id' => $wedstrijd[$i - 1]]));
                    $game->setSpeler2($em->getRepository('App:Speler')->findOneBy(['id' => $wedstrijd[++$i - 1]]));
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

    /**
     * @Route("/checkGame", name="checkGame")
     */
    public function checkGame(WedstrijdRepository $wedstrijdRepository): Response
    {
        // check if all winners are calculated, otherwise show the equal scores.
        $em = $this->getDoctrine()->getManager();
        $wedstrijden = $wedstrijdRepository->findAll();
        foreach ($wedstrijden as $wedstrijd) {
            if ($wedstrijd->getScore1() > $wedstrijd->getScore2()) {
                $wedstrijd->setWinnaar($wedstrijd->getSpeler1());
            } elseif ($wedstrijd->getScore1() < $wedstrijd->getScore2()) {
                $wedstrijd->setWinnaar($wedstrijd->getSpeler2());
            }
            $em->persist($wedstrijd);
            $em->flush();
        }
        return $this->render('wedstrijd/index.html.twig', [
            'wedstrijds' => $wedstrijdRepository->findBy(['winnaar' => null]),
        ]);

    }

    /**
     * @Route("/make32Game", name="make32Game")
     */
    public function make32Game(WedstrijdRepository $wedstrijdRepository): Response
    {
        // All scores are known. Make next 32 to 16 round.
    }

    /**
     * @Route("/closeGame/{id}", name="closeGame")
     */
    public function closeGame(WedstrijdRepository $wedstrijdRepository, $id): Response
    {
        // afsluiten ronde nummer {id}
        $wedstrijden = $wedstrijdRepository->findBy(['ronde' => $id]);
        // twee aan twee bij elkaar brengen in nieuw record voor volgende ronde.
        $teller = 1;
        foreach ($wedstrijden as $wedstrijd) {
            // winnaar eerste wedstrijd tegen winnaar tweede wedstrijd.
            if ($teller & 1) { // oneven
                $ws = new Wedstrijd();
                $ws->setTornooi($wedstrijd->getTornooi());
                $ws->setRonde($id + 1);
            }
            if ($teller % 2 == 0) {   // als teller even.
                $ws->setSpeler2($wedstrijd->getWinnaar());
                // na de tweede schrijven.
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($ws);
                $entityManager->flush();
                ++$teller;
            } else {
                $ws->setSpeler1($wedstrijd->getWinnaar());
                ++$teller;
            }
            dump($teller);
        }
        return $this->render('wedstrijd/index.html.twig', [
            'wedstrijds' => $wedstrijden,
        ]);
    }
}

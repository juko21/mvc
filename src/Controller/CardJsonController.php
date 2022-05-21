<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Card\Deck;

class CardJsonController extends AbstractController
{
    /**
     * @Route("/card/api/deck", name="json-api",
     * methods={"GET","HEAD"})
     */
    public function jsonApiGet(SessionInterface $session): Response
    {
        $deck = $session->get('deck');
        if (!$deck) {
            $deck = new Deck();
            $session->set("deck", $deck);
        }
        $tempDeck = $deck->sorted();
        $response = new Response();
        $response->setContent(json_encode($tempDeck));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}

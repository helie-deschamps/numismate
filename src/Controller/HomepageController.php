<?php

namespace App\Controller;

use App\Repository\CoinRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomepageController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function index(CoinRepository $coinRepository, ManagerRegistry $doctrine): Response
    {
        if(!$this->getUser()){ // If user is not logged in
            return $this->redirectToRoute('app_login');
        }
        if(isset($_GET["type"]) && isset($_GET["id"]) && $_GET["type"] == "coin_geted"){ // If its for add a new coin possesed by the user
            $this->getUser()->addCoinsOwned($coinRepository->find($_GET["id"]));
            $doctrine->getManager()->flush();
        }
        $coins = $coinRepository->findAll();
        uasort($coins, function($a, $b) {
            return $a->getName() < $b->getName() ? -1 : 1;
        });
        return $this->render('homepage/index.html.twig', [
            'controller_name' => 'HomepageController',
            'user' => $this->getUser(),
            'user_coins_count' => $this->getUser()->getCoinsOwned()->count(),
            'coins' => $coins,
            'coins_count' => count($coins),
        ]);
    }
}

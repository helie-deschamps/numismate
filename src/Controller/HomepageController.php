<?php

namespace App\Controller;

use App\Repository\CoinRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomepageController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function index(CoinRepository $coinRepository): Response
    {
        if(!$this->getUser()){ // If user is not logged in
            return $this->redirectToRoute('app_login');
        }
        return $this->render('homepage/index.html.twig', [
            'controller_name' => 'HomepageController',
            'user' => $this->getUser(),
            'user_coins_count' => $this->getUser()->getCoinsOwned()->count(),
            'coins' => $coinRepository->findAll(),
            'coins_count' => count($coinRepository->findAll()),
        ]);
    }
}

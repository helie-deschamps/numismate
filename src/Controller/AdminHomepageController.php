<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdminHomepageController extends AbstractController
{
    #[Route('/admin', name: 'app_admin_homepage')]
    public function index(): Response
    {
        return $this->render('admin_homepage/index.html.twig', [
            'controller_name' => 'AdminHomepageController',
        ]);
    }
}

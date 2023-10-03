<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/coordonateur', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    #[Route('/rh', name: 'rh')]
    public function rh(): Response
    {
        return $this->render('rh/index.html.twig');
    }
}

<?php

namespace App\Controller\back;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/home", name="back_app_main")
     */
    public function index(): Response
    {
        return $this->render('back/main/home.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}

<?php

namespace App\Controller\front;

use App\Model\Movie;
use App\Repository\MovieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * On étends AbstractController => c'est comme ca dans tous les controller dans symfony, car AbstractController nous offre plein de méthodes dont on va avoir besoin dans nos controller
 */
class MainController extends AbstractController
{
    /**
     * Page d'accueil
     * 
     * @Route("/", name="home")
     */
    public function home(MovieRepository $movieRepository)
    {
        // 1ere etape : on recupere les Movie depuis la bdd a l'aide du MovieRepository
        $movies = $movieRepository->findAllOrderByReleaseDateDql();
        // On retourne la vue twig home.html.twig
        return $this->render('front/main/home.html.twig', [
            'movies' => $movies
        ]);
    }
}

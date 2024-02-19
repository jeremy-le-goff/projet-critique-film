<?php

namespace App\Controller\front;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Model\Movie;

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
    public function home()
    {
        $movies = Movie::getMovies();
        // retourne la vue twig home.html.twig
        return $this->render('main/home.html.twig', [
            //je passe $movies à ma view
            'movies' => $movies
        ]);
    }
}

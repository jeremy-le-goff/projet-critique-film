<?php

namespace App\Controller\front;

use App\Model\Movie;
use App\Repository\CastingRepository;
use App\Repository\MovieRepository;
use App\Repository\ReviewRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 *@Route("/movie")
 */

class MovieController extends AbstractController
{
    /**
     * @Route("/", name="app_movie_list")
     */
    public function index(): Response
    {
        return $this->render('front/movie/list.html.twig', [
            'controller_name' => 'MovieController',
        ]);
    }

    /**
     * Page ma liste
     * 
     * @Route("/favorite", name="app_movie_favorites")
     */

    public function favorite()
    {
        return $this->render('front/movie/favorite.html.twig');
    }

    /**
     * Page de détail d'un film
     *
     * @Route("/show/{id}", name="app_movie_show", methods={"GET"})
     */

    public function show($id, MovieRepository $movieRepository, CastingRepository $castingRepository)
    {

        $movie = $movieRepository->find($id);
        $castingsByCredit = $castingRepository->findByCastingToMovie($movie);
        dump($castingsByCredit);



        if ($movie === null) {
            throw $this->createNotFoundException('Film ou série non trouvé');
        }
        return $this->render('front/movie/show.html.twig', [
            'movie' => $movie,
            'castingsByCredit' => $castingsByCredit
        ]);
    }
}

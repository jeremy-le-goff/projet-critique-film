<?php

namespace App\Controller\front;

use App\Entity\Movie;
use App\Entity\Review;
use App\Form\ReviewType;
use App\Repository\MovieRepository;
use App\Repository\ReviewRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;




class ReviewController extends AbstractController
{
    /**
     * @Route("/review/{id}", name="app_review")
     */
    public function add(Movie $movie, Request $request, ReviewRepository $reviewRepository): Response
    {
        // dd($movie);
        // On créer une instance de review, c'est cette instance qu'on va manipuler dans le formulaire
        $review = new Review();

        // J'associe $review a mon formulaire
        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // dd($review);
            // On associe le film $movie a notre critique $review
            $review->setMovie($movie);
            // On ajoute $review en bdd
            $reviewRepository->add($review, true);
            return $this->redirectToRoute("app_movie_show", ['id' => $movie->getId()]);
        }

        // On utilise renderForm pour retourner une vue avec un formulaire
        // Si on utilisait render(), le form ne s'afficherait pas
        return $this->renderForm('front/review/add.html.twig', [
            'movie' => $movie,
            'form' => $form
        ]);
    }
}

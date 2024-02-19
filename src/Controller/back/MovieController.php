<?php

namespace App\Controller\back;

use App\Entity\Movie;
use App\Form\MovieType;
use App\Repository\MovieRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MovieController extends AbstractController
{
    /**
     * @Route("/browse", name="app_browse")
     */
    public function browse(MovieRepository $movieRepository): Response
    {
        $movies = $movieRepository->findAll();
        return $this->render('back/movie/browse.html.twig', [
            'movies' => $movies,
        ]);
    }
    /**
     * @Route("/add", name="app_back_movie_add", methods={"GET", "POST"})
     */

    public function add(Request $request, MovieRepository $movieRepository): Response
    {
        $movie = new Movie();
        $form = $this->createForm(MovieType::class, $movie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $movieRepository->add($movie, true);

            return $this->redirectToRoute('app_browse', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/movie/add.html.twig', [
            'movie' => $movie,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/show/{id}", name="app_back_movie_show", methods={"GET"})
     */
    public function show(Movie $movie): Response
    {
        return $this->render('back/show.html.twig', [
            'movie' => $movie,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_back_movie_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Movie $movie, MovieRepository $movieRepository): Response
    {
        $form = $this->createForm(MovieType::class, $movie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $movieRepository->add($movie, true);

            return $this->redirectToRoute('app_browse', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/movie/edit.html.twig', [
            'movie' => $movie,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/remove/{id}", name="app_back_Movie_delete", methods={"GET"})
     */
    public function delete($id, MovieRepository $movieRepository): Response
    {
        $movie = $movieRepository->find($id);
        $movieRepository->remove($movie, $flush = true);
        return $this->redirectToRoute('app_browse');
    }
}

<?php

namespace App\Controller\back;

use App\Entity\Season;
use App\Form\SeasonType;
use App\Repository\SeasonRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SeasonController extends AbstractController
{
    /**
     * @Route("/season", name="app_season")
     */
    public function index(SeasonRepository $seasonRepository): Response
    {
        $seasons = $seasonRepository->findAll();
        return $this->render('back/season/index.html.twig', [
            'seasons' => $seasons,
        ]);
    }

    /**
     * @Route("/seasonadd", name="app_back_season_add", methods={"GET", "POST"})
     */

    public function add(Request $request, SeasonRepository $seasonRepository): Response
    {
        $season = new Season();
        $form = $this->createForm(SeasonType::class, $season);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $seasonRepository->add($season, true);

            return $this->redirectToRoute('app_browse', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/season/add.html.twig', [
            'season' => $season,
            'form' => $form,
        ]);
    }
    /**
     * @Route("/{id}/editseason", name="app_back_season_edit", methods={"GET", "POST"})
     */
    public function edit(Season $season, Request $request, SeasonRepository $seasonRepository): Response
    {
        $form = $this->createForm(SeasonType::class, $season);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $seasonRepository->add($season, true);

            return $this->redirectToRoute('app_browse', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/season/edit.html.twig', [
            'season' => $season,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/seasonremove/{id}", name="app_back_season_delete", methods={"GET"})
     */
    public function delete($id, SeasonRepository $seasonRepository): Response
    {
        $season = $seasonRepository->find($id);
        $seasonRepository->remove($season, $flush = true);
        return $this->redirectToRoute('app_browse');
    }
}

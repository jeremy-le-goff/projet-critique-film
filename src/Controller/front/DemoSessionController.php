<?php

namespace App\Controller\front;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DemoSessionController extends AbstractController
{
    /**
     * @Route("/demo/session", name="app_demo_session")
     */
    public function index(Request $request): Response
    {

        $session = $request->getSession();
        dump($session);
        $username = $session->get('username');
        return $this->render('demo_session/index.html.twig', [
            'username' => $username,
        ]);
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @Route("/demo/session/add")
     */

    public function add(Request $request)
    {
        $session = $request->getSession();
        $session->set('username', 'jeremy-le-goff');
        return $this->redirectToRoute('app_demo_session');
    }
}

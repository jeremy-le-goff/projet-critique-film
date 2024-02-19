<?php

namespace App\Controller\front;

use DateTime;
use App\Entity\Movie;
use App\Entity\Season;
use App\Repository\GenreRepository;
use App\Repository\MovieRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MovieTestController extends AbstractController
{
    /**
     * Créer un movie dans la bdd
     * @Route("/movie/test", name="app_movie_test")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        // On stock le manager de doctrine dans l'objet $entityManager
        // C'est grace a lui qu'on va intéragir avec la base de donnée
        $entityManager = $doctrine->getManager();

        // On créer une instance de l'entité Movie
        $movie = new Movie();

        // On va parametrer le film qu'on veut ajouter en bdd
        // On définit le titre du film
        $movie->setTitle('Jurassic park');
        // On définit la durée du film
        $movie->setDuration(120); // Dure 95 min
        // On définit la date de sortie
        $movie->setReleaseDate(new DateTime('1990-06-19')); // Classe DateTime pour créer une date au bon format (sinon erreur sql)
        $movie->setType("Film");
        $movie->setSummary("Ne pas réveiller le chat qui dort... C'est ce que le milliardaire John Hammond aurait dû se rappeler avant de se lancer dans le 'clonage' de dinosaures.");
        $movie->setSynopsis("Ne pas réveiller le chat qui dort... C'est ce que le milliardaire John Hammond aurait dû se rappeler avant de se lancer dans le 'clonage' de dinosaures. C'est à partir d'une goutte de sang absorbée par un moustique fossilisé que John Hammond et son équipe ont réussi à faire renaître une dizaine d'espèces de dinosaures. Il s'apprête maintenant avec la complicité du docteur Alan Grant, paléontologue de renom, et de son amie Ellie, à ouvrir le plus grand parc à thème du monde. Mais c'était sans compter la cupidité et la malveillance de l'informaticien Dennis Nedry, et éventuellement des dinosaures, seuls maîtres sur l'île...");
        $movie->setPoster("https://fr.web.img4.acsta.net/pictures/20/07/21/16/53/1319265.jpg");
        $movie->setRating(3.7);

        dump($movie);
        // On prépare la data => ATTENTION ici on envoie encore rien au serveur de bdd
        $entityManager->persist($movie);
        // Ci dessous on éxécute la requete
        // flush() ne prends aucun parametre car il va executer TOUTES les requetes attendues (tous ce qui a été persist($data))
        $entityManager->flush();

        return $this->render('movie_test/index.html.twig', [
            'controller_name' => 'MovieTestController',
        ]);
    }

    /**
     * Ajoute une serie et lui associe 2 saisons
     *
     * @Route("/test/serie/add")
     */
    public function addSerie(ManagerRegistry $doctrine)
    {
        $entityManager = $doctrine->getManager();

        // On créer une instance de l'entité Movie pour créer notre serie
        $movie = new Movie();
        // On va parametrer cet objet pour que ce soit Steanger Things
        $movie->setTitle('Stranger Things');
        // On définit la durée du film
        $movie->setDuration(55); // Dure 95 min
        // On définit la date de sortie
        $movie->setReleaseDate(new DateTime('2015-06-19')); // Classe DateTime pour créer une date au bon format (sinon erreur sql)
        $movie->setType("Série");
        $movie->setSummary("A Hawkins, en 1983 dans l'Indiana. Lorsque Will Byers disparaît de son domicile, ses amis se lancent dans une recherche semée d’embûches pour le retrouver.");
        $movie->setSynopsis(" Dans leur quête de réponses, les garçons rencontrent une étrange jeune fille en fuite. Les garçons se lient d'amitié avec la demoiselle tatouée du chiffre '11' sur son poignet et au crâne rasé et découvrent petit à petit les détails sur son inquiétante situation. Elle est peut-être la clé de tous les mystères qui se cachent dans cette petite ville en apparence tranquille…");
        $movie->setPoster("https://fr.web.img4.acsta.net/pictures/22/05/18/14/31/5186184.jpg");
        $movie->setRating(2.7);

        // Maintenant on va créer 2 objet Season, pour les associer à notre objet $movie
        // En d'autres termes : on va ajouter 2 saisons a Stranger Things

        // On créer une instance de Season pour la saison 1
        $s1 = new Season();
        $s1->setNumber(1); // Numero de la saison
        $s1->setEpisodesNumber(8); // Nombre d'épisode dans la saison
        // On associe cette saison à stranger Things
        $s1->setMovie($movie);

        // Meme principe pour la saison 2
        $s2 = new Season();
        $s2->setNumber(2); // Numero de la saison
        $s2->setEpisodesNumber(10); // Nombre d'épisode dans la saison
        // On associe cette saison à stranger Things
        $s2->setMovie($movie);
        // Pour faire l'association : soit tu part de  season et tu fais SetMovie soit de movie tu ferais addSeason

        // On persiste $movie, $s1 et $s2
        $entityManager->persist($movie);
        $entityManager->persist($s1);
        $entityManager->persist($s2);
        // Maintenant on peut flush (qu'une fois, car flush va executer TOUTES les requetes SQL attendues => donc tous ce qu'on a persist juste avant)
        $entityManager->flush();
        // Redirection vers la home
        return $this->redirectToRoute("home");
    }

    /**
     * Affiche tous les movie de ma bdd
     * @Route("/test/showall", name="test_show_all")
     */
    public function showAll(MovieRepository $movieRepository)
    {
        // On stock dans $movies TOUS les films de la table movie
        $movies = $movieRepository->findAll();
        dump($movies);
    }
}

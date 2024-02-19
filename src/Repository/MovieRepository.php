<?php

namespace App\Repository;

use App\Entity\Movie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Movie>
 *
 * @method Movie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Movie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Movie[]    findAll()
 * @method Movie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovieRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Movie::class);
    }

    public function add(Movie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Movie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllOrderByAscDql()
    {
        // on a besoin du Manager pour créer une requête avec Doctrine
        // Sur symfony, a chaque fois qu'on veut manipuler des donneés via nos entités Doctrine, ona besoin de l'entityManager
        $em = $this->getEntityManager();
        // on construit la requête DQL
        $query = $em->createQuery(
            // SELECT tous les objets movie depuis l'entité Movie
            // C'est au moment de l'alias (AS m) qu'on définit le m (on aurait pu le nommer brouette)
            // classés par titre (title) croissant
            'SELECT m 
           FROM App\Entity\Movie 
           AS m 
           ORDER BY m.title ASC'
        );
        // Pour l'instant ona  juste construit la requête DQL
        // Maintenant on va l'executer
        $movies = $query->getResult();
        return $movies;
    }

    public function findAllOrderByReleaseDateDql()
    {
        $em = $this->getEntityManager();
        // On stock le queryBuilder (le constructeur de requete DQL) dans $$qb
        $qb = $em->createQueryBuilder();
        // Maintenant, on va construire notre requête a l'aide du Query Builder de Doctrine
        $dql = $qb->select('m') // SELECT m
            ->from('App\Entity\Movie', 'm') // FROM App\Entity\Movie AS m
            ->orderBy('m.release_date', 'DESC'); // ORDER BY m.release_date DESC
        // Ci dessus et ci dessous => EXACTEMENT LA MEME CHOSE
        // SELECT * FROM movie ORDER BY release_date DESC;
        // $query = $em->createQuery(
        //     'SELECT m
        //     FROM App\Entity\Movie
        //     AS m
        //     ORDER BY m.release_date DESC'
        // );
        $query = $dql->getQuery();
        dump($query);
        $movies = $query->getResult();
        return $movies;
    }

    //    /**
    //     * @return Movie[] Returns an array of Movie objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('m.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Movie
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }


}

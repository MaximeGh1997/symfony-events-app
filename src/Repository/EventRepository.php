<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    // fonction pour récupérer les derniers événement ajouté sur le site
    public function findLastsAddEvents($limit = null){
        return $this->createQueryBuilder('e')
                    ->select('e')
                    ->orderBy('e.createdAt','DESC')
                    ->setMaxResults($limit)
                    ->getQuery()
                    ->getResult();
    }

    // fonction pour récupérer les prochains événements qui auront lieu
    public function findEventsByDate($limit = null){
        return $this->createQueryBuilder('e')
                    ->select('e')
                    ->orderBy('e.date','ASC')
                    ->setMaxResults($limit)
                    ->getQuery()
                    ->getResult();
    }

    // fonction pour récupérer les prochains événements qui auront lieu + filtrer par type
    public function findEventsByDateAndType($type, $limit = null){
        return $this->createQueryBuilder('e')
                    ->select('e')
                    ->where('e.type = :type')
                    ->orderBy('e.date','ASC')
                    ->setParameter('type', $type)
                    ->setMaxResults($limit)
                    ->getQuery()
                    ->getResult();
    }

    // /**
    //  * @return Event[] Returns an array of Event objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Event
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

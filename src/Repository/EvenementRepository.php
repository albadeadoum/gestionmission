<?php

namespace App\Repository;

use App\Entity\Evenement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Evenement>
 *
 * @method Evenement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evenement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evenement[]    findAll()
 * @method Evenement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvenementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Evenement::class);
    }

    public function save(Evenement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Evenement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Evenement[] Returns an array of Evenement objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Evenement
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

public function isVehiculeAvailable($vehicule, $debut, $fin)
    {
        // Requête pour vérifier la disponibilité du véhicule
        // Assurez-vous que les noms des propriétés et des tables correspondent à votre modèle de données
        $qb = $this->createQueryBuilder('e');
        $qb->andWhere('e.Vehicule = :vehicule')
           ->andWhere('e.debut <= :fin')
           ->andWhere('e.fin >= :debut')
           ->setParameter('vehicule', $vehicule)
           ->setParameter('debut', $debut)
           ->setParameter('fin', $fin);

        $result = $qb->getQuery()->getResult();

        return empty($result);
    }

    public function isChauffeurAvailable($chauffeur, $debut, $fin)
    {
        // Requête pour vérifier la disponibilité du chauffeur
        // Assurez-vous que les noms des propriétés et des tables correspondent à votre modèle de données
        $qb = $this->createQueryBuilder('e');
        $qb->andWhere('e.Chauffeur = :chauffeur')
           ->andWhere('e.debut <= :fin')
           ->andWhere('e.fin >= :debut')
           ->setParameter('chauffeur', $chauffeur)
           ->setParameter('debut', $debut)
           ->setParameter('fin', $fin);

        $result = $qb->getQuery()->getResult();

        return empty($result);
    }
}

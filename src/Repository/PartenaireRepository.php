<?php

namespace App\Repository;

use App\Entity\Partenaire;
use ContainerUODnshT\get_ServiceLocator_JlyTfzMService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @extends ServiceEntityRepository<Partenaire>
 *
 * @method Partenaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Partenaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Partenaire[]    findAll()
 * @method Partenaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PartenaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Partenaire::class);
    }

    public function add(Partenaire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Partenaire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


   public function getFilters($statut, $search)
   {
       $qb =  $this->createQueryBuilder('p')
           ->where('p.nom LIKE :val')
           ->setParameter('val', '%'.$search.'%')
           ;

           if ($statut) {
            $qb
            ->andWhere('p.statut IN (:statut)')
           ->setParameter(':statut', is_array($statut)? array_values($statut): array())
           ;
           }

           return $qb
           ->getQuery()
           ->getResult()
       ;
   }



//    /**
//     * @return Partenaire[] Returns an array of Partenaire objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }
}

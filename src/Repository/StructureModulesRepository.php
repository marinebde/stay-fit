<?php

namespace App\Repository;

use App\Entity\StructureModules;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StructureModules>
 *
 * @method StructureModules|null find($id, $lockMode = null, $lockVersion = null)
 * @method StructureModules|null findOneBy(array $criteria, array $orderBy = null)
 * @method StructureModules[]    findAll()
 * @method StructureModules[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StructureModulesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StructureModules::class);
    }

    public function add(StructureModules $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(StructureModules $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return StructureModules[] Returns an array of StructureModules objects
     */
    public function findStructureModule($structureId): array
    {
        return $this->createQueryBuilder('s')
            ->join('s.structure', 'structure', 'WITH', 'structure = :structure')
            ->setParameter('structure', $structureId)
            ->orderBy('s.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }


    /**
     * @return StructureModules[] Returns an array of StructureModules objects
     */
    public function findbyStructureModule($structureId, $idModule): array
    {
        return $this->createQueryBuilder('s')
            ->join('s.structure', 'structure', 'WITH', 'structure = :structure')
            ->join('s.module', 'm', 'WITH', 'm = :m')
            ->andwhere('m.id = :m')
            ->setParameter('structure', $structureId)
            ->setParameter('m', $idModule)
            ->orderBy('s.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }


//    public function findOneBySomeField($value): ?StructureModules
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

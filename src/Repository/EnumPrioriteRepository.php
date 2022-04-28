<?php

namespace App\Repository;

use App\Entity\EnumPriorite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EnumPriorite>
 *
 * @method EnumPriorite|null find($id, $lockMode = null, $lockVersion = null)
 * @method EnumPriorite|null findOneBy(array $criteria, array $orderBy = null)
 * @method EnumPriorite[]    findAll()
 * @method EnumPriorite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnumPrioriteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnumPriorite::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(EnumPriorite $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(EnumPriorite $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return EnumPriorite[] Returns an array of EnumPriorite objects
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
    public function findOneBySomeField($value): ?EnumPriorite
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

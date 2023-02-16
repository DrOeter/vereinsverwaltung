<?php

namespace App\Repository;

use App\Entity\AccountActivity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AccountActivity>
 *
 * @method AccountActivity|null find($id, $lockMode = null, $lockVersion = null)
 * @method AccountActivity|null findOneBy(array $criteria, array $orderBy = null)
 * @method AccountActivity[]    findAll()
 * @method AccountActivity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AccountActivityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AccountActivity::class);
    }

    public function add(AccountActivity $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AccountActivity $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


   public function getSumOfAllAccountActivities(\DateTime $from, \DateTime $to)
   {
       $query = $this->createQueryBuilder('a')
           ->select('SUM(a.amount) as sum')
           ->andWhere('a.transactionDate BETWEEN :from AND :to')
           ->setParameter('from', $from->format('Y-m-d'))
           ->setParameter('to', $to->format('Y-m-d'))
           ->getQuery()
       ;

       $sumOfAllAcoountActivities = $query->getScalarResult();

       return $sumOfAllAcoountActivities[0]['sum'];
   }

//    public function findOneBySomeField($value): ?AccountActivity
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

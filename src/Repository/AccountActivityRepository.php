<?php

namespace App\Repository;

use App\Entity\Account;
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


   public function getSumOfAllAccountActivities(string $year, Account $superadminAccount)
   {
        $year .= '-%';
        $qb = $this->createQueryBuilder('a');

       $query = $this->createQueryBuilder('a')
           ->select('SUM(a.amount) as sum')
           ->where('a.account = :superadminAccount')
           ->setParameter('superadminAccount', $superadminAccount)
           ->andWhere(
                $qb->expr()->like('a.transactionDate', ':year')
           )
            ->setPArameter('year', $year)
           ->getQuery()
       ;

       $sumOfAllAcoountActivities = $query->getScalarResult();
       dump($sumOfAllAcoountActivities);
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

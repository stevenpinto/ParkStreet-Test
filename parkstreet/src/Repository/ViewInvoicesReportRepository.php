<?php

namespace App\Repository;

use App\Entity\ViewInvoicesReport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ViewInvoicesReport|null find($id, $lockMode = null, $lockVersion = null)
 * @method ViewInvoicesReport|null findOneBy(array $criteria, array $orderBy = null)
 * @method ViewInvoicesReport[]    findAll()
 * @method ViewInvoicesReport[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ViewInvoicesReportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ViewInvoicesReport::class);
    }

    /**
     * @return ViewInvoicesReport[] Returns an array of ViewInvoicesReport objects
     */
    public function findByFilters(string $dateTo, string $dateFrom = null, string $clientId = null, string $productId = null)
    {
        $qb = $this->createQueryBuilder('ir');

        if (!!$dateFrom) {
            $qb->andWhere($qb->expr()->between('ir.invoice_date', ':dateFrom', ':dateTo'))
            ->setParameter('dateFrom', $dateFrom)
            ->setParameter('dateTo', $dateTo);
        } else {
            $qb->andWhere('ir.invoice_date <= :date')
            ->setParameter('date', $dateTo);
        }

        if (!!$clientId) {
            $qb->andWhere('ir.client_id = :clientId')
            ->setParameter('clientId', $clientId);
        }

        if (!!$productId) {
            $qb->andWhere('ir.product_id = :productId')
            ->setParameter('productId', $productId);
        }

        return $qb->orderBy('ir.invoice_date', 'DESC')
                ->getQuery()
                ->getArrayResult();
    }

    /*
    public function findOneBySomeField($value): ?ViewInvoicesReport
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CustomerDepositRepository extends EntityRepository
{
    /**
     * @param array $days
     * @return mixed
     */
    public function findDepositsByDayCreation(array $days)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('deposit')
            ->from('AppBundle:CustomerDeposit', 'deposit')
            ->join('deposit.customerAccount', 'account')
            ->where('DAY(account.dateCreate) in (:days)')
            ->orderBy('account.dateCreate','ASC')
            ->setParameter('days',$days);

        return $qb->getQuery()->getResult();
    }
}
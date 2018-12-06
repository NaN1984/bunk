<?php

namespace AppBundle\Service;

use AppBundle\Entity\CustomerAccount as Account;
use Doctrine\ORM\EntityManagerInterface;

class CustomerAccount
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * CustomerAccount constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param Account $customerAccount
     * @param float $depositAmount
     */
    public function addToAmount(Account $customerAccount, float $depositAmount)
    {
        $newAmount = round($customerAccount->getAmount() + $depositAmount, 3);

        $customerAccount->setAmount($newAmount);
        $this->entityManager->flush($customerAccount);
    }

    /**
     * @param Account $customerAccount
     * @param float $depositAmount
     */
    public function reduceAmount(Account $customerAccount, float $depositAmount)
    {
        $newAmount = round($customerAccount->getAmount() - $depositAmount, 3);

        $customerAccount->setAmount($newAmount);
        $this->entityManager->flush($customerAccount);
    }
}

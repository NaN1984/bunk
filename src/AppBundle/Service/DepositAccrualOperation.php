<?php

namespace AppBundle\Service;

use AppBundle\Entity\CustomerDeposit;
use AppBundle\Entity\CustomerDepositOperation;
use AppBundle\Interfaces\DepositOperation;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class DepositAccrualOperation implements DepositOperation
{
    const LAST_DAY_ACCRUAL = "31";

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var CustomerAccount
     */
    private $customerAccount;

    /**
     * DepositAccrualOperation constructor.
     * @param EntityManagerInterface $entityManager
     * @param CustomerAccount $customerAccount
     */
    public function __construct(EntityManagerInterface $entityManager, CustomerAccount $customerAccount)
    {
        $this->entityManager = $entityManager;
        $this->customerAccount = $customerAccount;
    }

    /**
     * @param CustomerDeposit $customerDeposit
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function proceed(CustomerDeposit $customerDeposit)
    {
        $this->entityManager->beginTransaction();

        try {
            $depositAmount = $this->calculateAmount($customerDeposit);

            $depositOperation = new CustomerDepositOperation();
            $depositOperation->setAccountAmount($customerDeposit->getCustomerAccount()->getAmount());
            $depositOperation->setAmount($depositAmount);
            $depositOperation->setCustomerDeposit($customerDeposit);
            $depositOperation->setType(CustomerDepositOperation::TYPE_ACCRUAL);

            $this->entityManager->persist($depositOperation);
            $this->entityManager->flush($depositOperation);

            $this->customerAccount->addToAmount($customerDeposit->getCustomerAccount(), $depositAmount);

            $this->entityManager->commit();
        } catch (Exception $e) {
            $this->entityManager->rollback();
            throw $e;
        }
    }

    /**
     * @return array
     */
    public function getOperationDays(): array
    {
        $days = [date('d')];

        if (date("t") == date('d')) {
            $days[] = self::LAST_DAY_ACCRUAL;
        }

        return array_unique($days);
    }

    /**
     * @param CustomerDeposit $customerDeposit
     * @return float
     */
    private function calculateAmount(CustomerDeposit $customerDeposit): float
    {
        $amount = round(
            $customerDeposit->getCustomerAccount()->getAmount() * $customerDeposit->getPercent() / 100, 3
        );

        return $amount;
    }
}

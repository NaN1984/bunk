<?php

namespace AppBundle\Service;

use AppBundle\Entity\CustomerDeposit;
use AppBundle\Entity\CustomerDepositOperation;
use AppBundle\Interfaces\DepositExpenditureChainBuilder;
use AppBundle\Interfaces\DepositOperation;
use AppBundle\Service\DepositCalculateExpenditureChain\ChainBuilder;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class DepositExpenditureOperation implements DepositOperation
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var CustomerAccount
     */
    private $customerAccount;

    /**
     * @var ChainBuilder
     */
    private $chainBuilder;

    /**
     * DepositExpenditureOperation constructor.
     * @param EntityManagerInterface $entityManager
     * @param CustomerAccount $customerAccount
     * @param DepositExpenditureChainBuilder $chainBuilder
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        CustomerAccount $customerAccount,
        DepositExpenditureChainBuilder $chainBuilder
    ) {
        $this->entityManager = $entityManager;
        $this->customerAccount = $customerAccount;
        $this->chainBuilder = $chainBuilder;
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
            $depositOperation->setType(CustomerDepositOperation::TYPE_EXPENDITURE);

            $this->entityManager->persist($depositOperation);
            $this->entityManager->flush($depositOperation);

            $this->customerAccount->reduceAmount($customerDeposit->getCustomerAccount(), $depositAmount);

            $this->entityManager->commit();
        } catch (Exception $e) {
            $this->entityManager->rollback();
            throw $e;
        }
    }

    /**
     * @param CustomerDeposit $customerDeposit
     * @return float
     */
    private function calculateAmount(CustomerDeposit $customerDeposit): float
    {
        $calculateExpenditureChain = $this->chainBuilder->getChain();

        $amount = $calculateExpenditureChain->calculateExpenditureAmount(
            $customerDeposit->getCustomerAccount()->getAmount()
        );

        if ($this->isPart($customerDeposit)) {
            return $this->calculateAmountPart($amount, $customerDeposit);
        }

        return $amount;
    }

    /**
     * @param float $amount
     * @param CustomerDeposit $customerDeposit
     * @return float
     */
    private function calculateAmountPart(float $amount, CustomerDeposit $customerDeposit): float
    {
        $prevMonth = strtotime("-1 months");
        $prevMonthDaysCount = date('t', $prevMonth);
        $createDay = date('j', $customerDeposit->getCustomerAccount()->getDateCreate()->getTimestamp());

        return round($amount * (($prevMonthDaysCount - $createDay) / $prevMonthDaysCount), 3);
    }

    /**
     * @param CustomerDeposit $customerDeposit
     * @return bool
     */
    private function isPart(CustomerDeposit $customerDeposit): bool
    {
        $createMonth = date('n', $customerDeposit->getCustomerAccount()->getDateCreate()->getTimestamp());
        $prevMonth = date('n', strtotime("-1 months"));

        if ($prevMonth == $createMonth) {
            return true;
        }

        return false;
    }
}

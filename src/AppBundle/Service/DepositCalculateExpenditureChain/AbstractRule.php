<?php

namespace AppBundle\Service\DepositCalculateExpenditureChain;

abstract class AbstractRule
{
    /**
     * @var AbstractRule
     */
    private $next;

    /**
     * @param AbstractRule $next
     * @return AbstractRule
     */
    public function linkWith(AbstractRule $next): AbstractRule
    {
        $this->next = $next;

        return $next;
    }

    /**
     * @param float $accountAmount
     * @return float|null
     */
    public function calculateExpenditureAmount(float $accountAmount): ?float
    {
        if (! $this->next) {
            return null;
        }

        return $this->next->calculateExpenditureAmount($accountAmount);
    }
}

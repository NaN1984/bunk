<?php

namespace AppBundle\Service\DepositCalculateExpenditureChain;

class RuleAmount_1000_10000 extends AbstractRule
{
    const RULE_PERCENT = 6;

    /**
     * @param float $accountAmount
     * @return float|null
     */
    public function calculateExpenditureAmount(float $accountAmount): ?float
    {
        if($accountAmount >= 1000 && $accountAmount < 10000) {
            $amount = round($accountAmount * self::RULE_PERCENT / 100, 3);

            return $amount;
        }

        return parent::calculateExpenditureAmount($accountAmount);
    }
}

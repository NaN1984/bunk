<?php

namespace AppBundle\Service\DepositCalculateExpenditureChain;

class RuleAmount_10000 extends AbstractRule
{
    const RULE_PERCENT = 7;
    const RULE_MAX_AMOUNT = 5000;

    /**
     * @param float $accountAmount
     * @return float|null
     */
    public function calculateExpenditureAmount(float $accountAmount): ?float
    {
        if($accountAmount >= 10000) {
            $amount = round($accountAmount * self::RULE_PERCENT / 100, 3);

            if($amount > self::RULE_MAX_AMOUNT) {
                return self::RULE_MAX_AMOUNT;
            }

            return $amount;
        }

        return parent::calculateExpenditureAmount($accountAmount);
    }
}

<?php

namespace AppBundle\Service\DepositCalculateExpenditureChain;

 class RuleAmount_0_1000 extends AbstractRule
{
    const RULE_PERCENT = 5;
    const RULE_MIN_AMOUNT = 50;

     /**
      * @param float $accountAmount
      * @return float|null
      */
     public function calculateExpenditureAmount(float $accountAmount): ?float
    {
        if($accountAmount >= 0 && $accountAmount < 1000) {
            $amount = round($accountAmount * self::RULE_PERCENT / 100, 3);

            if($amount < self::RULE_MIN_AMOUNT) {
                return self::RULE_MIN_AMOUNT;
            }

            return $amount;
        }

        return parent::calculateExpenditureAmount($accountAmount);
    }
}

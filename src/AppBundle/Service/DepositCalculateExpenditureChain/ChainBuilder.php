<?php

namespace AppBundle\Service\DepositCalculateExpenditureChain;

use AppBundle\Interfaces\DepositExpenditureChainBuilder;

class ChainBuilder implements DepositExpenditureChainBuilder
{
    /**
     * @var RuleAmount_0_1000
     */
    private $ruleAmount_0_1000;

    /**
     * @var RuleAmount_1000_10000
     */
    private $ruleAmount_1000_10000;

    /**
     * @var RuleAmount_10000
     */
    private $ruleAmount10000;

    /**
     * ChainBuilder constructor.
     * @param RuleAmount_0_1000 $ruleAmount_0_1000
     * @param RuleAmount_1000_10000 $ruleAmount_1000_10000
     * @param RuleAmount_10000 $ruleAmount10000
     */
    public function __construct(
        RuleAmount_0_1000 $ruleAmount_0_1000,
        RuleAmount_1000_10000 $ruleAmount_1000_10000,
        RuleAmount_10000 $ruleAmount10000
    )
    {
        $this->ruleAmount_0_1000 = $ruleAmount_0_1000;
        $this->ruleAmount_1000_10000 = $ruleAmount_1000_10000;
        $this->ruleAmount10000 = $ruleAmount10000;
    }

    /**
     * @return AbstractRule
     */
    public function getChain(): AbstractRule
    {
        $chain = new $this->ruleAmount_0_1000();

        $chain
            ->linkWith(new $this->ruleAmount_1000_10000())
            ->linkWith(new $this->ruleAmount10000());

        return $chain;
    }
}

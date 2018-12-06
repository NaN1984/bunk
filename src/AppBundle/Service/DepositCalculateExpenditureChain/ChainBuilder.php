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
     * @param AbstractRule $ruleAmount_0_1000
     * @param AbstractRule $ruleAmount_1000_10000
     * @param AbstractRule $ruleAmount10000
     */
    public function __construct(
        AbstractRule $ruleAmount_0_1000,
        AbstractRule $ruleAmount_1000_10000,
        AbstractRule $ruleAmount10000
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

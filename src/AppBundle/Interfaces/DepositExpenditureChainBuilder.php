<?php

namespace AppBundle\Interfaces;

use AppBundle\Service\DepositCalculateExpenditureChain\AbstractRule;

interface DepositExpenditureChainBuilder
{
    public function getChain(): AbstractRule;
}
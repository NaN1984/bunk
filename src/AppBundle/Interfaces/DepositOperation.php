<?php

namespace AppBundle\Interfaces;

use AppBundle\Entity\CustomerDeposit;

interface DepositOperation
{
    public function proceed(CustomerDeposit $customerDeposit);
}
<?php

namespace Pav\Zed\Refund\Dependency\Facade;

interface RefundToTaxInterface
{

    /**
     * @param int $grossPrice
     * @param float $taxRate
     *
     * @return int
     */
    public function getTaxAmountFromGrossPrice($grossPrice, $taxRate);

}


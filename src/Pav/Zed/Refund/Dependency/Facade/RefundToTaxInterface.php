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

    /**
     * Specification:
     *  - Reset rounding error counter to 0
     *
     * @api
     *
     * @return void
     */
    public function resetAccruedTaxCalculatorRoundingErrorDelta();

}

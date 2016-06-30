<?php

namespace Pav\Zed\Refund\Business\Aggregator\Totals;

use Generated\Shared\Transfer\RefundTransfer;
use Generated\Shared\Transfer\TaxTotalTransfer;
use Pav\Zed\Refund\Dependency\Facade\RefundToTaxInterface;

class TaxTotal implements TotalAggregatorInterface
{

    /**
     * @var \Pav\Zed\Refund\Dependency\Facade\RefundToTaxInterface
     */
    protected $taxBridge;

    /**
     * @param \Pav\Zed\Refund\Dependency\Facade\RefundToTaxInterface $taxBridge
     */
    public function __construct(RefundToTaxInterface $taxBridge)
    {
        $this->taxBridge = $taxBridge;
    }

    /**
     * @param \Generated\Shared\Transfer\RefundTransfer $refundTransfer
     *
     * @return void
     */
    public function aggregate(RefundTransfer $refundTransfer)
    {
        $effectiveTaxRate = $this->getEffectiveTaxRate($refundTransfer);
        $effectiveTaxAmount = $this->taxBridge->getTaxAmountFromGrossPrice(
            $refundTransfer->getTotals()->getRefundTotal(),
            $effectiveTaxRate
        );

        $taxTotalTransfer = new TaxTotalTransfer();
        $taxTotalTransfer->setAmount($effectiveTaxAmount);
        $taxTotalTransfer->setTaxRate($effectiveTaxRate);

        $totalsTransfer = $refundTransfer->getTotals();
        $totalsTransfer->setTaxTotal($taxTotalTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\RefundTransfer $refundTransfer
     *
     * @return float|int
     */
    protected function getEffectiveTaxRate(RefundTransfer $refundTransfer)
    {
        $taxRates = $this->getTaxRates($refundTransfer->getItems());

        $totalTaxRate = array_sum($taxRates);
        if (empty($totalTaxRate)) {
            return 0;
        }

        $effectiveTaxRate = $totalTaxRate / count($taxRates);

        return $effectiveTaxRate;
    }

    /**
     * @param \ArrayObject|\Generated\Shared\Transfer\RefundItemTransfer[]$taxableItems
     *
     * @return int[]
     */
    protected function getTaxRates(\ArrayObject $taxableItems)
    {
        $taxRates = [];

        foreach ($taxableItems as $item) {
            if ($item->getTaxRate()) {
                $taxRates[] = $item->getTaxRate();
            }
        }

        return $taxRates;
    }

}

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
        $totals = $refundTransfer->getTotals();

        $groupedTaxTotals = $this->getGroupedTaxTotals($refundTransfer->getRefundItems());
        $taxTotalAmount = $this->getTaxTotalAmount($groupedTaxTotals);

        $totals->setTaxTotals($groupedTaxTotals);
        $totals->setTaxTotalAmount($taxTotalAmount);
    }

    /**
     * @param \ArrayObject|\Generated\Shared\Transfer\RefundItemTransfer[] $refundItems
     *
     * @return \ArrayObject
     */
    protected function getGroupedTaxTotals(\ArrayObject $refundItems)
    {
        $groupedTaxTotals = new \ArrayObject();

        foreach ($refundItems as $refundItem) {

            $taxRateIndex = (string)$refundItem->getTaxRate();

            if (!$groupedTaxTotals->offsetExists($taxRateIndex)) {
                $taxTotal = new TaxTotalTransfer();
                $taxTotal->setTaxRate($refundItem->getTaxRate());
                $groupedTaxTotals->offsetSet($taxRateIndex, $taxTotal);
            } else {
                $taxTotal = $groupedTaxTotals->offsetGet($taxRateIndex);
            }

            $taxTotalAmount = (int)$taxTotal->getAmount();
            $taxTotalAmount += $refundItem->getTaxAmountWithDiscount();

            $taxTotal->setAmount($taxTotalAmount);
        }

        return $groupedTaxTotals;
    }

    /**
     * @param \ArrayObject|\Generated\Shared\Transfer\TaxTotalTransfer[] $taxTotals
     *
     * @return int
     */
    protected function getTaxTotalAmount(\ArrayObject $taxTotals)
    {
        $taxTotalAmount = 0;

        foreach ($taxTotals as $taxTotal) {
            $taxTotalAmount += $taxTotal->getAmount();
        }

        return $taxTotalAmount;
    }

}

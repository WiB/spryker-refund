<?php

namespace Pav\Zed\Refund\Business\Aggregator\Totals;

use Generated\Shared\Transfer\RefundTransfer;

class SubTotal implements TotalAggregatorInterface
{

    /**
     * @param \Generated\Shared\Transfer\RefundTransfer $refundTransfer
     *
     * @return void
     */
    public function aggregate(RefundTransfer $refundTransfer)
    {
        $subTotal = 0;

        foreach ($refundTransfer->getItems() as $item) {
            $item->requireTotalGrossPrice();
            $subTotal += $item->getTotalGrossPrice();
        }

        $refundTransfer->getTotals()->setSubTotal($subTotal);
    }

}

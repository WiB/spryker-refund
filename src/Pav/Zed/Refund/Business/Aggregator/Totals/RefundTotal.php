<?php

namespace Pav\Zed\Refund\Business\Aggregator\Totals;

use Generated\Shared\Transfer\RefundTransfer;

class RefundTotal implements TotalAggregatorInterface
{

    /**
     * @param \Generated\Shared\Transfer\RefundTransfer $refundTransfer
     *
     * @return void
     */
    public function aggregate(RefundTransfer $refundTransfer)
    {
        $refundTotals = $refundTransfer->getTotals();

        $subTotal = $refundTotals->getSubTotal();
        $discountTotal = $refundTotals->getDiscountTotal();

        $refundTotal = $subTotal - $discountTotal;

        $refundTotals->setRefundTotal($refundTotal);
    }

}

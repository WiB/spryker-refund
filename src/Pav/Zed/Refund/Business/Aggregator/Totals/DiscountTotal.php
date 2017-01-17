<?php

namespace Pav\Zed\Refund\Business\Aggregator\Totals;

use Generated\Shared\Transfer\RefundTransfer;

class DiscountTotal implements TotalAggregatorInterface
{

    /**
     * @param \Generated\Shared\Transfer\RefundTransfer $refundTransfer
     *
     * @return void
     */
    public function aggregate(RefundTransfer $refundTransfer)
    {
        $discountTotal = 0;

        foreach ($refundTransfer->getRefundItems() as $itemTransfer) {
            $discountTotal += $itemTransfer->getDiscountAmount();
        }

        $refundTransfer->getTotals()->setDiscountTotal($discountTotal);
    }

}

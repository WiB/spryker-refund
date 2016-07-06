<?php

namespace Pav\Zed\Refund\Business\Aggregator\Item;

use Generated\Shared\Transfer\RefundItemTransfer;

class ItemDiscount implements ItemAggregatorInterface
{

    /**
     * @param \Generated\Shared\Transfer\RefundItemTransfer $itemTransfer
     *
     * @return void
     */
    public function aggregate(RefundItemTransfer $itemTransfer)
    {
        $totalGrossPriceWithDiscount = $itemTransfer->getTotalGrossPrice() - $itemTransfer->getDiscountAmount();

        $itemTransfer->setTotalGrossPriceWithDiscount($totalGrossPriceWithDiscount);
    }

}

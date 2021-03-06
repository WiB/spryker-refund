<?php

namespace Pav\Zed\Refund\Business\Aggregator\Item;

use Generated\Shared\Transfer\RefundItemTransfer;

class ItemAmount implements ItemAggregatorInterface
{

    /**
     * @param \Generated\Shared\Transfer\RefundItemTransfer $itemTransfer
     *
     * @return void
     */
    public function aggregate(RefundItemTransfer $itemTransfer)
    {
        $itemTransfer
            ->requireQuantity()
            ->requireGrossPrice();

        $itemTransfer->setTotalGrossPrice($itemTransfer->getGrossPrice() * $itemTransfer->getQuantity());
    }

}

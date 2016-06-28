<?php

namespace Pav\Zed\Refund\Business\Aggregator\Item;

use Generated\Shared\Transfer\RefundItemTransfer;

class ItemAmount
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

        $itemTransfer->setGrossPrice($itemTransfer->getGrossPrice() * $itemTransfer->getQuantity());
    }

}

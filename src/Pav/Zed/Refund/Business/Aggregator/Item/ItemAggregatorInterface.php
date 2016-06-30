<?php


namespace Pav\Zed\Refund\Business\Aggregator\Item;

use Generated\Shared\Transfer\RefundItemTransfer;

interface ItemAggregatorInterface
{

    /**
     * @param \Generated\Shared\Transfer\RefundItemTransfer $itemTransfer
     *
     * @return void
     */
    public function aggregate(RefundItemTransfer $itemTransfer);

}

<?php

namespace Pav\Zed\Refund\Business\Aggregator;

use Generated\Shared\Transfer\RefundItemTransfer;
use Generated\Shared\Transfer\RefundTransfer;

interface RefundTotalsAggregatorInterface
{

    /**
     * @param \Generated\Shared\Transfer\RefundTransfer $refundTransfer
     *
     * @return \Generated\Shared\Transfer\RefundTransfer
     */
    public function aggregate(RefundTransfer $refundTransfer);

    /**
     * @param \Generated\Shared\Transfer\RefundItemTransfer $itemTransfer
     *
     * @return \Generated\Shared\Transfer\RefundItemTransfer
     */
    public function aggregateItem(RefundItemTransfer $itemTransfer);

}

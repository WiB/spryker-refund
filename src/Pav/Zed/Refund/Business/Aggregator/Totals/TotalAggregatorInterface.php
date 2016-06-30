<?php


namespace Pav\Zed\Refund\Business\Aggregator\Totals;

use Generated\Shared\Transfer\RefundTransfer;

interface TotalAggregatorInterface
{

    /**
     * @param \Generated\Shared\Transfer\RefundTransfer $refundTransfer
     *
     * @return void
     */
    public function aggregate(RefundTransfer $refundTransfer);

}

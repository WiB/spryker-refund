<?php

namespace Pav\Zed\Refund\Dependency\Plugin;

use Generated\Shared\Transfer\RefundTransfer;

interface RefundAggregatorPluginInterface
{

    /**
     * @param \Generated\Shared\Transfer\RefundTransfer $refundTransfer
     *
     * @return void
     */
    public function aggregate(RefundTransfer $refundTransfer);

}

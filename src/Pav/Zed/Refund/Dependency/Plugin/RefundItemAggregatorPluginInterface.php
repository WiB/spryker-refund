<?php

namespace Pav\Zed\Refund\Dependency\Plugin;

use Generated\Shared\Transfer\RefundItemTransfer;

interface RefundItemAggregatorPluginInterface
{

    /**
     * @param \Generated\Shared\Transfer\RefundItemTransfer $itemTransfer
     *
     * @return void
     */
    public function aggregate(RefundItemTransfer $itemTransfer);

}

<?php

namespace Pav\Zed\Refund\Communication\Plugin\Aggregator;

use Generated\Shared\Transfer\RefundItemTransfer;
use Pav\Zed\Refund\Dependency\Plugin\RefundItemAggregatorPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \Pav\Zed\Refund\Business\RefundFacade getFacade()
 */
class ItemAmountPlugin extends AbstractPlugin implements RefundItemAggregatorPluginInterface
{

    /**
     * @param \Generated\Shared\Transfer\RefundItemTransfer $itemTransfer
     *
     * @return void
     */
    public function aggregate(RefundItemTransfer $itemTransfer)
    {
        $this->getFacade()->aggregateItemAmount($itemTransfer);
    }

}

<?php

namespace Pav\Zed\Refund\Communication\Plugin\Aggregator;

use Generated\Shared\Transfer\RefundTransfer;
use Pav\Zed\Refund\Dependency\Plugin\RefundAggregatorPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \Pav\Zed\Refund\Business\RefundFacade getFacade()
 */
class SubTotalPlugin extends AbstractPlugin implements RefundAggregatorPluginInterface
{

    /**
     * @param \Generated\Shared\Transfer\RefundTransfer $refundTransfer
     *
     * @return void
     */
    public function aggregate(RefundTransfer $refundTransfer)
    {
        $this->getFacade()->aggregateSubTotal($refundTransfer);
    }

}

<?php

namespace Pav\Zed\Refund\Business\Aggregator;

use Generated\Shared\Transfer\RefundItemTransfer;
use Generated\Shared\Transfer\RefundTotalsTransfer;
use Generated\Shared\Transfer\RefundTransfer;
use Pav\Zed\Refund\Dependency\Plugin\RefundAggregatorPluginInterface;
use Pav\Zed\Refund\Dependency\Plugin\RefundItemAggregatorPluginInterface;

class RefundTotalsAggregator implements RefundTotalsAggregatorInterface
{

    /**
     * @var \Pav\Zed\Refund\Dependency\Plugin\RefundAggregatorPluginInterface[]
     */
    protected $aggregatorStack = [];

    /**
     * @var \Pav\Zed\Refund\Dependency\Plugin\RefundItemAggregatorPluginInterface[]
     */
    protected $itemAggregatorStack = [];

    /**
     * @param \Pav\Zed\Refund\Dependency\Plugin\RefundAggregatorPluginInterface[] $aggregatorStack
     * @param \Pav\Zed\Refund\Dependency\Plugin\RefundItemAggregatorPluginInterface[] $itemAggregatorStack
     */
    public function __construct(array $aggregatorStack, array $itemAggregatorStack)
    {
        foreach ($aggregatorStack as $aggregator) {
            $this->addAggregatorToStack($aggregator);
        }

        foreach ($itemAggregatorStack as $itemAggregator) {
            $this->addItemAggregatorToStack($itemAggregator);
        }
    }

    /**
     * @param \Generated\Shared\Transfer\RefundTransfer $refundTransfer
     *
     * @return \Generated\Shared\Transfer\RefundTransfer
     */
    public function aggregate(RefundTransfer $refundTransfer)
    {
        $this->addTotalsTransfer($refundTransfer);

        foreach ($this->itemAggregatorStack as $itemAggregator) {
            $this->aggregateItems($refundTransfer, $itemAggregator);
        }

        foreach ($this->aggregatorStack as $aggregator) {
            $aggregator->aggregate($refundTransfer);
        }

        return $refundTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\RefundItemTransfer $itemTransfer
     *
     * @return \Generated\Shared\Transfer\RefundItemTransfer
     */
    public function aggregateItem(RefundItemTransfer $itemTransfer)
    {
        foreach ($this->itemAggregatorStack as $itemAggregator) {
            $itemAggregator->aggregate($itemTransfer);
        }

        return $itemTransfer;
    }

    /**
     * @param \Pav\Zed\Refund\Dependency\Plugin\RefundAggregatorPluginInterface $aggregator
     *
     * @return void
     */
    protected function addAggregatorToStack(RefundAggregatorPluginInterface $aggregator)
    {
        $this->aggregatorStack[] = $aggregator;
    }

    /**
     * @param \Pav\Zed\Refund\Dependency\Plugin\RefundItemAggregatorPluginInterface $itemAggregator
     *
     * @return void
     */
    protected function addItemAggregatorToStack(RefundItemAggregatorPluginInterface $itemAggregator)
    {
        $this->itemAggregatorStack[] = $itemAggregator;
    }

    /**
     * @param \Generated\Shared\Transfer\RefundTransfer $refundTransfer
     * @param \Pav\Zed\Refund\Dependency\Plugin\RefundItemAggregatorPluginInterface $itemAggregator
     *
     * @return void
     */
    protected function aggregateItems(RefundTransfer $refundTransfer, RefundItemAggregatorPluginInterface $itemAggregator)
    {
        foreach ($refundTransfer->getRefundItems() as $item) {
            $itemAggregator->aggregate($item);
        }
    }

    /**
     * @param \Generated\Shared\Transfer\RefundTransfer $refundTransfer
     *
     * @return void
     */
    protected function addTotalsTransfer(RefundTransfer $refundTransfer)
    {
        $totalsTransfer = new RefundTotalsTransfer();
        $refundTransfer->setTotals($totalsTransfer);
    }

}

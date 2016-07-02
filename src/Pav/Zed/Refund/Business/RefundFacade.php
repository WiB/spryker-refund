<?php

namespace Pav\Zed\Refund\Business;

use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\RefundItemTransfer;
use Generated\Shared\Transfer\RefundTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \Pav\Zed\Refund\Business\RefundBusinessFactory getFactory()
 */
class RefundFacade extends AbstractFacade
{

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $order
     * @param \Generated\Shared\Transfer\ItemTransfer[] $orderItems
     *
     * @return \Generated\Shared\Transfer\RefundTransfer
     */
    public function createRefund(OrderTransfer $order, array $orderItems)
    {
        return $this->getFactory()->createOrderRefundManager()->createRefund($order, $orderItems);
    }

    public function updateRefund(RefundTransfer $refundTransfer)
    {
    }

    /**
     * @param \Generated\Shared\Transfer\RefundItemTransfer[] $refundItems
     *
     * @throws \Pav\Zed\Refund\Business\Exception\RefundItemNotFoundException
     * @return array
     */
    public function updateRefundItems(array $refundItems)
    {
        return $this->getFactory()->createRefundWriter()->createOrUpdateRefundItems($refundItems);
    }

    /**
     * @param int $idRefund
     *
     * @throws \Pav\Zed\Refund\Business\Exception\RefundNotFoundException
     * @return \Generated\Shared\Transfer\RefundTransfer
     */
    public function getRefund($idRefund)
    {
        return $this->getFactory()->createRefundReader()->getRefund($idRefund);
    }

    /**
     * @param \Generated\Shared\Transfer\RefundTransfer $refundTransfer
     *
     * @return void
     */
    public function aggregateDiscountTotal(RefundTransfer $refundTransfer)
    {
        $this->getFactory()->createDiscountTotalAggregator()->aggregate($refundTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\RefundTransfer $refundTransfer
     *
     * @return void
     */
    public function aggregateRefundTotal(RefundTransfer $refundTransfer)
    {
        $this->getFactory()->createRefundTotalAggregator()->aggregate($refundTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\RefundTransfer $refundTransfer
     *
     * @return void
     */
    public function aggregateSubTotal(RefundTransfer $refundTransfer)
    {
        $this->getFactory()->createSubTotalAggregator()->aggregate($refundTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\RefundTransfer $refundTransfer
     *
     * @return void
     */
    public function aggregateTaxTotal(RefundTransfer $refundTransfer)
    {
        $this->getFactory()->createTaxTotalAggregator()->aggregate($refundTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\RefundItemTransfer $itemTransfer
     *
     * @return void
     */
    public function aggregateItemTax(RefundItemTransfer $itemTransfer)
    {
        $this->getFactory()->createItemTaxAggregator()->aggregate($itemTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\RefundItemTransfer $itemTransfer
     *
     * @return void
     */
    public function aggregateItemDiscount(RefundItemTransfer $itemTransfer)
    {
        $this->getFactory()->createItemDiscountAggregator()->aggregate($itemTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\RefundItemTransfer $itemTransfer
     *
     * @return void
     */
    public function aggregateItemAmount(RefundItemTransfer $itemTransfer)
    {
        $this->getFactory()->createItemAmountAggregator()->aggregate($itemTransfer);
    }

}

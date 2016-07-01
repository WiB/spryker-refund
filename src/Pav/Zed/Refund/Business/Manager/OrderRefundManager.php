<?php

namespace Pav\Zed\Refund\Business\Manager;

use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\RefundItemTransfer;
use Generated\Shared\Transfer\RefundTransfer;
use Pav\Zed\Refund\Business\Writer\RefundWriterInterface;

class OrderRefundManager
{

    /**
     * @var \Pav\Zed\Refund\Business\Writer\RefundWriterInterface
     */
    protected $refundWriter;

    /**
     * @param \Pav\Zed\Refund\Business\Writer\RefundWriterInterface $refundWriter
     */
    public function __construct(RefundWriterInterface $refundWriter)
    {
        $this->refundWriter = $refundWriter;
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $order
     * @param \Generated\Shared\Transfer\ItemTransfer[] $orderItems
     *
     * @return \Generated\Shared\Transfer\RefundTransfer
     */
    public function createRefund(OrderTransfer $order, array $orderItems)
    {
        $refund = $this->createRefundTransfer($order);

        foreach ($orderItems as $orderItem) {

            $refundItem = $this->createRefundItem($orderItem);

            $refund->addItem($refundItem);
        }

        $refund = $this->refundWriter->writeRefund($refund);

        return $refund;
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $order
     *
     * @return \Generated\Shared\Transfer\RefundTransfer
     */
    protected function createRefundTransfer(OrderTransfer $order)
    {
        $refund = new RefundTransfer();

        $refund->setFkSalesOrder($order->getIdSalesOrder());

        return $refund;
    }

    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $orderItem
     *
     * @return \Generated\Shared\Transfer\RefundItemTransfer
     */
    protected function createRefundItem(ItemTransfer $orderItem)
    {
        $refundItem = new RefundItemTransfer();

        $refundItem->setFkSalesOrderItem($orderItem->getIdSalesOrderItem());
        $refundItem->setQuantity($orderItem->getQuantity());
        $refundItem->setGrossPrice($orderItem->getUnitGrossPrice());
        $refundItem->setDiscountAmount($orderItem->getSumTotalDiscountAmount());
        $refundItem->setName($orderItem->getName());
        $refundItem->setTaxRate($orderItem->getTaxRate());
        $refundItem->setTaxAmount($orderItem->getSumTaxAmount());

        return $refundItem;
    }

}

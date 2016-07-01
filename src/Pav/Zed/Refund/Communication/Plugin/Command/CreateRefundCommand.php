<?php

namespace Pav\Zed\Refund\Communication\Plugin\Command;

use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrder;
use Spryker\Zed\Oms\Business\Util\ReadOnlyArrayObject;
use Spryker\Zed\Oms\Communication\Plugin\Oms\Command\AbstractCommand;
use Spryker\Zed\Oms\Communication\Plugin\Oms\Command\CommandByOrderInterface;

/**
 * @method \Pav\Zed\Refund\Business\RefundFacade getFacade()
 */
class CreateRefundCommand extends AbstractCommand implements CommandByOrderInterface
{

    /**
     * @param array $orderItems
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $orderEntity
     * @param \Spryker\Zed\Oms\Business\Util\ReadOnlyArrayObject $data
     *
     * @return void
     */
    public function run(array $orderItems, SpySalesOrder $orderEntity, ReadOnlyArrayObject $data)
    {
        $itemTransfers = $this->getItemTransfers($orderItems);
        $orderTransfer = $this->getOrderTransfer($orderEntity);

        $this->getFacade()->createRefund($orderTransfer, $itemTransfers);
    }

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $orderEntity
     *
     * @return \Generated\Shared\Transfer\OrderTransfer
     */
    protected function getOrderTransfer(SpySalesOrder $orderEntity)
    {
        $orderTransfer = new OrderTransfer();
        $orderTransfer->fromArray($orderEntity->toArray(), true);

        return $orderTransfer;
    }

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem[] $orderItems
     *
     * @return array
     */
    protected function getItemTransfers(array $orderItems)
    {
        $itemTransfers = [];

        foreach ($orderItems as $orderItem) {
            $itemTransfer = new ItemTransfer();
            $itemTransfer->fromArray($orderItem->toArray(), true);
            $itemTransfer->setUnitGrossPrice($orderItem->getGrossPrice());

            $itemTransfers[] = $itemTransfer;
        }

        return $itemTransfers;
    }

}

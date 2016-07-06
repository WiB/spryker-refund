<?php

namespace Pav\Zed\Refund\Communication\Plugin\Command;

use Orm\Zed\Sales\Persistence\SpySalesOrder;
use Spryker\Zed\Oms\Business\Util\ReadOnlyArrayObject;
use Spryker\Zed\Oms\Communication\Plugin\Oms\Command\AbstractCommand;
use Spryker\Zed\Oms\Communication\Plugin\Oms\Command\CommandByOrderInterface;

/**
 * @method \Pav\Zed\Refund\Business\RefundFacade getFacade()
 */
class SuccessRefundCommand extends AbstractCommand implements CommandByOrderInterface
{

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem[] $orderItems
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $orderEntity
     * @param \Spryker\Zed\Oms\Business\Util\ReadOnlyArrayObject $data
     *
     * @return void
     */
    public function run(array $orderItems, SpySalesOrder $orderEntity, ReadOnlyArrayObject $data)
    {
        $itemIds = $this->getItemIds($orderItems);
        $refund = $this->getFacade()->getRefundForOrderItems($itemIds);

        $this->getFacade()->setRefundSuccessful($refund->getIdRefund());
    }

    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem[] $orderItems
     *
     * @return array
     */
    protected function getItemIds(array $orderItems)
    {
        $ids = [];

        foreach ($orderItems as $orderItem) {
            $ids[] = $orderItem->getIdSalesOrderItem();
        }

        return $ids;
    }

}

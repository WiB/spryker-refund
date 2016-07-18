<?php

namespace Pav\Zed\Refund\Persistence;

use Orm\Zed\Refund\Persistence\PavRefund;
use Orm\Zed\Refund\Persistence\PavRefundItem;
use Orm\Zed\Refund\Persistence\PavRefundItemQuery;
use Orm\Zed\Refund\Persistence\PavRefundQuery;
use Spryker\Zed\Kernel\Persistence\AbstractQueryContainer;

class RefundQueryContainer extends AbstractQueryContainer implements RefundQueryContainerInterface
{

    /**
     * @return \Orm\Zed\Refund\Persistence\PavRefund
     */
    public function createPavRefund()
    {
        return new PavRefund();
    }

    /**
     * @return \Orm\Zed\Refund\Persistence\PavRefundItem
     */
    public function createPavRefundItem()
    {
        return new PavRefundItem();
    }

    /**
     * @param int $idRefund
     *
     * @return \Orm\Zed\Refund\Persistence\PavRefundQuery
     */
    public function queryRefundById($idRefund)
    {
        $query = new PavRefundQuery();
        $query->filterByIdRefund($idRefund);

        return $query;
    }

    /**
     * @param int $idRefundItem
     *
     * @return \Orm\Zed\Refund\Persistence\PavRefundItemQuery
     */
    public function queryRefundItemById($idRefundItem)
    {
        $query = new PavRefundItemQuery();
        $query->filterByIdRefundItem($idRefundItem);

        return $query;
    }

    /**
     * @param int $idSalesOrder
     *
     * @return \Orm\Zed\Refund\Persistence\PavRefundQuery
     */
    public function queryRefundByIdSalesOrder($idSalesOrder)
    {
        $refundQuery = new PavRefundQuery();
        $refundQuery->filterByFkSalesOrder($idSalesOrder);

        return $refundQuery;
    }

    /**
     * @param \int[] $itemIds
     *
     * @return \Orm\Zed\Refund\Persistence\PavRefundQuery
     */
    public function queryRefundForOrderItems($itemIds)
    {
        $refundQuery = new PavRefundQuery();
        $refundQuery->useRefundItemQuery()
            ->filterByFkSalesOrderItem($itemIds)
            ->endUse()
            ->groupByIdRefund();

        return $refundQuery;
    }

}

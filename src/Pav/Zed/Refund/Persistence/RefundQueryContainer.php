<?php

namespace Pav\Zed\Refund\Persistence;

use Orm\Zed\Refund\Persistence\PavRefund;
use Orm\Zed\Refund\Persistence\PavRefundItem;
use Orm\Zed\Refund\Persistence\PavRefundItemQuery;
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

}
